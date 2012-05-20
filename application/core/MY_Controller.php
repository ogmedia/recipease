<?
class MY_Controller extends CI_Controller{
	function __construct(){
		parent::__construct();
	}
}

class MY_Recipecontroller extends MY_Controller{
	public $body_view_data = array();
	public $body_view = 'index';	//default to index

	function __construct(){
		parent::__construct();
	}

	protected function runViews( ){
		$output_string = '';
		$output_string .= $this->load->view('recipes/layout/header',array(),true);
		$output_string .= $this->load->view('recipes/' . $this->body_view , $this->body_view_data, true );
		$output_string .= $this->load->view('recipes/layout/footer',array(),true);

		echo $output_string;
	}
}