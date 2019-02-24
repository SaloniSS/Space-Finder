<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

	<?php foreach ($rooms as $room): ?>
		
		<a href="/find/room/<?= $room->id ?>" class="room">
			<?= $room->number_floor ?>
			<?= $room->number_extension ?>
			<?= $room->name ?>
		</a>

	<?php endforeach; ?>

</body>
</html>