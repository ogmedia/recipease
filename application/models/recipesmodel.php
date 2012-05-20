<?

class Recipesmodel extends MY_Recipemodel{
	
	protected $table_name = 'recipes';

	function __construct(){
		parent::__construct();
	}

	public function getWhere( $where = array() ){
		if(empty($where)){
			return false;
		}

		$this->db->where($where);
		$rec_query = $this->db->get( $this->table_name );
		if( !empty( $rec_query ) ){
			//ids are unique, so they will be keys
			$recipe_result =  $rec_query->result('array');

			return $recipe_result[0];
		}else{
			return false;
		}
	}

}