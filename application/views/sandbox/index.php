<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<script TYPE="text/javascript" src="/js/jquery-1.7.2.min.js"></script>
</head>
<body>

<h1 style="display:none;" id="hello">HELLO</h1>
<div id="results">

</div>
</body>

<script type="text/javascript">
var twitter_response;
var all_results = [];

$(function(){
	$('#hello').fadeIn(5000);
	setTimeout(function(){
		pullTwitter();
	},6000);
});

function pullTwitter(){
	$.get('pull/index',function(res){
		twitter_response = JSON.parse(res);
		console.log(twitter_response);
		$.each(twitter_response.results,function(ind,val){
			all_results.push(ind);
			setTimeout(function(){
				var result_div = '<div id="result_'+ ind +'" style="display:none;">';
				result_div += val.text;
				result_div += '</div>';
				$('#results').append(result_div);
				$('#result_'+ind).fadeIn(2000);
				
			},5000);
		});
	});
}
</script>
</html>