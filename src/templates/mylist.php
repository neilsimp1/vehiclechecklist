<div class="container content">
	
	<h3><?php echo $list->name; ?></h3>
	<h4 class="text-right"><?php echo date('m/d/Y'); ?></h4>
		
	<div class="form-group">
		<br />
		<label class="control-label">Tasks</label><br />
		<br />
		<ul id="ul_tasks" class="ul ul-nopointer">
			<?php foreach($list->items as $item){ ?>
				<li class="li_task">
					<span><?php echo $item->desc; ?></span>
					<div class="pull-right">
						<input type="checkbox" class="task" data-id="<?php echo $item->id; ?>" <?php if($item->done) echo 'checked="checked"'; ?> />
					</div>
				</li>
			<?php } ?>
		</ul>
		<input type="hidden" id="id" value="<?php echo $list->id; ?>" />
	</div>

</div>

<script>
	$(document).ready(function(){
		
		//checkbox change
		$('.task').on('change', function(e){
			var listID = $I('id').value
				,itemID = $(this).data('id')
				,done = this.checked;
			
			$.post('includes/listItemDone.php', {listID: listID, itemID: itemID, done: done})
			.done(function(ret){
				//maybe run a check for if all checked, show something???
			})
			.fail(function(ret){alert('There was a problem saving list status: ' + ret.responseText);});		
		});
		
		////click row > checkbox
		//$(document).on('click', '.li_task', function(){
		//	$(this).find('.task').click();
		//});
				
	});
</script>