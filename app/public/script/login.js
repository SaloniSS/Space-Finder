function redirectPost(url, data) {
	var form = document.createElement('form');
	document.body.appendChild(form);
	form.method = 'post';
	form.action = url;
	for (var name in data) {
		var input = document.createElement('input');
		input.type = 'hidden';
		input.name = name;
		input.value = data[name];
		form.appendChild(input);
	}
	form.submit();
}

function attachSignin(element) {
	auth2.attachClickHandler(element, {}, function(googleUser) {
		var id_token = googleUser.getAuthResponse().id_token;

		const urlParams = new URLSearchParams(window.location.search);
		const redirect_to = urlParams.get('redirect_to');

		redirectPost(`auth/login?redirect_to=` + redirect_to, {"id_token": id_token});
	});
}