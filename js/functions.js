function signup() {
	$('#login').fadeOut('slow');
	$('#signup').fadeOut('slow');
	$('#container').animate({
		paddingTop : '20px'
	}, 800, function() {
		$('#signupForm').fadeIn('slow');
		$('#signupSubmit').fadeIn('slow');
	});
}

function login() {
	$('#signupForm').fadeOut('slow');
	$('#signupSubmit').fadeOut('slow', function() {
		$('#container').animate({
			paddingTop : '200px'
		}, 800, function() {
			$('#signup').fadeIn('slow');
			$('#login').fadeIn('slow');
		});
	});
}