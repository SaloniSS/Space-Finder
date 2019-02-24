<!DOCTYPE html>
<html>
<head>
	<title>Study Space Booking</title>
	<?= style_link_tag('main') ?>
</head>
<body id="form">


<form id="mainForm" method="POST" action="store">

	<h1>Find your study space!</h1>
	
    <span class="field">
		<label>What would you like to do?</label>
		<span><input type="radio" name="check" value="0" checked><label>Check in</label></span>
		<span><input type="radio" name="check" value="1"><label>Check out</label></span>
	</span>
	
	<input type="submit" name="" value="Next">

</form>

	<?= script_tag('form') ?>	

</body>
</html>