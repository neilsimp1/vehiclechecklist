$(document).ready(function(){
	
	$(document).ajaxStart(function(){loader(true);});
	$(document).ajaxStart(function(){loader(false);});
	
});


function loader(on){
	if(on){
		$('#loading').slideDown();
		setTimeout(function(){$('#loading').slideUp();}, 20000);
	}
	else $('#loading').slideUp();}

function $I(i){return document.getElementById(i);}