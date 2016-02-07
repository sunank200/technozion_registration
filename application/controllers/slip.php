<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Slip extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library("nativesession");
        $this->load->model('user','',TRUE);
        $this->load->model('team','',TRUE);
        $this->load->model('wteam','',TRUE);
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
        $user = $this->user->get_details($this->nativesession->get('userid'));
        if($user->registration === '0')
        {
           $data['error'] ="You must pay Rs. 400 to generate the registration slip.";
        }
        else
        {
            $data['user'] = $user;
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
         $teamids = $this->user->get_teams_workshops($this->nativesession->get('userid'));
        $wteams = array();
        $count = 0;
        foreach ($teamids as $index => $teamid) {
            $teamid = $teamid["teamid"];
            $teamDetails = $this->wteam->get_details($teamid, 'array');
            $wteams[$teamid] = array("workshopName" => $teamDetails["wname"],
                                    "status" => $teamDetails["status"]);
            if ($teamDetails["status"] === "5") {
                $count++;
            }
            $wteams[$teamid]["users"] = array();
            for ($i=1; $i<=$teamDetails["tsize"]; $i++) {
                array_push($wteams[$teamid]["users"], $teamDetails["user".$i."name"]);
            }
        }
        $data['wteams'] = $wteams;
        $data['workshops'] = $this->user->get_teams_workshops($this->nativesession->get('userid'));
    }
        $data['current_page'] = "slip";
        $data['main_heading'] = "Registraion Slip";
        $data['side_heading'] = "Technozion ".date('y');
        $data['userDetails'] = $this->user->get_details($this->nativesession->get('userid'));
        $this->load->view('base/header', $data);
        $this->load->view('slip/index', $data);
        $this->load->view('base/footer', $data);
    }
};