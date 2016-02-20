<div class="container content">
	
	<h3>Add Employee</h3>
	
	<form action="includes/employeeAdd.php" method="POST">
		
		<div class="form-group">
			<label for="name" class="control-label">Name</label><br />
			<input type="text" id="name" name="name" class="form-control" maxlength="45" placeholder="Name" required />
		</div>
		
		<div class="form-group">
			<br />
			<label for="yn" class="control-label">Username</label><br />
			<input type="text" id="un" name="un" class="form-control" maxlength="45" placeholder="Username" required />
		</div>
		
		<div class="form-group">
			<br />
			<label for="pw" class="control-label">Password</label><br />
			<input type="password" id="pw" name="pw" class="form-control" maxlength="45" placeholder="Password" required />
		</div>
		
		<div class="form-group">
			<br />
			<label for="lists" class="control-label">Assign Checklists</label><br />
			<div class="input-group input-group-sm">
				<select id="lists" class="form-control">
					<option />
					<?php foreach($lists->lists as $list) echo '<option value="'.$list->id.'">'.$list->name.'</option>'; ?>
				</select>
				<span id="addlist" class="input-group-addon btn-default pointer">Assign</span>
			</div>
			<ul id="ul_addlists"></ul>
			<input type="hidden" id="listids" name="listids" />
		</div>
		
		<br /><br />
		
		<div class="col-xs-12 text-right">
			<br />
			<button type="submit" id="addemployee-submit" class="btn btn-default">Submit</button>
		</div>	
		
	</form>
	
</div>

<script>
	$(document).ready(function(){
		
		//add checklist to ul
		$('#addlist').on('click', function(){
			var select = $I('lists');
			if(!select.value) return;
			var selectedOption = $(select).find('option:selected')[0];
			$('#ul_addlists').append($('<li class="li_addlist redhover pointer" data-id="' + selectedOption.value + '">' + selectedOption.innerHTML + '</li>'));
			selectedOption.style.display = 'none';
			select.selectedIndex = -1;
		});
		
		//remove checklist from ul
		$(document).on('click', '.li_addlist', function(){
			var id = $(this).data('id');
			$('#lists option[value="' + id + '"]').css('display', 'block');
			$(this).remove();
		});
		
		//submit enable/disable
		$('input').on('change', function(){
			if($I('name').value === '' || $I('un').value === '' || $I('pw').value === '') $I('addemployee-submit').disabled = true;
			else $I('addemployee-submit').disabled = false;
		});
		
		//on submit, store
		$('form').on('submit', function(){
			loader(true);
			$I('listids').value = $('#ul_addlists').children().map(function(){return $(this).data('id');}).get().join(',');
		});
		
	});
</script>