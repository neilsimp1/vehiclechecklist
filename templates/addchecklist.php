<div class="container content">
	
	<h3>Add Checklist</h3>
	
	<form action="includes/listAdd.php" method="POST">
		
		<div class="form-group">
			<label for="name" class="control-label">Name</label><br />
			<input type="text" id="name" name="name" class="form-control" maxlength="45" placeholder="Name" required />
		</div>
		
		<div class="form-group">
			<br />
			<label for="lists" class="control-label">Add Checklist Tasks</label><br />
			<div class="input-group input-group-sm">
				<input type="text" id="item" class="form-control" placeholder="Add a task" />
				<span id="additem" class="input-group-addon btn-default pointer">Add</span>
			</div>
			<ul id="ul_additems"></ul>
			<input type="hidden" id="itemdescs" name="itemdescs" />
		</div>
		
		<br /><br />
		
		<div class="col-xs-12 text-right">
			<br />
			<button type="submit" id="addlist-submit" class="btn btn-default">Submit</button>
		</div>	
		
	</form>
	
</div>

<script>
	$(document).ready(function(){
		
		//add item to ul
		$('#additem').on('click', function(){
			var input = $I('item');
			if(!input.value) return;
			$('#ul_additems').append($('<li class="li_additem redhover pointer">' + input.value + '</li>'));
			input.value = '';
		});
		
		//remove item from ul
		$(document).on('click', '.li_additem', function(){$(this).remove();});
		
		//submit enable/disable
		$('#name').on('change', function(){
			if($I('name').value === '') $I('addemployee-submit').disabled = true;
			else $I('addlist-submit').disabled = false;
		});
		
		//on submit, store
		$('form').on('submit', function(){
			loader(true);
			$I('itemdescs').value = $('#ul_additems').children().map(function(){return this.innerHTML;}).get().join('|^|');
		});
		
	});
</script>