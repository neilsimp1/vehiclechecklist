<?php
	
	//Imports
	require_once 'includes/db.php';
	require_once 'includes/User.php';
	require_once 'includes/Employee.php';

	$con = connect_db();
	
	$employees = new Employees();
	$employees->get($con);
	
	$con->close();

?>

<div class="container content">
		
	<h3>Employees</h3>
		
	<?php
		if(count($employees->employees) === 0) echo '<div class="text-center">No employees found</div>';
		else{
			echo '<ul class="ul">';
			foreach($employees->employees as $employee){ ?>
				<li data-id="<?php echo $employee->id; ?>">
					<span>Name: <?php echo $employee->name; ?></span><br />
					<span>Username: <?php echo $employee->un; ?></span><br /><br />
					<span>Completed Today: <?php echo $employee->completedtoday? 'Yes': 'Nope'; ?></span>
				</li>
			<?php }
			echo '</ul>';
		}
	?>

</div>

<script>
	$(document).ready(function(){
		
		$('ul.ul li').on('click', function(){
			window.location = './employee?_=' + $(this).data('id');
		});
		
	});
</script>