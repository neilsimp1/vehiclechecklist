$(document).ready(function(){
	
	//login enable/disable
	$('#un, #pw').on('change', function(){
		if($I('un').value === '' && $I('un').value === '') $I('login-submit').disabled = true;
		else $I('login-submit').disabled = false;
	});
	
	
});





function $I(i){return document.getElementById(i);}