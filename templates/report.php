<div class="container content">
		
	<h3>Report</h3>
	<h4 class="text-right"><?php echo date('m/d/Y'); ?></h4>
	
	<?php
		if(count($report->employees) === 0) echo '<div class="text-center">No employees found</div>';
		else{
			echo '<ul>';
			foreach($report->employees as $employee){ ?>
				<li>
					<span class="bigger"><?php echo $employee->name; ?></span><br />
					<span>Completed Today: <?php echo $employee->completedtoday; ?></span><br />
					<ul>
						<?php foreach($employee->lists as $list){ ?>
							<li>
								<span><?php echo $list->name; ?></span>
								<ul>
									<?php foreach($list->items as $item){ ?>
										<li <?php if($item->done) echo 'class="strike"'; ?>><?php echo $item->desc; ?></li>
									<?php } ?>
								</ul>
							</li>
						<?php } ?>
					</ul>
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