<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Statistics extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('auth/ion_auth');
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('auth/login', 'refresh');
		}
	}

    public function index()
    {
       redirect(base_url('coreteam/statistics/workshops'), 'location', 301);
   }

   public function workshops()
   {
    $this->load->library('table');
    $this->load->model('Statistics_model', 'stats', TRUE);
    $result = $this->stats->get_all_workshops();
    $result_headings = $this->stats->get_headings_workshops();
    $tmpl = array ( 'table_open'  => '<table class="table table-striped table-hover table-bordered">' );

    $this->table->set_template($tmpl);
    $this->table->set_heading($result_headings);
    $data['table'] = $this->table->generate($result);

    $data['current_page'] = "workshops";
    $this->load->view('base/header', $data, FALSE);
    $this->load->view('base/table', $data, FALSE);
    $this->load->view('base/footer', $data, FALSE);
}

public function registrations()
{
    $this->load->library('table');
    $this->load->model('Statistics_model', 'stats', TRUE);

    $reg_count = $this->stats->get_reg_count();
    $hosp_count = $this->stats->get_hosp_count();

    $table_data = array(
        array('Registration', $reg_count),
        array('Hospitality', $hosp_count),
        array('Registration without Hospitality', $reg_count-$hosp_count),
        );
    $table_headings = array('Type', 'Count');
    $tmpl = array ( 'table_open'  => '<table class="table table-striped table-hover table-bordered">' );
    $this->table->set_template($tmpl);
    $this->table->set_heading($table_headings);
    $data['table'] = $this->table->generate($table_data);

    $data['current_page'] = "registrations";
    $this->load->view('base/header', $data, FALSE);
    $this->load->view('base/table', $data, FALSE);
    $this->load->view('base/footer', $data, FALSE);
}

public function users()
{
    $this->load->library('table');
    $this->load->model('Statistics_model', 'stats', TRUE);

    $table_headings = array('userid','name', 'email','sex','phone', 'college', 'city', 'registration', 'hospitality');
    $table = $this->stats->get_all_users(implode(", ", $table_headings));
    $tmpl = array ( 'table_open'  => '<table class="table table-striped table-hover table-bordered">' );

    $this->table->set_template($tmpl);
    $this->table->set_heading($table_headings);
    $data['table'] = $this->table->generate($table);

    $data['current_page'] = "users";
    $this->load->view('base/header', $data, FALSE);
    $this->load->view('base/table', $data, FALSE);
    $this->load->view('base/footer', $data, FALSE);
}

public function events()
{
    $this->load->library('table');
    $this->load->model('Statistics_model', 'stats', TRUE);

    $tmpl = array ( 'table_open'  => '<table class="table table-striped table-hover table-bordered">' );
    $this->table->set_template($tmpl);
    $data['table'] = $this->table->generate($this->stats->get_events_count_query());

    $data['current_page'] = "events";
    $this->load->view('base/header', $data, FALSE);
    $this->load->view('base/table', $data, FALSE);
    $this->load->view('base/footer', $data, FALSE);
}

public function wusers()
{
  $this->load->model('user','',TRUE);
  $this->load->model('wteam','',TRUE);
  $this->load->model('Statistics_model', 'stats', TRUE);
  $teamids = $this->stats->get_wteamids();
  $wteams = array();
  $count = 0;
  foreach ($teamids as $index => $teamid) 
  {
     $teamid = $teamid["teamid"];
     $teamDetails = $this->wteam->get_details($teamid, 'array');
     $wteams[$teamid] = array("workshopName" => $teamDetails["wname"],
        "status" => $teamDetails["status"]);
     if ($teamDetails["status"] === "5") 
     {
        $count++;
    }
    $wteams[$teamid]["users"] = array();
    for ($i=1; $i<=$teamDetails["tsize"]; $i++) 
    {
        array_push($wteams[$teamid]["users"], $this->user->get_details($teamDetails['user'.$i.'id']));
    }
}
$data['wteams'] = $wteams;
		//$data['workshops'] = $this->user->get_teams_workshops($this->nativesession->get('userid'));


$this->load->library('table');
$this->load->model('Statistics_model', 'stats', TRUE);

$tmpl = array ( 'table_open'  => '<table class="table table-striped table-hover table-bordered">' );
$this->table->set_template($tmpl);
		//$data['table'] = $this->table->generate($wteams);

$data['current_page'] = "wlist";
$this->load->view('base/header', $data, FALSE);
$this->load->view('workshopuser', $data, FALSE);
$this->load->view('base/footer', $data, FALSE);
}


}

/* End of file statistics.php */
/* Location: ./application/modules/controllers/statistics.php */