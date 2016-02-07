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

		<br /><br />

		<div class="col-xs-12 text-right">
			<br />
			<button type="submit" id="addemployee-submit" class="btn btn-default">Submit</button>
		</div>	
		
	</form>

</div>

<script>
	$(document).ready(function(){
		
		//submit enable/disable
		$('input').on('change', function(){
			if($I('name').value === '' || $I('un').value === '' || $I('pw').value === '') $I('addemployee-submit').disabled = true;
			else $I('addemployee-submit').disabled = false;
		});
	
	});
</script>