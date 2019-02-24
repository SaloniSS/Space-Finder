<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?= style_link_tag('landing') ?>
</head>
<body id="landing">
	<main>
		<img id="logo" src="<?= asset('bitmap/utdlogo1.png') ?>">
		<h1 class="heading">SpaceFinder</h1>
		<p id="description">Find available spaces on campus for studying, gaming, or just hanging out!</p>
		<div id="button-container"><a id="begin" class="button orange-button" href="/login"><span class="text">Begin</span><i class="icon material-icons"></i></a></div>
	</main>
</body>
</html>