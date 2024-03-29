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

		$new_rating = $this->CI->Ratingsmodel->create( $rating_data );

		if( !empty( $new_rating ) ){
			$rating_data['id'] = $new_rating;
			$rating_data['new_rating'] = $this->getRating( $rating_data['recipe_id'] );
			return $rating_data;
		}else{
			return false;
		}

	}

	public function getRating( $recipe_id = false ){
		if( empty( $recipe_id ) ){
			return "0";
		}

		$ratings = $this->CI->Ratingsmodel->getWhere( array( 'recipe_id' => $recipe_id ) );
		
		if( empty( $ratings ) ){
			return "0";
		}

		$running_total = 0;
		$total_ratings = count($ratings);

		foreach( $ratings as $rating ){
			$running_total += $rating['rating'];
		}

		$average_rating = $running_total / $total_ratings;
		return round($average_rating,2);

	}

	public function updateRating( $id = false, $rating_data = array() ){

	}

}