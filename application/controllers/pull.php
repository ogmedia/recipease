<?

class Pull extends CI_Controller{
	
	public $test_twitter_json = 'pull/index';

	public function __construct(){
		parent::__construct();
	}

	public function index(){
		$this->load->view($this->test_twitter_json);
	}
}