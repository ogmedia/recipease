<!-- start HTML -->
<h2>Title</h2>
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
<br />
<hr />
<button id="save_recipe">Save Recipe</button>
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

<style type="text/css">
input#title{
	width:300px;
	height:30px;
}
#ingredients_list input{
	width:200px;
	height:30px;
}
#ingredients_list input.amount{
	width:70px;
}
#ingredients_list input.unit{
	width:70px;
}
#directions_list textarea{
	width:400px;
	height:50px;
}
</style>