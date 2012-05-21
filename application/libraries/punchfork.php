<?
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

//47a17166ef0b31d6

class Punchfork{
	private $api_key = '47a17166ef0b31d6';
	private $url = 'http://api.punchfork.com/recipes?key={key}';

	protected $q 		 = false;
	protected $ingred 	 = false;
	protected $count 	 = false;
	protected $sort 	 = false;
	protected $startdate = false;
	protected $enddate 	 = false;

	// q (optional) — Recipe search query. Same as what you'd type into the search box on punchfork.com (see search tips). May also be a URL to look up the recipe with that URL (either a publisher URL or a punchfork.com URL). If no query is provided, the first N top-rated recipes are returned.
	// ingred (optional) (paid) — When set to either "true" or "1", recipe responses will include ingredients data.
	// count (optional) — Max number of recipes to be returned. Defaults to 10, maximum is 50. If you want more than 50 recipes, use cursor pagination.
	// cursor (optional) — Start the query at the specified cursor value. This is used for pagination.
	// sort (optional) — Sort recipes by "r"ating (default), "d"ate published, or "t"rendingness.
	// from (optional) — Only get recipes from a specific publisher. If set, this parameter should contain the full publisher name, e.g. "The Pioneer Woman" (see our full list of publishers). If this parameter is not provided, the API will return recipes from all publishers.
	// likes (optional) — Only get recipes from a specific user's likes. If set, this parameter should contain the user's Punchfork username.
	// startdate (optional) — Only get recipes published on or after this date. Must be a UTC datetime in ISO format.
	// enddate (optional) — Only get recipes published on or before this date. Must be a UTC datetime in ISO format.
	// total (optional) — When set to either "true" or "1", the response will include a "total" value which indicates the total number of recipes in the database matching the query. Must be used along with the q parameter.
	
	function __construct( $params = array() ){

	}

	public function setQuery(){

	}

	//set the ingredient (ingred parameter) [ pro only ]
	public function setIngredients(){

	}

	public function setCount(){

	}

	public function setSort(){

	}

	public function setStartDate(){

	}

	public function setEndDate(){

	}
}