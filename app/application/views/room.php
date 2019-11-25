<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?= style_link_tag('room') ?>
</head>
<body id="room">

	<?= $titleBar; ?>

	<div id="navigation-bar">
		<a href="/find"><i class="material-icons">home</i></a>
		<i class="material-icons">keyboard_arrow_right</i>
		<a href="/find/building"><i class="material-icons">location_city</i></a>
		<i class="material-icons">keyboard_arrow_right</i>
		<a href="/find/building/<?= $room->building->id ?>"><?= $room->building->name ?></a>
		<i class="material-icons">keyboard_arrow_right</i>
		<a href="/find/room/<?= $room->id ?>"><?= $room->name ?></a>
	</div>

	<?= $myRoom; ?>

	<main>
		<h2 class="heading">
			<?= $room->building->name ?><br>
			<?= $room->name ?>
			<?= $room->number_floor ?>.<?= $room->number_extension ?>
		</h2>
		<div class="options">

			<?php if ($room->color == 2) { ?>
				<div class="option"><a class="button orange-button" href="/checkin/<?= $room->id ?>">Check In</a></div>
			<?php } else if ($room->color == 0) { ?>
				<?php if (isset($user->room) && ($user->room->id == $room->id)) { ?>
					<p><i class="error material-icons">check</i>Checked in</p>
					<div class="option"><a class="button orange-button" href="/create_event/room/<?= $room->id ?>">Make Public</a></div>
					<div class="option"><a class="button orange-button" href="/checkout">Check Out</a></div>
				<?php } else { ?>
					<p><i class="error material-icons">warning</i> Someone claims to be in this room. If you think they left without checking out, you can check in to claim the room.</p>
					<div class="option"><a class="button orange-button" href="/checkin/<?= $room->id ?>">Check In</a></div>
				<?php } ?>
			<?php } else { ?>
				<div id="event">
					<h2>Event Going On</h2>
					<h3><?= $room->event->title ?></h3>
					<p><?= $room->event->description ?></p>
				</div>
				<?php if (isset($user->room) && ($user->room->id == $room->id)) { ?>
					<div class="option"><a class="button orange-button" href="/create_event/room/<?= $room->id ?>">Edit Event</a></div>
					<div class="option"><a class="button orange-button" href="/checkout">Check Out</a></div>
				<?php } else { ?>
					<div class="option"><a class="button orange-button" href="/join/<?= $room->id ?>">Join</a></div>
					<br>
					<p>If you think the event creator forgot to check out, you can check in to claim the room.</p>
					<div class="option"><a class="button orange-button" href="/checkin/<?= $room->id ?>">Check In</a></div>
				<?php } ?>
			<?php } ?>

		</div>
	</main>

	

</body>
</html>