<aside class="main-sidebar">
	<div class="sidebar">
		<div class="user-panel">
			<div class="pull-left image">
				<img src="images/hescom.jpg" class="img-circle" alt="User Image">
			</div>
			<div class="pull-left info">
				<p><?php if (isset($_SESSION['name'])) {
					echo $_SESSION['name'];
				} ?></p>
			</div>
		</div>
		<!-- <span style="height:50px;" id="clock" class="form-control" value=""></span> -->
		<ul class="sidebar-menu">
			<li>
				<a href="index.php">
					<i class="fa fa-dashboard"></i> <span>Dashboard</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-right pull-right"></i>
					</span>
				</a>
			</li>
			<li>
				<a href="resolutionlist.php">
					<i class="fa fa-list"></i> <span>Fault List</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-right pull-right"></i>
					</span>
				</a>
			</li>
			<li>
				<a href="export_to_excel.php">
					<i class="fa fa-list"></i> <span>Export to excel</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-right pull-right"></i>
					</span>
				</a>
			</li>
			<?php
			if($usertype==4){
				echo '<li>
				<a href="edit_database.php">
					<i class="fa fa-list"></i> <span>Edit Database</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-right pull-right"></i>
					</span>
				</a>
			</li>';
			}
			?>
		</ul>
	</div>
</aside>