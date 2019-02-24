<?php if (isset($user->room) && $user->room) { ?>
	<div id="my-room">
		You are in
		<?= $user->room->name ?>
		<?= $user->room->number_floor ?>.<?= $user->room->number_extension ?>
		@
		<?= $user->room->building->name ?><br>
		<a class="myRoomBtn" href="/find/room/<?=  $user->room->id ?>">View</a>
		<a  class="myRoomBtn" href="/checkout">Checkout</a> 
	</div>
<?= style_link_tag('myRoom') ?>
<?php } ?>