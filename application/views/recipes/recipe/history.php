<div>
<h2>Recipe History</h2>
<ul>
	<? foreach( $recipe_history as $recipe ){ ?>
	<li id="recipe_<?=$recipe['data']['id']?>" class="recipe_edit">
	<div class="recipe_title"><?=$recipe['data']['title'];?></div>
	<div class="created_on"><span class="created_date">(<?=date( 'M j, Y g:ia',strtotime($recipe['data']['created']) );?>)</span> |
		<?if( empty( $recipe['data']['parent_id'] ) ){?>
	 		Original Version
		<? }else{ ?>
	 		<span class="view_changes"><a href="javascript:;">View Changes</a></span>
	 	<? } ?>
	</div>
	<div class="recipe_changes" style="display:none;">
		<h3>RECIPE CHANGES</h3>
		<? foreach($recipe['changes'] as $changed_member => $changes){?>
			<div class="changed_details">
				<h4><?=$changed_member?></h4>
				<? foreach($changes as $change){?>
					<? foreach( $change as $field => $value ){ ?>
					<span>(<?=$field;?>: <?=$value?>)</span> 
					<? } ?>
				<? } ?>
			</div>
		<? } ?>
	</div>
	</li>
	<? } ?>
</ul>
</div>

<script type="text/javascript">
	$('.view_changes').click(function(){
		console.log('clicked');
		$(this).parent().siblings('.recipe_changes').toggle();
	});
</script>

<style type="text/css">
.recipe_edit{
	float:left;
	clear:left;
}
.recipe_title{
	width:400px;
	float:left;
}
.created_on{
	width:300px;
	float:left;
}
.recipe_changes{
	clear:left;
	float:left;
}
.changed_details{
	clear:left;
	float:left;
}
</style>