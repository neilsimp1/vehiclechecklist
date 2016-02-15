<div class="container content">
	
	<h3><?php echo $list->name; ?></h3>
			
	<div class="form-group">		
		<button type="button" class="delete-list pull-right btn btn-xs btn-danger">Delete</button>
	</div>
		
	<div class="form-group">
		<br />
		<label for="lists" class="control-label">Checklist Items</label><br />
		<div class="input-group input-group-sm">
			<input type="text" id="item" class="form-control" placeholder="Add a task" />
			<span id="additem" class="input-group-addon btn-default pointer">Add</span>
		</div>
		<br />
		<ul id="ul_additems">
			<?php foreach($list->items as $item) echo '<li class="li_additem redhover pointer" data-id="'.$item->id.'">'.$item->desc.'</li>'; ?>
		</ul>
	</div>

</div>

<div style="display:none;">
	<form action="includes/listDelete.php" method="POST">
		<input type="hidden" id="id" name="id" value="<?php echo $list->id; ?>" />
		<button type="submit" id="delete-submit"></button>
	</form>
</div>

<script>
	$(document).ready(function(){
		
		//add item to ul
		$('#additem').on('click', function(){
			var input = $I('item');
			if(!input.value) return;
			
			var listID = $I('id').value;
			
			$.post('includes/listItemAdd.php', {listID: listID, desc: input.value})
			.done(function(ret){
				var item = JSON.parse(ret);
				$('#ul_additems').append($('<li class="li_additem redhover pointer" data-id="' + item.id + '">' + input.value + '</li>'));
				input.value = '';
			})
			.fail(function(ret){alert('There was a problem adding the checklist item: ' + ret.responseText);});			
		});
		
		//remove item from ul
		$(document).on('click', '.li_additem', function(){
			var li = this;
			var listID = $I('id').value, itemID = $(this).data('id');
			
			$.post('includes/listItemDelete.php', {listID: listID, itemID: itemID})
			.done(function(ret){
				$(li).remove();
			})
			.fail(function(ret){alert('There was a problem removing the item from the checklist: ' + ret.responseText);});	
		});
		
		//delete
		$('.delete-list').on('click', function(){
			loader(true);
			$('#delete-submit').click();
		});
		
	});
</script>