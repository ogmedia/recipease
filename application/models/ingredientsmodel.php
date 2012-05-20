<?

class Ingredientsmodel extends MY_Recipemodel{
	
	protected $table_name = 'ingredients';
	protected $order_key = 'sort';
	protected $order_dir = 'ASC';

	public function __construct(){
		parent::__construct();
	}

}