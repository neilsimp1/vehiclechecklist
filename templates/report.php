<div class="container content">
		
	<h3>Report</h3>
	<h4 class="text-right"><?php echo date('m/d/Y'); ?></h4>
	
	<?php
		if(count($report->employees) === 0) echo '<div class="text-center">No employees found</div>';
		else{
			echo '<ul class="report">';
			foreach($report->employees as $employee){ ?>
				<li class="report-closed" data-showtype="list">
					<span class="bigger expander"><?php echo $employee->name; ?></span><br />
					<span class="emp-completedtoday">Completed Today: <?php echo $employee->completedtoday; ?></span><br />
					<ul>
						<?php foreach($employee->lists as $list){ ?>
							<li class="report-closed list" data-showtype="item">
								<span class="bigger expander"><?php echo $list->name; ?></span>
								<ul>
									<?php foreach($list->items as $item){ ?>
										<li class="item<?php if($item->done) echo ' strike font-italic'; ?>"><?php echo $item->desc; ?></li>
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
		
		$('.expander').on('click', function(){
			var li = this.parentNode;
			var showtype = $(li).data('showtype');
			if(li.className.indexOf('closed') !== -1){
				$(li).find('ul li.' + showtype).slideDown(200);
				li.className = li.className.replace('closed', 'open');
			}
			else{
				$(li).find('ul li.' + showtype).slideUp(200);
				li.className = li.className.replace('open', 'closed');
			}
		});
		
	});
</script>