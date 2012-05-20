<?//print_r($recipe);?>
<div id="cont">
	<div style="display:none;" class="save_recipe_reminder">
		This recipe has been changed, don't forget to save it when you're done.
		<button class="save_recipe">Save</button>
	</div>

	<h2><?=$recipe['data']['title']?></h2>

	<div>
	<? if( !empty( $recipe[ 'ingredients' ] ) ){ ?>
	<ul id="ingredients_list">
	<?foreach( $recipe[ 'ingredients' ] as $ingred ){ ?>
		<li id="ingredient_<?=$ingred['id']?>">
			<div class="display">
				<span class="amount"><?=$ingred['amount']?></span>
				<span class="unit"><?=$ingred['unit']?></span>
				<span class="item"><?=$ingred['item']?></span>
				<span class="note"><?=$ingred['note']?></span>
				<span>
					[ <a href="javascript:;" id="edit_ingredient_<?=$ingred['id']?>">edit</a> ]
				</span>
			</div>
			<div class="edit" style="display:none">
				<input placeholder="amount" type="text" name="ingredient_amount_<?=$ingred['id']?>" id="ingredient_amount_<?=$ingred['id']?>" value="<?=$ingred['amount']?>" />
				<input placeholder="unit" type="text" name="ingredient_unit_<?=$ingred['id']?>" id="ingredient_unit_<?=$ingred['id']?>" value="<?=$ingred['unit']?>" />
				<input placeholder="ingredient (required)" type="text" name="ingredient_item_<?=$ingred['id']?>" id="ingredient_item_<?=$ingred['id']?>" value="<?=$ingred['item']?>" />
				<button id="update_ingredient_<?=$ingred['id']?>">Close</button>
			</div>
		</li>
	<? } ?>
	</ul>
	<? } ?>
	</div>

	<hr />

	<div style="display:none;" class="save_recipe_reminder">
		This recipe has been changed, don't forget to save it when you're done.
		<button class="save_recipe">Save</button>
	</div>

	<div>
		<? if( !empty( $recipe[ 'directions' ] ) ){ ?>
		<ul id="directions_list">
			<? foreach( $recipe['directions'] as $direct ){ ?>
			<li id="direction_<?=$direct['id']?>">
				<div class="display">
					<span class="direction"><?=$direct['direction']?></span>
					<span>[ <a href="javascript:;" id="edit_direction_<?=$direct['id']?>">edit</a> ]</span>
				</div>
				<div class="edit" style="display:none;">
					<textarea id="direction_step_<?=$direct['id']?>"><?=$direct['direction']?></textarea>
					<button id="update_direction_<?=$direct['id']?>">Close</button>
				</div>
			</li>
			<? } ?>
		</ul>
		<? } ?>
	</div>
</div>

<!-- end of HTML -->

<style type="text/css">
#cont{
	padding:20px;
	float:left;
}
#directions_list{
	list-style-type:none;
	margin:0 0 0 0;
	padding:0 0 0 0;
}
#directions_list li{
	margin-top:20px;
}
input#title{
	width:300px;
	height:30px;
}
#ingredients_list input{
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
.save_recipe_reminder{
	border:solid 5px #ff0;
	padding:20px;
}
</style>


<!-- start JS -->
<script type="text/javascript"> 

	//handler for editing ingredients
	$('a[id^=edit_ingredient_]').click( function( e ){
		var ingId = $( this ).attr( 'id' ).replace( 'edit_ingredient_','' );
		swapIngredientEdits( ingId );
	});

	//handler for editing directions
	$('a[id^=edit_direction_]').click( function( e ){
		var dirId = $( this ).attr('id').replace( 'edit_direction_','' );
		swapDirectionEdits( dirId );
	});

	$('button[id^=update_ingredient_]').click(function(e){
		var ingId = $( this ).attr( 'id' ).replace( 'update_ingredient_','' );
		updateIngredientObj( ingId );
		swapIngredientEdits( ingId );
	});

	$('button[id^=update_direction_]').click(function(e){
		var dirId = $( this ).attr('id').replace( 'update_direction_','' );
		updateDirectionObj( dirId );
		swapDirectionEdits( dirId );
	});


	//main functions for swapping editing UI
	function swapIngredientEdits( ingId ){
		$('li[id=ingredient_' + ingId + '] div.display').toggle();
		$('li[id=ingredient_' + ingId + '] div.edit').toggle();
	}

	function swapDirectionEdits( dirId ){
		$('li[id=direction_' + dirId + '] div.display').toggle();
		$('li[id=direction_' + dirId + '] div.edit').toggle();
	}


	function updateIngredientObj( ingId ){
		//if the value changed, update it, and add parent_id ref
		var amount =  $( '#ingredient_amount_' + ingId ).val();
		var unit   =  $( '#ingredient_unit_' + ingId ).val();
		var item   =  $( '#ingredient_item_' + ingId ).val();

		if( amount != recipeObj.ingredients[ingId].amount ){
			recipeObj.ingredients[ingId].amount = amount;
			$('li#ingredient_' + ingId + ' div.display span.amount').text(amount);
			recipeObj.ingredients[ingId].override_id = ingId;
			recipeChanged = true;
			$('.save_recipe_reminder').show();
		}

		if(unit != recipeObj.ingredients[ingId].unit ){
			recipeObj.ingredients[ingId].unit =  unit;
			$('li#ingredient_' + ingId + ' div.display span.unit').text(unit);
			recipeObj.ingredients[ingId].override_id = ingId;
			recipeChanged = true;
			$('.save_recipe_reminder').show();
		}

		if(item != recipeObj.ingredients[ingId].item ){
			recipeObj.ingredients[ingId].item =  item;
			$('li#ingredient_' + ingId + ' div.display span.item').text(item);
			recipeObj.ingredients[ingId].override_id = ingId;
			recipeChanged = true;
			$('.save_recipe_reminder').show();
		}
	}

	function updateDirectionObj( dirId ){
		var direction =  $('#direction_step_' + dirId ).val();
		//if the value changed, update it and add the parent_id ref
		if( direction != recipeObj.directions[dirId].direction ){
			recipeObj.directions[dirId].direction = direction;
			$('li#direction_' + dirId + ' div.display span.direction').text(direction);
			recipeObj.directions[dirId].override_id = dirId;
			recipeChanged = true;
			$('.save_recipe_reminder').show();
		}
	}

	$('.save_recipe').click(function(){
		$.post('/recipes/addRecipeUpdate',recipeObj,function(res){
			if(res.status == 1){
				window.location.href = '/recipes';
			}
		},'json');
	});

	//our recipe obj, used to ref, and will be saved to db on any save event
	var recipeObj = <?=json_encode( $recipe );?>;

	//flip this anytime something changes, to remind them to save it
	var recipeChanged = false;
</script>