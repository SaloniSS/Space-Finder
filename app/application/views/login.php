<!DOCTYPE html>
<html>
<head>
	<title></title>
	<?= style_link_tag('main') ?>
	<script src="https://apis.google.com/js/api:client.js"></script>
	<script>
		var googleUser = {};
		var startApp = function() {
			gapi.load('auth2', function(){
				auth2 = gapi.auth2.init({
					client_id: '<?= $google_signin_client_id ?>'
				});
				attachSignin(document.getElementById('gSignIn'));
			});
		};
	</script>
</head>
<body id="landing">
	<main>
		<div id="gSignInWrapper">
			<div id="gSignIn">
				<i class="icon material-icons">arrow_forward</i><!--
				--><span class="text">Begin</span>
			</div>
		</div>

	</main>

	<script>startApp();</script>
	<?= script_tag('login') ?>

</body>
</html>



	
			