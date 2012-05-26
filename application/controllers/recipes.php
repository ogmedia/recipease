<?
class Recipes extends MY_Recipecontroller{
	
	public function __construct(){
		parent::__construct();

		$this->load->model('Recipesmodel');
		$this->load->library('Recipebuilder');
		$this->load->library('Reciperating');
	}

	public function index( $recipe_id = false ){
		$this->body_view = 'index';

		$all_recipes = $this->recipebuilder->getRecipeList();

		$this->body_view_data = array( 'recipes' => $all_recipes );
		$this->runViews( );
	
	}

	public function view( $recipe_id = false ){
		if( empty( $recipe_id ) ){
			die('no idea');
		}
		$this->body_view = 'recipe/view';

		//$recipe = $this->recipebuilder->getFullRecipe( $recipe_id );
		$recipe = $this->recipebuilder->getDetailedRecipe( $recipe_id );

		$rating = $this->reciperating->getRating( $recipe_id );
		$recipe['rating'] = $rating;

		$this->body_view_data = array( 'recipe' => $recipe );

		$this->runViews();

	}

	public function history( $recipe_id = false, $direction = 'desc' ){
		if( empty( $recipe_id ) ){
			die('no recipe id');
		}

		$recipe = $this->recipebuilder->getDetailedRecipe( $recipe_id, true );

		$recipe_history = $this->recipebuilder->change_log;
		
		if( $direction != 'asc' ){
			krsort($recipe_history);
		}

		$this->body_view = 'recipe/history';

		$this->body_view_data = array( 'recipe_history' => $recipe_history );
		
		$this->runViews();

	}

	public function add(){
		$this->body_view = 'recipe/add';

		$this->runViews();
	}

	public function get_parent( $recipe_id = false ){
		if(empty($recipe_id)){
			die('attach a recipe id to see its ultimate parent id');
		}

		$recipe = $this->Recipesmodel->getWhere( array( 'id' => $recipe_id ) );
		$ultimate_parent = $this->recipebuilder->getUltimateParent( $recipe, true );

		echo ' the recipe record by id';
		print_r($recipe);
		echo '<br />ultimate parent id: ' . $ultimate_parent;
		echo '<br />';
		print_r($this->recipebuilder->track_path);
	}

	public function get_assembled( $recipe_id = false ){
		if( empty( $recipe_id ) ){
			die('no recipe id');
		}

		$recipe = $this->recipebuilder->getDetailedRecipe( $recipe_id, true );
		//print_r($recipe);
		$recipe_history = $this->recipebuilder->change_log;
		echo '<br />RECIPE HISTORY<br />';
		print_r($recipe_history);
	}

	public function addRecipeUpdate(){
		$output = array();
		if( !empty( $_POST ) ){
			$output = $this->recipebuilder->updateRecipe();
		}else{
			$output['status'] = 0;
			$output['message'] = 'No data';
		}

		echo json_encode( $output );
		exit;
	}

	public function addRecipe(){
		//put this into library, all business logic in library ;)
		$output = array();

		$ingredients = $this->input->post('ingredients');
		$directions = $this->input->post('directions');
		$title  = $this->input->post('title');

		$recipe_id = $this->Recipesmodel->create( array( 'title' => $title ) );
		
		if( !is_numeric( $recipe_id ) ){
			$output['status'] = 0;
			$output['message'] = 'Unable to add recipe title and basic row';
			exit;
		}

		if(!empty($ingredients)){
			foreach($ingredients as $ingredient){
				$ingredient['recipe_id'] = $recipe_id;
				$this->Ingredientsmodel->create($ingredient);
			}
		}

		if(!empty($directions)){
			foreach($directions as $direction){
				$this->Directionsmodel->create( array( 'direction' => $direction, 'recipe_id' => $recipe_id ) );
			}
		}

		$output['status'] = 1;
		$output['message'] = 'Added Recipe!';

		echo json_encode( $output );
		exit;
	}

	//rate the recipe via ajax
	public function rateRecipe(){
		$rating = $this->input->post('rating');

		$response = $this->reciperating->addRating( $rating );
		echo json_encode( $response );
		exit;
	}

	//returns json recipe object
	public function getRecipeJSON( $recipe_id = false){
		//cache this
		if( empty( $recipe_id ) ){
			die( json_encode( array( 'response' => 'invalid parameters' ) ) );
		}

		$recipe = $this->recipebuilder->getDetailedRecipe( $recipe_id );
		
		$rating = $this->reciperating->getRating( $recipe_id );
		$recipe['rating'] = $rating;

		$output = array();
		$output['recipe'] = $recipe;
		$output['status'] = 1;
		$output['message'] = 'retrieved recipe data';

		echo json_encode( $output );
		exit;
	}
}