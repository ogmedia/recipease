<? 
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Recipebuilder{
	public $CI;
	public $recipe = array();
	public $recipe_id = false;

	public $track_path = array(); //a list of id's of the traced path to ultimate parent

	function __construct( $params = array() ){
		$this->CI =& get_instance();

		$this->CI->load->model('Directionsmodel');
		$this->CI->load->model('Ingredientsmodel');
		$this->CI->load->model('Recipesmodel');

		if( !empty( $params['recipe_id'] ) ){
			$this->recipe_id = $params[ 'recipe_id' ];
			$this->recipe = $this->getFullRecipe( $this->recipe_id );
		}
	}

	public function getRecipeList(){
		$recipe_list = array();
		$all_recipes = $this->CI->Recipesmodel->getAll();

		foreach($all_recipes as $recipe_item ){
			$recipe = array();
			$recipe = $recipe_item;

			//this has to be recursive :/
			if( !empty( $recipe_item['parent_id'] ) ){

				$recipe_parent = $this->CI->Recipesmodel->getWhere( array( 'id' => $recipe_item['parent_id'] ) );	

				//override recipe info
				foreach( $recipe as $field => $value ){
					if( empty( $value ) ){
						$recipe[$field] = $recipe_parent[$field];
					}
				}


			}

			$recipe_list[] =  $recipe;
		}

		return $recipe_list;

	}


	public function getFullRecipe( $recipe_id = false ){
		$recipe = array();
		$recipe_data = $this->CI->Recipesmodel->getWhere( array( 'id' => $recipe_id ) );

		$recipe['data'] = $recipe_data;

		//check to see if we have a parent, if so, override with whatever data we need
		if( !empty( $recipe_data['parent_id'] ) ){
			$recipe_parent = $this->CI->Recipesmodel->getWhere( array( 'id' => $recipe_data['parent_id'] ) );
			$parent_ingredients = $this->CI->Ingredientsmodel->getWhere( array( 'recipe_id' => $recipe_data['parent_id'] ) );
			$parent_directions  = $this->CI->Directionsmodel->getWhere( array( 'recipe_id' => $recipe_data['parent_id'] ) );	

			//override recipe info
			foreach( $recipe['data'] as $field => $value ){
				if( empty( $value ) ){
					$recipe['data'][$field] = $recipe_parent[$field];
				}
			}

			//override ingredient info
			foreach( $parent_ingredients as $parent_ingredient_id => $parent_ingredient ){
				$child_ingredient = $this->CI->Ingredientsmodel->getOne( array( 'parent_id' => $parent_ingredient_id, 'recipe_id' => $recipe_id ) );

				if( !empty( $child_ingredient ) ){
					$recipe[ 'ingredients' ][ $child_ingredient['id'] ] = $child_ingredient;
				}else{
					$recipe[ 'ingredients' ][ $parent_ingredient_id ] = $parent_ingredient;
				}
			}

			//override directions info
			foreach( $parent_directions as $parent_direction_id => $parent_direction ){
				$child_direction = $this->CI->Directionsmodel->getOne( array( 'parent_id' => $parent_direction_id, 'recipe_id' => $recipe_id ) );

				if( !empty( $child_direction ) ){
					$recipe[ 'directions' ][ $child_direction['id'] ] = $child_direction;
				}else{
					$recipe[ 'directions' ][ $parent_direction_id ] = $parent_direction;
				}
			}
		}else{
			
			$ingredients = $this->CI->Ingredientsmodel->getWhere( array( 'recipe_id' => $recipe_id ) );
			$directions  = $this->CI->Directionsmodel->getWhere( array( 'recipe_id' => $recipe_id ) );

			$recipe['ingredients'] = $ingredients;
			$recipe['directions'] = $directions;

		}

		return $recipe;
	}


	public function updateRecipe(){
		$recipe = $this->CI->input->post('data');
		$ingredients = $this->CI->input->post('ingredients');
		$directions = $this->CI->input->post('directions');

		$update_recipe_data = array();
		$update_recipe_data['parent_id'] = $recipe['id'];
		$new_recipe_id = $this->CI->Recipesmodel->create( $update_recipe_data );

		foreach( $ingredients as $ingredient ){
			if( !empty( $ingredient['override_id'] ) ){
				$override_ingredient = $ingredient;

				$override_ingredient['recipe_id'] = $new_recipe_id;
				$override_ingredient['parent_id'] = $ingredient['override_id'];

				unset( $override_ingredient['override_id'] );
				unset( $override_ingredient['id'] );
				unset( $override_ingredient['created'] );

				$this->CI->Ingredientsmodel->create( $override_ingredient );
			}
		}

		foreach( $directions as $direction ){
			if( !empty( $direction['override_id'] ) ){
				$override_direction = $direction;

				$override_direction['recipe_id'] = $new_recipe_id;
				$override_direction['parent_id'] = $direction['override_id'];

				unset( $override_direction['override_id'] );
				unset( $override_direction['id'] );
				unset( $override_direction['created'] );

				$this->CI->Directionsmodel->create( $override_direction );
			}
		}

		return array( 'status' => 1 , 'message' => 'updated recipe' );
	}

	public function getUltimateParent( $recipe_seed = array(), $trace_path = false ){
		$parent_id = $recipe_seed['parent_id'];
		
		if( !empty( $trace_path ) ){
			$this->track_path = array();	//retain the path
		}

		while( !empty( $recipe_seed['parent_id'] ) && ( $recipe_seed['parent_id'] != 0 ) ){
			$parent_id = $recipe_seed['parent_id'];

			$recipe_seed = $this->getParent( $recipe_seed['parent_id'] );
			
			if( !empty( $trace_path ) ){
				array_unshift( $this->track_path, $recipe_seed );
			}

		}

		return $parent_id;
	}

	public function getParent( $parent_id = false ){
		$recipe_data = $this->CI->Recipesmodel->getWhere( array( 'id' => $parent_id ) );
		return $recipe_data;
	}

	public function getRecipe( $recipe_id = false ){
		$recipe_data = $this->CI->Recipesmodel->getWhere( array( 'id' => $recipe_id ) );

		//check if final
		if( empty( $recipe_data['parent_id'] ) ){
			return $recipe_data;
		}

		$recipe_assembly = array();

		//first, get the highest parent item.
		$ultimate_parent_id = $this->getUltimateParent( $recipe_data, true );

		$node_path = $this->track_path;	//the path to drive

		array_push( $node_path, $recipe_data );	//put the element at the end of the path

		//step through each iteration of recipe
		foreach($node_path as $recipe_struct){

			//recipe data
			foreach( $recipe_struct as $field => $value ){
				
				if( !empty( $value ) && !empty( $recipe_struct[ $field ] ) ){ 	//not sure why doubling checking this		
					$recipe_assembly[ $field ] = $value;
				}
			}

			//ingredient and direction data
			//take this level field values and writes them if they exist
			//need to check this level - ingredients
			//need to check this level - directions
		}

		return $recipe_assembly;

	}

}