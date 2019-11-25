<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?= style_link_tag('event') ?>
</head>
<body id="event">

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

		<h3 class="heading">Public Event</h3>

		<form id="event-form" method="POST" action="/edit_event/room/<?= $room->id ?>">
			<div class="field">
				<div>Title</div>
				<input name="title" type="text" value="<?= $form['title'] ?>" required min=1 max=16>
			</div>
			<div class="field">
				<div>Description</div>
				<textarea name="description"><?= $form['description'] ?></textarea>
			</div>
			<div class="field">
				<div>Usage</div>
				<fieldset>
					<div class="radio-field">
						<input type="radio" name="study" value="1" <?php if ($form['study']) echo "checked"; ?> >
						<div>Study</div>
					</div>
					<div class="radio-field">
						<input type="radio" name="study" value="0" <?php if (!$form['study']) echo "checked"; ?> >
						<div>Recreation</div>
					</div>
				</fieldset>
			</div>
			<div>
				<input type="submit" value="Save" class="button orange-button">
			</div>
		</form>

	</main>

</body>
</html>