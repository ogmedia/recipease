<?
class MY_Recipemodel extends MY_Model{
	protected $table_name = '';
	
	public function __construct(){
		parent::__construct();
	}

	public function getAll(){
		$rec_query = $this->db->get($table_name);
		if(!empty($rec_query)){
			return $rec_query->result('array');
		}else{
			return false;
		}
	}

}