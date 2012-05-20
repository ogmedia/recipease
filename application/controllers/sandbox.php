<?

class Sandbox extends CI_Controller{
	
	public $main_view_path = 'sandbox/index';

	public function __construct(){
		parent::__construct();
	}

	public function index(){
		$this->load->view($this->main_view_path);
	}
}