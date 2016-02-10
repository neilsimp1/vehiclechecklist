<div class="container content">
	
	<h3><?php echo $employee->name; ?></h3>
	
	<form action="includes/employeeAdd.php" method="POST">
		
		<div class="form-group">		
			<button type="button" class="delete-employee pull-right btn btn-xs btn-danger">Delete</button>
			<label class="control-label">Userame: </label><?php echo $employee->un; ?>
		</div>
		
		<div class="form-group">
			<br />
			<label for="lists" class="control-label">Assign Checklists</label><br />
			<div class="input-group input-group-sm">
				<select id="lists" class="form-control">
					<option />
					<option value="0">Test List</option>
					<option value="1">Test List 2</option>
					<option value="3">Test List 3</option>
					<option value="232">Test List 151</option>
					<?php
						foreach($lists->lists as $list){
							$hide = '';
							foreach($employee->lists as $elist){
								if($list->id == $elist->id) $hide = ' style="display:none;"';
							}
							echo '<option value="'.$list->id.'"'.$hide.'>'.$list->name.'</option>';
						}
					?>
				</select>
				<span id="addlist" class="input-group-addon btn-default pointer">Assign</span>
			</div>
			<ul id="ul_addlists">
				<?php foreach($employee->lists as $list) echo '<li class="li_addlist redhover pointer" data-id="'.$list->id.'">'.$list->name.'</li>'; ?>
			</ul>
		</div>
		
		<br /><br />
		
		<div class="col-xs-12 text-right">
			<br />
			<button type="submit" id="addemployee-submit" class="btn btn-default">Submit</button>
		</div>	
		
	</form>

</div>

<div style="display:none;">
	<form action="includes/employeeDelete.php" method="POST">
		<input type="hidden" name="id" value="<?php echo $employee->id; ?>" />
		<button type="submit" id="delete-submit"></button>
	</form>
</div>

<script>
	$(document).ready(function(){
		
		//add checklist to ul
		$('#addlist').on('click', function(){
			var select = $I('lists');
			if(!select.value) return;
			var selectedOption = $(select).find('option:selected')[0];
			
			var userID = $I('id').value, listID = selectedOption.value;
			
			$.post('includes/employeeListAdd.php', {userID: userID, listID: listID})
			.done(function(ret){
				$('#ul_addlists').append($('<li class="li_addlist redhover pointer" data-id="' + listID + '">' + selectedOption.innerHTML + '</li>'));
				selectedOption.style.display = 'none';
				select.selectedIndex = -1;
			})
			.fail(function(ret){alert('There was a problem assigning the checklist: ' + ret.responseText);});			
		});
		
		//remove checklist from ul
		$(document).on('click', '.li_addlist', function(){
			var userID = $I('id').value, listID = $(this).data('id');
			
			$.post('includes/employeeListRemove.php', {userID: userID, listID: listID})
			.done(function(ret){
				$('#lists option[value="' + id + '"]').css('display', 'block');
				$(this).remove();
			})
			.fail(function(ret){alert('There was a problem removing the checklist: ' + ret.responseText);});	
		});
		
		//delete
		$('.delete-employee').on('click', function(){$('#delete-submit').click();});
				
	});
</script>