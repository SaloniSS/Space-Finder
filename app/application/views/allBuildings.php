<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?= style_link_tag('allBuildings') ?>
</head>
<body id="allBuildings">
	
	<?= $titleBar; ?>

	<div id="navigation-bar">
		<a href="/find"><i class="material-icons">home</i></a>
		<i class="material-icons">keyboard_arrow_right</i>
		<a href="/find/building"><i class="material-icons">location_city</i></a>
	</div>
	
	<?= $myRoom; ?>

	
	<main>
		<div class="buildingContainer">
			<h1 class="heading">Buildings</h1>
			<div class="buildings">
				<?php foreach ($buildings as $building): ?>

					
					<a href="/find/building/<?= $building->id ?>" class="building color-<?= $building->color ?>">
						<div class="name"><?= $building->name ?></div>
						<div class="open"><?= $building->greenRoomCount ?> room(s) vacant</div>
						<div class="cond"><?= $building->yellowRoomCount ?> event(s) going on</div>
					</a>

				<?php endforeach; ?>
			</div>
		</div>
	</main>

</body>
</html>