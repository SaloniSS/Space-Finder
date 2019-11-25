<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?= style_link_tag('find') ?>
</head>
<body id="find">

	<?= $titleBar; ?>

	<div id="navigation-bar">
		<a href="/find"><i class="material-icons">home</i></a>
	</div>

	<?= $myRoom; ?>

	<main>
		
		<div class="eventContainer">
			<h1 class="heading">Events</h1>
			<div class="events">
				<?php if (count($events) == 0) { ?>
					<div class="event no-event">No events to show</div>
				<?php } else { ?>
					<?php foreach ($events as $event) { ?>
						<a class="event" href="/find/room/<?= $event->checkin->room->id ?>">
							<i class="material-icons icon">
								<?php
									if ($event->study) echo "laptop";
									else echo "videogame_asset";
								?>
							</i>
							<div class="title"><?= $event->title ?></div>
							<div class="building">@<?= $event->checkin->room->building->name ?></div>
						</a>
					<?php } ?>
				<?php } ?>
			</div>
		</div>

		<a class="button orange-button next" href="/find/building"><span class="text">Find a Room</span><i class="icon material-icons">search</i></a>
	</main>


</body>
</html>