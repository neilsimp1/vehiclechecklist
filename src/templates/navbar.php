<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container-fluid">
		
		<div class="navbar-header">
			<?php if(isset($_SESSION['USER_ID']) && $_SESSION['USER_GRP'] == 1){ ?>
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			<?php } ?>
			<a class="navbar-brand" href="#">Vehicle Checklist</a>
		</div>
		
		<?php if(isset($_SESSION['USER_ID'])){ ?>
			<div class="collapse navbar-collapse" id="navbar">
				<?php if($_SESSION['USER_GRP'] == 1){ ?>
					<ul class="nav navbar-nav">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Employees <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="./employees">View</a></li>
								<li><a href="./addemployee">Add</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Checklists <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="./checklists">View</a></li>
								<li><a href="./addchecklist">Add</a></li>
							</ul>
						</li>
					</ul>
				<?php } ?>
				<ul class="nav navbar-nav navbar-right">
					<li><a><?php echo $_SESSION['USER_NAME']; ?></a></li>
					<li><a href="./includes/logout.php">Logout</a></li>
				</ul>
			</div>
		<?php } ?>
	</div>
</nav>