<div class="container content">
		
	<h3>My Checklists</h3>
		
	<?php
		if(count($lists->lists) === 0) echo '<div class="text-center">No checklists found</div>';
		else{
			echo '<ul class="ul">';
			foreach($lists->lists as $list){ ?>
				<li data-id="<?php echo $list->id; ?>">
					<span class="bigger"><?php echo $list->name; ?></span><br />
				</li>
			<?php }
			echo '</ul>';
		}
	?>

</div>

<script>
	$(document).ready(function(){
		
		$('ul.ul li').on('click', function(){
			window.location = './mylist?_=' + $(this).data('id');
		});
		
	});
</script>