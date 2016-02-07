<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Workshops extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('auth/ion_auth');
        if (!$this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }
        elseif (!$this->ion_auth->in_group('workshop', $this->ion_auth->get_user_id()))
        {
            redirect('auth/index', 'refresh');
        }
    }

    public function index()
    {
        $this->details();
    }

    public function details($type = '', $tzid = '')
    {
        $this->load->model('user', '', TRUE);
        $this->load->model('wteam', '', TRUE);
        $this->load->model('workshop', '', TRUE);

        $data['type'] = $type;

        if ($type !== '' && ($type === 'email' || $type === 'id')) {

            switch($tzid) {
                case '':
                    $data[$type] = $this->input->post('tzid');
                    break;
                default:
                    $data[$type] = $tzid;
                    break;
            }
            switch($type) {
                case 'email':
                    $userid = $this->user->get_userid($data[$type]);
                    if ($userid === FALSE) {
                        $data['error'] = "User ".$data[$type]." does not exist";
                    } else {
                        $data['userid'] = $userid;
                    }
                    break;
                case 'id':
                    $userid = $data[$type];
                    if ($this->user->exists($userid) === FALSE) {
                        $data['error'] = "User ".$data[$type]." does not exist";
                    } else {
                        $data['userid'] = $userid;
                    }
                    break;
            }


            if (!isset($data['error'])) {
                $teamids = $this->user->get_teams_workshops($userid);

                $teams = array();
                $count = 0;

                foreach ($teamids as $index => $teamid) {
                    $teamid = $teamid["teamid"];
                    $teamDetails = $this->wteam->get_details($teamid, 'array');
                    $teams[$teamid] = array("workshopName" => $teamDetails["wname"], "status" => $teamDetails["status"]);

                    if ($teamDetails["status"] === "5") {
                        $count++;
                    }

                    $teams[$teamid]["users"] = array();
                    for ($i=1; $i<=$teamDetails["tsize"]; $i++) {
                        array_push($teams[$teamid]["users"], $teamDetails["user".$i."name"]);
                    }
                }

                $data['teams'] = $teams;
                $data['workshopCount'] = $count;

            }

        }
    $data['current_page'] = "workshop";
        $this->load->view('menu/header', $data);
        $this->load->view('sidebar/sidebar');
        $this->load->view('workshops/index', $data);
        $this->load->view('menu/footer', $data);
    }

    public function register()
    {


        $data['scripts'] = array(asset_url()."js/workshop_register_onspot.js");
        $data['current_page'] = "workshop";
        $this->load->view('menu/header', $data);
        $this->load->view('sidebar/sidebar', $data);
        $this->load->view('workshops/register', $data);
        $this->load->view('menu/footer', $data);
    }


    public function registerteam()
    {
     $this->load->model('user', '', TRUE);
     $this->load->model('wteam', '', TRUE);
     $this->load->model('workshop', '', TRUE);

     $stat["status"] = "failure";
     $stat["message"] = "";

     $requestData = array();
     $numUsers = 0;
     $requestData["workshopid"] = $this->input->post("workshopid");
     $requestData["userids"] = array();
     $requestData["hospitality"] = array();
     $requestData["registration"] = array();
     $postLen = count($_POST);
     for ($i=1; $i < $postLen ; $i++) {
        if ($this->input->post('userid'.$i)) {
            $numUsers++;
            array_push($requestData["userids"], $this->input->post('userid'.$i));
        } else {
            break;
        }
    }

    if ($numUsers === 0) {
        $stat["message"] = "No data provided";
        echo json_encode($stat);
        return;
    }

    // Workshop Name
    $details = array();
    $details["workshopid"] = $requestData["workshopid"];
    $workshopDetails = $this->workshop->get_details($requestData["workshopid"]);

    if ($workshopDetails === false || $workshopDetails->wname == false) {
        $stat["message"] = "Workshop Not Valid";
        echo json_encode($stat);
        return;
    }
    $details["wname"] = $workshopDetails->wname;
    // Checking & filling in users
    $details["tsize"] = $numUsers;
    if ( !($numUsers >= $workshopDetails->min && $numUsers <= $workshopDetails->max) ) {
        $stat["message"] = "Minimum number team members: $workshopDetails->min maximum number of team members: $workshopDetails->max. Applied number: $numUsers";
        echo json_encode($stat);
        return;
    }
    foreach ($requestData["userids"] as $index => $userid) {
        $index = $index+1;
        $details["user".$index."id"] = $userid;
        $userName = $this->user->get_name($userid);
        if ($userName == false) {
            $stat["message"] = "invalid userid: $userid";
            echo json_encode($stat);
            return;
        }
        if ($this->user->in_workshop($userid, $details['workshopid']) === 1) {
            $stat["message"] = "User: $userid already registered for workshop";
            echo json_encode($stat);
            return;
        }
        $details["user".$index."name"] = $userName;
    }

    // ipaddress
    $details["ipaddress"] = $this->input->ip_address();

    $reserveSeat = $this->workshop->reserve_seat($details['workshopid']);

    if ($reserveSeat === true) {
        $details["status"] = 4;
    } else {
        $details["status"] = 0;
    }
        // create the team
    $teamId = $this->wteam->create($details, "workshop");

        // If waiting list
    if ($reserveSeat === false) {
            // Add team, workshop to individual users
        $workshopId = $requestData["workshopid"];
        foreach ($requestData["userids"] as $index => $userid) {
            $this->user->add_team_workshops($userid, $workshopId, $teamId);
        }

        $stat["status"] = "success";
        $stat['message'] = 'You are in Waiting List';
        echo json_encode($stat);
        return;
    }

    $this->wteam->update_count();
    $this->wteam->confirm($teamId);

    $teamDetails = $this->wteam->get_details($teamId, 'array');
    $tsize = $teamDetails['tsize'];

    // Adding transaction
    $tdata['receiptid'] = $this->input->post('receiptid');
    $tdata['userid'] = $this->input->post('userid1');
    $tdata['amount'] = $workshopDetails->cost;
    $tdata['remarks'] = $this->input->post('remarks');
    $tdata['workshopid'] = $requestData['workshopid'];
    $tdata['teamid'] = $teamId;
    $tdata['counter'] = 3;
    $tdata['verifiedid'] = $this->ion_auth->get_user_id();
    $tdata['ipaddress'] = $this->input->ip_address();

    $this->workshop->add_transaction($tdata);

    for ($i=1; $i <= $tsize; $i++) {
        $this->user->add_team_workshops($teamDetails['user'.$i.'id'], $requestData['workshopid'], $teamId);
    }

    redirect(base_url("/onspot/workshops/details/id/".$this->input->post('userid1')), 'location', 301);

}


}