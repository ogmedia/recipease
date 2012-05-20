<?
class Recipes extends MY_Recipecontroller{
	
	public function __construct(){
		parent::__construct();

		$this->load->model('Recipesmodel');
		$this->load->library('Recipebuilder');
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

		$this->body_view_data = array( 'recipe' => $recipe );

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

		$recipe = $this->recipebuilder->getDetailedRecipe( $recipe_id );
		print_r($recipe);
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
}