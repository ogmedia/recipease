
<div data-role="content" data-theme="c" class="ui-corner-bottom ui-content ui-body-c" role="main">
	<h1>Recipe title.</h1>
	<input type="text" name="title" id="title" />

	<h2>Ingredients</h2>
	<ul id="ingredients_list">
	</ul>

	<button id="add_ingredient">Add Ingredient</button>

	<h2>Directions</h2>
	<ul id="directions_list">
	</ul>
	<button id="add_direction">Add Direction Step</button>

	<br />

	<button id="save_recipe" data-role="button" data-theme="b" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" class="ui-btn ui-shadow ui-btn-corner-all ui-btn-up-b"><span class="ui-btn-inner ui-btn-corner-all"><span class="ui-btn-text">Save Recipe</span></span></button>       
	<a href="docs-dialogs.html" data-role="button" data-rel="back" data-theme="c" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" class="ui-btn ui-shadow ui-btn-corner-all ui-btn-up-c"><span class="ui-btn-inner ui-btn-corner-all"><span class="ui-btn-text">Cancel</span></span></a>    
</div>

<!-- end of HTML -->

<script type="text/javascript">
var ingredientTrack = 0;
var directionTrack = 0;

	function ingredientString(){
		var ingString = '';
		ingString += '<li><div>';
		ingString += '<input placeholder="amount" type="text" class="amount" name="ingredient_amount_' + ingredientTrack + '" id="ingredient_amount_' + ingredientTrack + '" />';
		ingString += '<input placeholder="unit" type="text" class="unit" name="ingredient_unit_' + ingredientTrack + '" id="ingredient_unit_' + ingredientTrack + '" />';
		ingString += '<input placeholder="ingredient (required)" type="text" name="ingredient_item_' + ingredientTrack + '" id="ingredient_item_' + ingredientTrack + '" />';
		ingString += '</div></li>';
		ingredientTrack++;
		return ingString;
	}

	function directionString(){
		var dirString = '';
		dirString += '<li><div>';
		dirString += '<textarea id="direction_step_' + directionTrack + '" name=""></textarea>';
		dirString += '</div></li>';
		directionTrack++;
		return dirString;
	}

$(function(){

	$('#add_ingredient').click(function(){
		var newIng = ingredientString();
		$('#ingredients_list').append(newIng);
	});

	$('#add_direction').click(function(){
		var newDir = directionString();
		$('#directions_list').append(newDir);
	});

	$('#save_recipe').click(function(){
		recipeObj.title = $('#title').val();
		$('textarea[id^=direction_step_]').each(function(ind,val){
			recipeObj.directions.push( $(this).val() );
		});

		$('input[id^=ingredient_item_]').each(function(ind,val){
			var ingredientObj = {};
			var currTrack = $(this).attr('id').replace('ingredient_item_','');
			
			ingredientObj.amount = $( '#ingredient_amount_' + currTrack ).val();
			ingredientObj.unit = $( '#ingredient_unit_' + currTrack ).val();
			ingredientObj.item = $( '#ingredient_item_' + currTrack ).val();

			console.log(currTrack);

			recipeObj.ingredients.push(ingredientObj);
		});

		console.log(recipeObj);

		$.post('/recipes/addRecipe',recipeObj,function(res){
			resObj = JSON.parse(res);
			console.log(resObj);

			if(resObj.status == 1){
				alert('added!');
				window.location.href = '/recipes';
			}else{
				alert('error');
			}

		});
	});

});

//no form, just one js object we send with a POST, no fall back. You using old shit -  you ain't using this.
var recipeObj = {
	ingredients:[],
	directions:[],
	title:'',
	serves:''
};
</script>