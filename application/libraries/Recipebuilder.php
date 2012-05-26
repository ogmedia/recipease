<? 
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Recipebuilder{
	public $CI;
	public $recipe = array();
	public $recipe_id = false;

	public $track_path = array(); //a list of id's of the traced path to ultimate parent
	public $ingredient_track_path = array();	//same for ingredients

	public $change_log = array();

	function __construct( $params = array() ){
		$this->CI =& get_instance();

		$this->CI->load->model('Directionsmodel');
		$this->CI->load->model('Ingredientsmodel');
		$this->CI->load->model('Recipesmodel');
		$this->CI->load->library('Reciperating');

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
			$recipe = $this->getRecipe( $recipe_item['id'] );
			
			$rating = $this->CI->reciperating->getRating( $recipe_item['id'] );
			$recipe['rating'] = $rating;
			//this has to be recursive :/

			$recipe_list[ $recipe_item['id'] ] = $recipe;
		}

		return $recipe_list;

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

	public function getUltimateIngredientParent( $ingredient_seed = array(), $trace_path = false ){
		$parent_id = $ingredient_seed['parent_id'];
		
		if( !empty( $trace_path ) ){
			$this->ingredient_track_path = array();	//retain the path
		}

		while( !empty( $ingredient_seed['parent_id'] ) && ( $ingredient_seed['parent_id'] != 0 ) ){
			$parent_id = $ingredient_seed['parent_id'];

			$ingredient_seed = $this->getIngredientParent( $ingredient_seed['parent_id'] );
			
			if( !empty( $trace_path ) ){
				array_unshift( $this->ingredient_track_path, $ingredient_seed );
			}

		}

		return $parent_id;
	}

	public function getParent( $parent_id = false ){
		$recipe_data = $this->CI->Recipesmodel->getWhere( array( 'id' => $parent_id ) );
		return $recipe_data;
	}

	public function getIngredientParent( $parent_id = false ){
		$ingredient_data = $this->CI->Ingredientsmodel->getWhere( array( 'id' => $parent_id ) );
		return $ingredient_data;
	}

  	//recursive basic recipe data, ingredients should be different method
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

		}

		return $recipe_assembly;

	}

	//traces the ingredient and gets its current state, 
	public function getIngredient( $ingredient_id = false ){
		$ingredient_data = $this->CI->Ingredientsmodel->getWhere( array( 'id' => $ingredient_id ) );

		//check if final
		if( empty( $ingredient_data['parent_id'] ) ){
			return $ingredient_data;
		}

		$ingredient_assembly = array();

		//first, get the highest parent item.
		$ultimate_parent_id = $this->getUltimateIngredientParent( $ingredient_data, true );

		$node_path = $this->ingredient_track_path;	//the path to drive

		array_push( $node_path, $ingredient_data );	//put the element at the end of the path

		//step through each iteration of recipe
		foreach($node_path as $ingredient_struct){

			//recipe data
			foreach( $ingredient_struct as $field => $value ){
				
				if( !empty( $value ) && !empty( $ingredient_struct[ $field ] ) ){ 	//not sure why doubling checking this		
					$ingredient_assembly[ $field ] = $value;
				}
			}

		}

		return $ingredient_assembly;
	}

	//recursive full recipe method - gets ingredients and directions, too
	public function getDetailedRecipe( $recipe_id = false, $change_log = false ){
		$recipe_data = $this->CI->Recipesmodel->getWhere( array( 'id' => $recipe_id ) );

		$recipe_assembly = array();

		//first, get the highest parent item.
		$ultimate_parent_id = $this->getUltimateParent( $recipe_data, true );

		$node_path = $this->track_path;	//the path to drive

		array_push( $node_path, $recipe_data );	//put the element at the end of the path

		$ingredient_mapping = array();
		$directions_mapping = array();

		//if we are showing history
		if( !empty( $change_log ) ){
			$this->change_log = array();
		}

		//step through each iteration of recipe
		foreach($node_path as $recipe_struct){
			$changes = array();
			//map ingredients
			$ingredients = $this->CI->Ingredientsmodel->getWhere( array( 'recipe_id' => $recipe_struct['id'] ) );

			foreach($ingredients as $ingredient){
				$ingredient_mapping[ $ingredient['id'] ] = $ingredient;
				
				if(!empty($ingredient['parent_id'])){

					$changes['ingredients'][] = $ingredient;
					unset($ingredient_mapping[ $ingredient['parent_id'] ]);
				}
			}

			//map directions
			$directions = $this->CI->Directionsmodel->getWhere( array( 'recipe_id' => $recipe_struct['id'] ) );

			foreach($directions as $direction){
				$directions_mapping[ $direction['id'] ] = $direction;
				
				if(!empty($direction['parent_id'])){
					$changes['directions'][] = $direction;
					unset($directions_mapping[ $direction['parent_id'] ]);
				}
			}

			//recipe data
			foreach( $recipe_struct as $field => $value ){
				
				if( !empty( $value ) && !empty( $recipe_struct[ $field ] ) ){ 	//not sure why doubling checking this		
					$recipe_assembly[ $field ] = $value;
				}
			}

			//if history tracking flag is on
			if( !empty( $change_log ) ){
				$this->change_log[] = array(
					'data' => $recipe_assembly, 
					'ingredients' => $ingredient_mapping, 
					'directions' => $directions_mapping,
					'changes' => $changes
				);
			}

		}

		$recipe_output['data'] = $recipe_assembly;
		$recipe_output['directions'] = $directions_mapping;
		$recipe_output['ingredients'] = $ingredient_mapping;

		return $recipe_output;
	}

}