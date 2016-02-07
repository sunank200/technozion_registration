<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Workshops extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library("nativesession");
        $this->load->model('user','',TRUE);
        $this->load->model('wteam','',TRUE);
        $this->load->model('workshop','',TRUE);
        $this->load->model('transaction','',TRUE);
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
        $teamids = $this->user->get_teams_workshops($this->nativesession->get('userid'));
        //$teamids = $this->user->get_teams_workshops($this->nativesession->get('userid'));
        $teams = array();
        $count = 0;
        foreach ($teamids as $index => $teamid) {
            $teamid = $teamid["teamid"];
            $teamDetails = $this->wteam->get_details($teamid, 'array');
            $teams[$teamid] = array("workshopName" => $teamDetails["wname"],
                                    "status" => $teamDetails["status"]);
            if ($teamDetails["status"] === "5") {
                $count++;
            }
            $teams[$teamid]["users"] = array();
            
            // get all the user id and then collect individual registraitn status and hospitality status
            $userids = array();
            for ($i=1; $i<=$teamDetails["tsize"]; $i++) {
               $userids[] = $teamDetails["user".$i."id"];
            }
            // get all the team details (including registrations and hospitality details)
            $userDetails = $this->user->get_team_details($userids);
            for ($i=1; $i<=$teamDetails["tsize"]; $i++) {
               $teams[$teamid]["users"][$i-1]["name"] = $teamDetails["user".$i."name"];
               $teams[$teamid]["users"][$i-1]["registration"] = $userDetails[$i-1]["registration"];
               $teams[$teamid]["users"][$i-1]["hospitality"] = $userDetails[$i-1]["hospitality"];
            }
        }

        $data['teams'] = $teams;
        $data['workshopCount'] = $count;
        $data['main_heading'] = "Workshop Registrations";
        $data['side_heading'] = "Workshops description @ <a href='http://workshops.technozion.org' target='_blank'>workshops.technozion.org</a>";
        $data['current_page'] = 'workshops';
        $data['userDetails'] = $this->user->get_details($this->nativesession->get('userid'));
        $this->load->view('base/header', $data);
        $this->load->view('workshops/index_old', $data);
        $this->load->view('base/footer', $data);
    }
    
     public function get_registered_workshops_mobile(){

        $userid = 9346472;
        //$userid = $this->input->post('userid');
        $teamids = $this->user->get_teams_workshops($userid);
        $teams = array();
        $count = 0;
        foreach ($teamids as $index => $teamid) {
            $teamid = $teamid["teamid"];
            $teamDetails = $this->wteam->get_details($teamid, 'array');
            $teams[$teamid] = array("workshopName" => $teamDetails["wname"],
                                    "status" => $teamDetails["status"]);
            if ($teamDetails["status"] === "5") {
                $count++;
            }
            $teams[$teamid]["users"] = array();
            
            // get all the user id and then collect individual registraitn status and hospitality status
            $userids = array();
            for ($i=1; $i<=$teamDetails["tsize"]; $i++) {
               $userids[] = $teamDetails["user".$i."id"];
            }
            // get all the team details (including registrations and hospitality details)
            $userDetails = $this->user->get_team_details($userids);
            for ($i=1; $i<=$teamDetails["tsize"]; $i++) {
               $teams[$teamid]["users"][$i-1]["name"] = $teamDetails["user".$i."name"];
               $teams[$teamid]["users"][$i-1]["registration"] = $userDetails[$i-1]["registration"];
               $teams[$teamid]["users"][$i-1]["hospitality"] = $userDetails[$i-1]["hospitality"];
            }
        }

        $data['teams'] = $teams;
        //$data['workshopCount'] = $count;
        //$data['main_heading'] = "Workshop Registrations";
        //$data['side_heading'] = "Workshops description @ <a href='http://workshops.technozion.org' target='_blank'>workshops.technozion.org</a>";
        //$data['current_page'] = 'workshops';
        $data['userDetails'] = $this->user->get_details($this->nativesession->get('userid'));
        $data['teamids'] = $teamids ;

        echo json_encode($data);
        return;
        
     }

    public function get_all_workshops_mobile(){

          
       // $userid=$this->input->post('jsonValue');
       //  echo $userid ;

        $this->db->select()->from('workshops')->order_by('wname');
        $data['workshops'] =$this->db->get()->result_array();
        $store = array();
        foreach ($data['workshops'] as $row)
        {
            if($row['ccapacity'] >= $row['ccurrent'] + $row['min'])
                $store[] = $row;
        }


        echo json_encode($store);
        return ;

    }

    public function register($workshopName = '')
    {
//        redirect(base_url(), "location", 301);
        if (!$this->is_logged_in()) {
            redirect(base_url("home"), "location", 301);
            return;
        }
        if ($workshopName !== '') {
            ;
        }

        if ($this->input->get('error') !== null) {
            $data['error'] = $this->input->get('error');
        } else {
            $data['error'] = '';
        }
        
        

        $data['selfDetails'] = $this->user->get_details($this->nativesession->get('userid'));
        $data['main_heading'] = "Workshop Registrations";
        $data['side_heading'] = "Workshops description @ <a href='http://workshops.technozion.org' target='_blank'>workshops.technozion.org</a>";
        $data['title'] ="Workshops";
        $data['current_page'] = 'workshops';
        $data['userDetails'] = $this->user->get_details($this->nativesession->get('userid'));
        $data['scripts'] = array(asset_url()."js/workshop_register_test.js");

       // echo json_encode($data);
        $this->load->view('base/header', $data);
        $this->load->view('workshops/register', $data);
        $this->load->view('base/footer', $data);
    }
 
    public function registerteam()
    {
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
                if ($this->input->post('hospitality'.$i)) {
                    array_push($requestData["hospitality"], $this->input->post('userid'.$i));
                }
                // echo "ram ".print_r($this->user->get_registration($this->input->post('userid'.$i)))."<br>";
                if ($this->user->get_registration($this->input->post('userid'.$i))->registration === '0') {
                    // array_push($requestData["registration"], $this->user->get_registration('userid'.$i)['registration']);
                    array_push($requestData["registration"], $this->input->post('userid'.$i));
                }
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
         // echo print_r($requestData);
        // ECHO REGISTRATION_COST*count($requestData["registration"]);
        $data['payu'] = array();
        // finding amount
        $data['payu']['txnid'] = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
        $data['payu']['amount'] = 0;
        $data['payu']['amount'] += $workshopDetails->cost;
        $data['payu']['amount'] += HOSPITALITY_COST*count($requestData["hospitality"]);
        $data['payu']['amount'] += REGISTRATION_COST*count($requestData["registration"]);
        $data['payu']['amount'] = ceil(($data['payu']['amount'] * 100.0) / 97.0);
        // If seat available
        // Add transaction
        $this->transaction->add($data['payu']['txnid'], $this->nativesession->get('userid'),
            $requestData['workshopid'], $teamId, $requestData['registration'], $requestData['hospitality'], $data['payu']['amount']);
        // Merchant Salt as provided by Payu
        $data['payu']['salt'] = SALT;
        // Product Info
        $data['payu']['productinfo'] = "Technozion Registration";
        $mainUserDetails = $this->user->get_details($this->nativesession->get('userid'));
        // Email
        $data['payu']['email'] = $mainUserDetails->email;
        // Phone
        $data['payu']['phone'] = $mainUserDetails->phone;
        $data['payu']['firstname'] = $mainUserDetails->name;
        // Success URL
        $data['payu']['surl'] = base_url("transactions/success");
        $data['payu']['curl'] = base_url("transactions/cancel");
        $data['payu']['furl'] = base_url("transactions/failure");
        $data['payu']['tourl'] = base_url("transactions/timeout");
        // drop category
        $data['payu']['drop_category'] = "EMI,COD";
        // Merchant key here as provided by Payu
        $data['payu']['key'] = PAYU_MERCHANT_KEY;
        // End point - change to https://secure.payu.in for LIVE mode
        $data['payu']['PAYU_BASE_URL'] = PAYU_BASE_URL;
        // ..
        $data['payu']['action'] = $data['payu']['PAYU_BASE_URL'] . '/_payment';
        
        $this->wteam->update_count();
        
        $this->load->view('payu/forward', $data);
    }

    public function registerteam_payment_mobile()
    {
        $stat["status"] = "failure";
        $stat["message"] = "";

       // $data = "{\"userids\":\"[9346472, 1014551]\",\"hospitality\":\"[0,1]\",\"workshopid\":\"5\"}";
        
        $data = "{\"status\":\"success\",\"message\":\"confirm ur registartion\",\"userids\":[9346472,1010044],\"username\":[\"Rashid\",\"nagendrababu\"],\"hospitality\":[\"Will be provided accomodation\",\"Will be provided accomodation\"],\"registration\":[\"already registered\",\"already registered\"],\"workshopid\":\"17\",\"workshopCost\":\"6500\",\"hospitalityCost\":0,\"registrationCost\":0,\"transactionCharges\":202,\"totalCost\":6702}";
       // $data = $this->input->post('data');
        $data = json_decode($data, true);

        $requestData = array();
        $numUsers = 0;
        $requestData["workshopid"] = $data["workshopid"];
        $requestData["userids"] = array();
        $requestData["hospitality"] = array();
        $requestData["registration"] = array();
        $postLen = count($data["userids"]);
        $numUsers = $postLen;
        $mainuserid = $data["userids"][0];

       

       for($i=0 ;$i<$postLen;$i=$i +1)
        {
            $userid = $data["userids"][$i] ;
            array_push($requestData["userids"], $data["userids"][$i]);

            $fullData = $this->user->get_details($userid);
            if ($fullData === false) {
                $stat["message"] = "invalid userid: $userid";
                    echo json_encode($stat);
                    return;
            }
            $userName = $this->user->get_name($userid);
                if ($userName == false) {
                    $stat["message"] = "invalid userid: $userid";
                    echo json_encode($stat);
                    return;
                } 

            if($data["hospitality"][$i] == 1 && $fullData->hospitality == 0)
             { 
               
                    array_push($requestData["hospitality"], $userid);
                
                 
            }
               
                if ($this->user->get_registration($userid)->registration === '0') {
                  array_push($requestData["registration"],$userid);
                  
                  
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

        $mainuserid = $data["userids"][0];
        //$this->nativesession->set('userid_mobile', $mainuserid);
          //      $this->nativesession->set('queries', '0');


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
         // echo print_r($requestData);
        // ECHO REGISTRATION_COST*count($requestData["registration"]);
        $data['payu'] = array();
        // finding amount
        $data['payu']['txnid'] = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
        $data['payu']['amount'] = 0;
        $data['payu']['amount'] += $workshopDetails->cost;
        $data['payu']['amount'] += HOSPITALITY_COST*count($requestData["hospitality"]);
        $data['payu']['amount'] += REGISTRATION_COST*count($requestData["registration"]);
        $data['payu']['amount'] = ceil(($data['payu']['amount'] * 100.0) / 97.0);
        // If seat available
        // Add transaction
        $this->transaction->add($data['payu']['txnid'], $mainuserid,
            $requestData['workshopid'], $teamId, $requestData['registration'], $requestData['hospitality'], $data['payu']['amount']);
        // Merchant Salt as provided by Payu
        $data['payu']['salt'] = SALT;
        // Product Info
        $data['payu']['productinfo'] = "Technozion Registration";
        $mainUserDetails = $this->user->get_details($mainuserid);
        // Email
        $data['payu']['email'] = $mainUserDetails->email;
        // Phone
        $data['payu']['phone'] = $mainUserDetails->phone;
        $data['payu']['firstname'] = $mainUserDetails->name;
        // Success URL
        $data['payu']['surl'] = base_url("transactions/success_mobile");
        $data['payu']['curl'] = base_url("transactions/cancel_mobile");
        $data['payu']['furl'] = base_url("transactions/failure_mobile");
        $data['payu']['tourl'] = base_url("transactions/timeout_mobile");
        // drop category
        $data['payu']['drop_category'] = "EMI,COD";
        // Merchant key here as provided by Payu
        $data['payu']['key'] = PAYU_MERCHANT_KEY;
        // End point - change to https://secure.payu.in for LIVE mode
        $data['payu']['PAYU_BASE_URL'] = PAYU_BASE_URL;
        // ..
        $data['payu']['action'] = $data['payu']['PAYU_BASE_URL'] . '/_payment';


        
        $this->wteam->update_count();


        //-------------------------Payment part-----------------------//

       /* $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
        $hashVarsSeq = explode('|', $hashSequence);
        $hash_string = '';
        foreach($hashVarsSeq as $hash_var) {
            $hash_string .= isset($payu[$hash_var]) ? $data['payu'][$hash_var] : '';
            $hash_string .= '|';
        }
        $hash_string .= $data['payu']['salt'];
        $data['payu']['hash'] = strtolower(hash('sha512', $hash_string));

        echo json_encode($data['payu']);*/


        
        $this->load->view('payu/forward_mobile', $data);
    }



     public function registerteam_mobile()
     {
        $hospitalityCost = 1;
        $registrationCost = 1;
        $hospitalityCount = 0;
        $registrationCount = 0;
        $workshopCost = 0;
        $totalHospitalityCost = 0;
        $totalRegistrationCost = 0;
        $transactionCharges = 0;
        $totalCost = 0;

        $stat["status"] = "failure";
        $stat["message"] = "Working on it";
        $stat["userids"] = array();
        $stat["username"] = array();
        $stat["hospitality"] = array();
        $stat["registration"] = array();


        //echo json_encode($stat);
        //$data = "{\"userids\":\"[9346472, 1014551]\",\"hospitality\":\"[0,1]\",\"workshopid\":\"5\"}";
        

        $data = $this->input->post('data');
        $data = json_decode($data, true);
        $requestData = array();
        $numUsers = 0;
        $requestData["workshopid"] = $data["workshopid"];
        $requestData["userids"] = array();
        $requestData["hospitality"] = array();
        $requestData["registration"] = array();
         $stat["workshopid"] = $data["workshopid"];


        $data["userids"] = json_decode($data["userids"],true);
       // $data["hospitality"] = json_decode($data["hospitality"],true);
        $postLen = count($data["userids"]);
        $numUsers = $postLen;
       // $flag =0;
        $index = 0;


        for($i=0 ;$i<$postLen;$i=$i +1)
        {
            $data["hospitality"][$i] = 0;
            $userid = $data["userids"][$i] ;
            array_push($requestData["userids"], $data["userids"][$i]);
           

            $fullData = $this->user->get_details($userid);
            if ($fullData === false) {
                $stat["message"] = "invalid userid: $userid";
                    echo json_encode($stat);
                    return;
            }
            $userName = $this->user->get_name($userid);
                if ($userName == false) {
                    $stat["message"] = "invalid userid: $userid";
                    echo json_encode($stat);
                    return;
                } 

                $stat['username'][$i] = $fullData->name;
                $stat['registration'][$i] = $fullData->registration;
                $stat['hospitality'][$i] = $fullData->hospitality;
                $stat["userids"][$i] = $data["userids"][$i] ;
            
        
             if($data["hospitality"][$i] == 1)
             { 
                if($fullData->hospitality == 0)
                 {
                    array_push($requestData["hospitality"], $userid);
                    $stat['hospitality'][$i] = "Pay the amount";
                    $hospitalityCount++;

                 }
                 else{
                   $stat['hospitality'][$i] = "Already Paid";
                 }

             }
             else {

                 if($fullData->hospitality == 0)
                 {
                   $stat['hospitality'][$i] = "Not Paid";

                 }
                 else{
                   $stat['hospitality'][$i] = "Will be provided accomodation";
                 }
             }

             
                if ($this->user->get_registration($userid)->registration === '0') {
                  array_push($requestData["registration"],$userid);
                  $registrationCount++;
                  $stat['registration'][$i] = "Pay the amount";
                }
                else
                {
                    $stat['registration'][$i] = "already registered" ;
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
            $stat["message"] = "Workshop Not Valid1";
            echo json_encode($stat);
            return;
        }

        $details["wname"] = $workshopDetails->wname;
        $workshopCost = $workshopDetails->cost;
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

        $totalHospitalityCost = $hospitalityCost * $hospitalityCount ;
        $totalRegistrationCost = $registrationCost *$registrationCount ;
        $totalCost = $totalHospitalityCost + $totalRegistrationCost + $workshopCost ;
        $transactionCost =  ceil(($totalCost*3)/97);  
        $totalCost =  ceil(($totalCost*100.0)/97.0);
        $stat["workshopCost"] = $workshopCost;
        $stat["hospitalityCost"] = $totalHospitalityCost ;
        $stat["registrationCost"] = $totalRegistrationCost ;
        $stat["transactionCharges"] = $transactionCost ;
        $stat["totalCost"] = $totalCost ;
        $stat["status"] = "success";
        $stat["message"] = "confirm ur registartion" ;
        echo json_encode($stat);
    }



/*        $reserveSeat = $this->workshop->reserve_seat($details['workshopid']);

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
         // echo print_r($requestData);
        // ECHO REGISTRATION_COST*count($requestData["registration"]);
        $data['payu'] = array();
        // finding amount
        $data['payu']['txnid'] = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
        $data['payu']['amount'] = 0;
        $data['payu']['amount'] += $workshopDetails->cost;
        $data['payu']['amount'] += HOSPITALITY_COST*count($requestData["hospitality"]);
        $data['payu']['amount'] += REGISTRATION_COST*count($requestData["registration"]);
        $data['payu']['amount'] = ceil(($data['payu']['amount'] * 100.0) / 97.0);
        // If seat available
        // Add transaction
        $this->transaction->add($data['payu']['txnid'], $this->nativesession->get('userid'),
            $requestData['workshopid'], $teamId, $requestData['registration'], $requestData['hospitality'], $data['payu']['amount']);
        // Merchant Salt as provided by Payu
        $data['payu']['salt'] = SALT;
        // Product Info
        $data['payu']['productinfo'] = "Technozion Registration";
        $mainUserDetails = $this->user->get_details($this->nativesession->get('userid'));
        // Email
        $data['payu']['email'] = $mainUserDetails->email;
        // Phone
        $data['payu']['phone'] = $mainUserDetails->phone;
        $data['payu']['firstname'] = $mainUserDetails->name;
        // Success URL
        $data['payu']['surl'] = base_url("transactions/success");
        $data['payu']['curl'] = base_url("transactions/cancel");
        $data['payu']['furl'] = base_url("transactions/failure");
        $data['payu']['tourl'] = base_url("transactions/timeout");
        // drop category
        $data['payu']['drop_category'] = "EMI,COD";
        // Merchant key here as provided by Payu
        $data['payu']['key'] = PAYU_MERCHANT_KEY;
        // End point - change to https://secure.payu.in for LIVE mode
        $data['payu']['PAYU_BASE_URL'] = PAYU_BASE_URL;
        // ..
        $data['payu']['action'] = $data['payu']['PAYU_BASE_URL'] . '/_payment';
        
        $this->wteam->update_count();
        
        $this->load->view('payu/forward', $data);  */
    //}



};