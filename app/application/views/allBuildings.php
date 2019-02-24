<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

	<?php foreach ($buildings as $building): ?>
		
		<a href="/find/building/<?= $building->id ?>" class="building">
			<?= $building->name ?>
		</a>

	<?php endforeach; ?>

</body>
</html>