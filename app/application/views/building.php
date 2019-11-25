<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?= style_link_tag('building') ?>
</head>
<body id="building">

	<?= $titleBar; ?>

	<div id="navigation-bar">
		<a href="/find"><i class="material-icons">home</i></a>
		<i class="material-icons">keyboard_arrow_right</i>
		<a href="/find/building"><i class="material-icons">location_city</i></a>
		<i class="material-icons">keyboard_arrow_right</i>
		<a href="/find/building/<?= $building->id ?>"><?= $building->name ?></a>
	</div>

	<?= $myRoom; ?>

	<main>
		<div class="roomContainer">
			<h1 class="heading"><?= $building->name ?></h1>
			<div class="rooms">
				<?php foreach ($rooms as $room): ?>

					<a href="/find/room/<?= $room->id ?>" class="room color-<?= $room->color ?>">
						<div class="name"><?= $room->name ?></div>
						<div class="number"><?= $room->number_floor ?>.<?= $room->number_extension ?></div>
					</a>

				<?php endforeach; ?>
			</div>
		</div>
	</main>

</body>
</html>