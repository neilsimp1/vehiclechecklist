<div class="container content">
		
	<h3>Employees</h3>
		
	<?php
		if(count($employees->employees) === 0) echo '<div class="text-center">No employees found</div>';
		else{
			echo '<ul class="ul">';
			foreach($employees->employees as $employee){ ?>
				<li data-id="<?php echo $employee->id; ?>">
					<span class="bigger"><?php echo $employee->name; ?></span><br />
					<span>Username: <?php echo $employee->un; ?></span><br /><br />
					<span>Completed Today: <?php echo $employee->completedtoday; ?></span><br />
					<span>Assigned to: <?php echo $employee->lists; ?></span>
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