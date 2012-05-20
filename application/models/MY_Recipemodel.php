<?
class MY_Recipemodel extends CI_Model{
	protected $table_name = '';
	protected $order_key = 'created';
	protected $order_dir = 'ASC';

	public function __construct(){
		parent::__construct();
	}

	public function getAll(){
		$this->db->select('*');
		$this->db->order_by($this->order_key,$this->order_dir);
		$rec_query = $this->db->get($this->table_name);
		if(!empty($rec_query)){
			return $rec_query->result('array');
		}else{
			return false;
		}
	}

	public function getWhere( $where = array() ){
		if(empty($where)){
			return false;
		}

		$this->db->where($where);
		$this->db->order_by($this->order_key,$this->order_dir);
		$rec_query = $this->db->get($this->table_name);
		if(!empty($rec_query)){
			//ids are unique, so they will be keys
			$id_as_key = array();
			$pre_id_key =  $rec_query->result('array');
			
			foreach( $pre_id_key as $obj ){
				$id_as_key[ $obj['id'] ] = $obj;
			}

			return $id_as_key;
		}else{
			return false;
		}
	}

	public function getOne( $where = array() ){
		if(empty($where)){
			return false;
		}

		$this->db->where($where);
		$rec_query = $this->db->get($this->table_name);
		if(!empty($rec_query)){
			//ids are unique, so they will be keys
			$single_row =  $rec_query->row_array();

			return $single_row;
		}else{
			return false;
		}
	}

	public function create($data = array()){
		if(!empty($data)){
			$data['created'] = date('Y-m-d H:i:s');
			$this->db->insert( $this->table_name, $data );

			$new_id = $this->db->insert_id();
			return $new_id;
		}else{
			return false;
		}
	}

}