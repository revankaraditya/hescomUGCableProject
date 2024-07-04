<header class="main-header">
	<a href="index.php" class="logo">
		<span class="logo-mini"><b>HESCOM</b></span>
		<span class="logo-lg"><b>HESCOM</b></span>
	</a>
	<nav class="navbar navbar-static-top">
		<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
			<span class="sr-only">Toggle navigation</span>
		</a>
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
				<li class="dropdown user user-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<img src="images/hescom.jpg" class="user-image" alt="User Image">
						<span class="hidden-xs"><?php if (isset($_SESSION['name'])) {
							echo $_SESSION['name'];
						} ?>
						</span>
					</a>
					<ul class="dropdown-menu">
						<li class="user-header">
							<img src="images/hescom.jpg" class="img-circle" alt="User Image">
							<p>
								<?php if (isset($_SESSION['name'])) {
									echo $_SESSION['name'];
								} ?>
								<small>Member since <?php echo $login_query_result['member_since']; ?></small>
							</p>
						</li>
						<li class="user-footer">
							<div class="pull-left">
								<a href="profile.php" class="btn btn-default btn-flat">Profile</a>
							</div>
							<div class="pull-right">
								<a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
							</div>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</nav>
</header>