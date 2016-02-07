<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Events extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library("nativesession");
        $this->load->model('user','',TRUE);
        $this->load->model('team','',TRUE);
        $this->load->model('event','',TRUE);
    }

    private function is_logged_in()
    {
        if ($this->nativesession->get('userid') === null) {
            return false;
        } else {
            if($this->user->profile_fill_check($this->nativesession->get('userid')))
                redirect(base_url("update_profile"), "location", 301);
            return true;
        }
    }

    public function index()
    {
        if (!$this->is_logged_in()) {
            redirect(base_url("home"), "location", 301);
            return;
        }

        // Getting teams a user is reg in
        $teamids = $this->user->get_teams_events($this->nativesession->get('userid'));
        $teams = array();
        foreach ($teamids as $index => $teamid) {
            $teamid = $teamid["teamid"];
            $teamDetails = $this->team->get_details($teamid, 'array');
            $teams[$teamid] = array("eventName" => $teamDetails["ename"], "status" => $teamDetails["status"], "status_name" => $teamDetails["status_name"]);
            $teams[$teamid]["users"] = array();
            $teams[$teamid]['userids'] = array();
            for ($i=1; $i<=$teamDetails["tsize"]; $i++) {
                array_push($teams[$teamid]["users"], $teamDetails["user".$i."name"]);
                array_push($teams[$teamid]["userids"], $teamDetails["user".$i."id"]);
            }

           if ($teamDetails["status"] !== '1') {
                $numreg = $this->user->num_registration($teams[$teamid]["userids"]);
                if (count($teams[$teamid]['userids']) != $numreg) {
                    $teams[$teamid]['count'] = $numreg;
                    $teams[$teamid]['total'] = count($teams[$teamid]['userids']);
                } else {
                    // confirming the team
                    $this->team->update_status($teamid, '1');
                    $teamDetails = $this->team->get_details($teamid, 'array');
                $teams[$teamid][] = array("eventName" => $teamDetails["ename"], "status" => $teamDetails["status"], "status_name" => $teamDetails["status_name"]);
                }
            }
        }


        $data['teams'] = $teams;
        $data['main_heading'] = "Events Registrations";
        $data['side_heading'] = "events descriptions @ <a href='http://events.technozion.org' target='_blank'>events.technozion.org</a>";
        $data['current_page'] = 'events';
        $data['userDetails'] = $this->user->get_details($this->nativesession->get('userid'));
        $data['teamids'] = $teamids;
        $this->load->view('base/header', $data);
        $this->load->view('events/index', $data);
        $this->load->view('base/footer', $data);
    }

    public function get_registered_events_mobile(){

        $userid=9346472;
       // $userid = $this->input->post('userid');


        $teamids = $this->user->get_teams_events($userid);
        $teams = array();
        foreach ($teamids as $index => $teamid) {
            $teamid = $teamid["teamid"];
            $teamDetails = $this->team->get_details($teamid, 'array');
            $teams[$teamid] = array("eventName" => $teamDetails["ename"], "status" => $teamDetails["status"], "status_name" => $teamDetails["status_name"]);
            $teams[$teamid]["users"] = array();
            $teams[$teamid]['userids'] = array();
            for ($i=1; $i<=$teamDetails["tsize"]; $i++) {
                array_push($teams[$teamid]["users"], $teamDetails["user".$i."name"]);
                array_push($teams[$teamid]["userids"], $teamDetails["user".$i."id"]);
            }

           if ($teamDetails["status"] !== '1') {
                $numreg = $this->user->num_registration($teams[$teamid]["userids"]);
                if (count($teams[$teamid]['userids']) != $numreg) {
                    $teams[$teamid]['count'] = $numreg;
                    $teams[$teamid]['total'] = count($teams[$teamid]['userids']);
                } else {
                    // confirming the team
                    $this->team->update_status($teamid, '1');
                    $teamDetails = $this->team->get_details($teamid, 'array');
                $teams[$teamid][] = array("eventName" => $teamDetails["ename"], "status" => $teamDetails["status"], "status_name" => $teamDetails["status_name"]);
                }
            }
        }


        $data['teams'] = $teams;
       // $data['main_heading'] = "Events Registrations";
       // $data['side_heading'] = "events descriptions @ <a href='http://events.technozion.org' target='_blank'>events.technozion.org</a>";
       // $data['current_page'] = 'events';
       // $data['userDetails'] = $this->user->get_details($this->nativesession->get('userid'));
        $data['teamids'] = $teamids;

        echo json_encode($data);


    }

    public function get_all_events_mobile(){

        $this->db->select()->from('events')->order_by('ename');
        $data['events'] =$this->db->get()->result_array();
        $store = array();
        foreach ($data['events'] as $row)
        {
            if($row['confirmation']==1)
                $store[] = $row;
        }
        echo json_encode($store);
        return ;

    }

    public function generate_eventnames_for_register(){

        $this->db->select()->from('events')->where('confirmation','1')->order_by('ename');
        $data['events']=$this->db->get()->result_array();
        $this->load->view('events/register', $data);

    }

    public function register($eventName = '')
    {
        // redirect(base_url(), "location", 301);
        if (!$this->is_logged_in()) {
            redirect(base_url("home"), "location", 301);
            return;
        }
        if ($eventName !== '') {
            ;
        }
        $data['selfDetails'] = $this->user->get_details($this->nativesession->get('userid'));
        $data['main_heading'] = "Events Registrations";
        $data['side_heading'] = "events descriptions @ <a href='http://events.technozion.org' target='_blank'>events.technozion.org</a>";
        $data['current_page'] = 'events';
        $data['userDetails'] = $this->user->get_details($this->nativesession->get('userid'));
        $data['scripts'] = array(asset_url()."js/event_register.js");
        $this->load->view('base/header', $data);
        $this->load->view('events/register', $data);
        $this->load->view('base/footer', $data);
    }


    public function registerteam()
    {
        $stat["status"] = "failure";
        $stat["message"] = "";
        // { "eventid": "12", "userids": ["123", "124", "125"]}
        $data = $this->input->post('registerData');
        if ($data === false) {
            $stat["message"] = "No data provided";
            echo json_encode($stat);
            return;
        }

        $data = json_decode($data, true);
        // Event Name
        $details = array();
        $details["eventid"] = $data["eventid"];
        $eventDetails = $this->event->get_details($data["eventid"]);

        if ($eventDetails === false || $eventDetails->ename == false) {
            $stat["message"] = "Event Not Valid";
            echo json_encode($stat);
            return;
        }

        $details["ename"] = $eventDetails->ename;
        if ($eventDetails->confirmation == 0) {
            // No need for confirmation. Set confirmed status
           // $details["status"] = 5; confirm status is 1 for event and 5 for wordkshop !!!
            $details["status"] = 4;
        }

        // Users
        $numUsers = count($data["userids"]);
        $details["tsize"] = $numUsers;
        if ($numUsers >= $eventDetails->min && $numUsers <= $eventDetails->max) {
            foreach ($data["userids"] as $index => $userid) {
                $index = $index+1;
                $details["user".$index."id"] = $userid;
                $userName = $this->user->get_name($userid);
                if ($userName == false) {
                    $stat["message"] = "invalid userid: $userid";
                    echo json_encode($stat);
                    return;
                } else {
                    if ($this->user->in_event($userid, $details['eventid']) === 1) {
                        $stat["message"] = "User: $userid already registered for event";
                        echo json_encode($stat);
                        return;
                    } else {
                        $details["user".$index."name"] = $userName;
                    }
                }
            }
        } else {
            $stat["message"] = "Minimum number team members: $eventDetails->min maximum number of team members: $eventDetails->max. Applied number: $numUsers";
            echo json_encode($stat);
            return;
        }
        // ipaddress
        $details["ipaddress"] = $this->input->ip_address();

        // create the team
        $teamId = $this->team->create($details);
        $eventId = $data["eventid"];
        foreach ($data["userids"] as $index => $userid) {
            $this->user->add_team_events($userid, $eventId, $teamId);
        }
        // Update
        $stat["status"] = "success";
        $stat['message'] = 'You have successfully registered for the event';
        echo json_encode($stat);
    }

   
    public function registerteam_mobile()
    {
        $stat["status"] = "failure";
        $stat["message"] = "";
        $data = "{\"userids\":\"[9346472, 1014551]\",\"eventid\":\"42\"}";
       // { "eventid": "12", "userids": ["123", "124", "125"]}
        //$data = $this->input->post('data');
        $confirm = $this->input->post('confirm');
        $details = array();
         
        if ($data === false) {
            $stat["message"] = "No data provided";
            echo json_encode($stat);
            return;
        }

        $data = json_decode($data, true);
    
        // Event Name
        $details = array();
        $stats["username"] = array();
        $stats["eventid"] = $data["eventid"];
        $stats["userids"] = array();
        $details["eventid"] = $data["eventid"];
        $eventDetails = $this->event->get_details($data["eventid"]);

        if ($eventDetails === false || $eventDetails->ename == false) {
            $stat["message"] = "Event Not Valid";
            echo json_encode($stat);
            return;
        }

        $details["ename"] = $eventDetails->ename;
        if ($eventDetails->confirmation == 0) {
            // No need for confirmation. Set confirmed status
           // $details["status"] = 5; confirm status is 1 for event and 5 for wordkshop !!!
            $details["status"] = 4;
        }

        // Users
        if($confirm == 0)
        $data["userids"] = json_decode($data["userids"],true);
        $numUsers = count($data["userids"]);
        $details["tsize"] = $numUsers;
        if ($numUsers >= $eventDetails->min && $numUsers <= $eventDetails->max) {
            foreach ($data["userids"] as $index => $userid) {
                $index = $index+1;
                $details["user".$index."id"] = $userid;
                $userName = $this->user->get_name($userid);
                if ($userName == false) {
                    $stat["message"] = "invalid userid: $userid";
                    echo json_encode($stat);
                    return;
                } else {
                    if ($this->user->in_event($userid, $details['eventid']) === 1) {
                        $stat["message"] = "User: $userid already registered for event";
                        echo json_encode($stat);
                        return;
                    } else {
                        $details["user".$index."name"] = $userName;
                        array_push($stats["username"],$userName);
                         array_push($stats["userids"],$userid);
                    }
                }
            }
        } else {
            $stat["message"] = "Minimum number team members: $eventDetails->min maximum number of team members: $eventDetails->max. Applied number: $numUsers";
            echo json_encode($stat);
            return;
        }


        if($confirm == 0)
        {
            $stats["status"] = "success";
            echo json_encode($stats);
            return ;
        }

        // ipaddress
        $details["ipaddress"] = $this->input->ip_address();

        // create the team
        $teamId = $this->team->create($details);
        $eventId = $data["eventid"];
        foreach ($data["userids"] as $index => $userid) {
            $this->user->add_team_events($userid, $eventId, $teamId);
        }

        // Update
        $stat["status"] = "success";
        $stat['message'] = 'You have successfully registered for the event';
        echo json_encode($stat);
    }



};