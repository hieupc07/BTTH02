<div class="col-md-3">
	<div class="list-group">
		<a href="dashboard.php" class="list-group-item <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?> "><span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
		Dashboard <span class="badge"><?php echo $post->totalPost()+$category->totalCategory()+$user->totalUser(); ?></span>
		</a>		
		<a href="posts.php" class="list-group-item <?php echo basename($_SERVER['PHP_SELF']) == 'posts.php' ? 'active' : ''; ?> "><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Posts<span class="badge"><?php echo $post->totalPost(); ?></span></a>
		<a href="categories.php" class="list-group-item <?php echo basename($_SERVER['PHP_SELF']) == 'categories.php' ? 'active' : ''; ?>"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Categories<span class="badge"><?php echo $category->totalCategory(); ?></span></a>
		<a href="users.php" class="list-group-item <?php echo basename($_SERVER['PHP_SELF']) == 'users.php' ? 'active' : ''; ?>"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Users <span class="badge"><?php echo $user->totalUser(); ?></span></a>
	</div>
</div>