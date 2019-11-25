<header id="title-bar">
	<div class="left">
		<div class="title heading">SpaceFinder</div>
		<img class="logo" src="<?= asset('bitmap/temoc1.png') ?>">
	</div>
	<div class="right">
		<div class="name"><?= $user->display_name ?></div>
		<a href="/logout" class="logout"><span>Logout</span></div>
	</div>
</header>
<div id="title-bar-space"></div>
<?= style_link_tag('titleBar') ?>