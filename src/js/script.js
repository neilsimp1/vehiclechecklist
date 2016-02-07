$(document).ready(function(){
	
	//change page
	$('a.link').on('click', function(){changePage($(this).data('href'));});
	
});


function changePage(page){
	$.get('./' + page, function(ret){
		$I('wrapper').innerHTML = ret;
		$(document).trigger('ready');
	})
	.fail(function(ret){alert('Error opening page: ' + ret);});
}





function $I(i){return document.getElementById(i);}