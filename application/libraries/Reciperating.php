<? 
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class RecipeRating{
	public $CI;

	function __construct(){
		$this->CI =& get_instance();

		$this->CI->load->model('Recipesmodel');
		$this->CI->load->model('Ratingsmodel');
	}

	public function addRating( $rating_data = array() ){
		
		if( empty( $rating_data ) ){
			return false;
		}

		$new_rating = $this->CI->ratingsmodel->create( $rating_data );

		if( !empty( $new_rating ) ){
			$rating_data['id'] = $new_rating;
			return $rating_data;
		}else{
			return false;
		}

	}

	public function getRating( $recipe_id = false ){
		$ratings = $this->CI->ratingsmodel->getAll();
	}

	public function updateRating( $id = false, $rating_data = array() ){

	}

}