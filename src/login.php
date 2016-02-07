<div class="container-fluid">
	
	<div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">

		<div class="container-fluid content">

			<h3>Log In</h3>

			<form action="includes/login.php" method="post" role="form">

				<div class="form-group<?php //if(isset($haserror)) echo $haserror; ?>">
					<div class="col-xs-12">
						<label for="un" class="control-label">Username</label><br />
						<input type="text" id="un" name="un" class="form-control" maxlength="45" placeholder="Username" required />
					</div>
				</div>

				<div class="form-group<?php //if(isset($haserror)) echo $haserror; ?>">
					<div class="col-xs-12">
						<br />
						<label for="pw" class="control-label">Password</label><br />
						<input type="password" id="pw" name="pw" class="form-control" maxlength="45" placeholder="Password" required />
					</div>
				</div>

				<br /><br />

				<div class="col-xs-12 text-right" style="margin-bottom:8px;">
					<br />
					<button type="submit" id="login-submit" class="btn btn-default pull-right">Log in</button>
				</div>

			</form>

		</div>

	</div>

</div>

<script>
	$(document).ready(function(){
		
		//login enable/disable
		$('#un, #pw').on('change', function(){
			if($I('un').value === '' && $I('un').value === '') $I('login-submit').disabled = true;
			else $I('login-submit').disabled = false;
		});
	
	});
</script>