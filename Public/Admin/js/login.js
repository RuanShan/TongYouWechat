$(function(){
	$('#verify_btn').css('cursor','pointer')
	$('#verify_btn').click(function(){
		$('#verify').attr('src',"verify?a="+Math.random());
	})
})