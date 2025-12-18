<?php

    // Simple form handler for join submissions
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: join.html');
        exit;
    }

    // Collect and sanitize inputs
    $name         = trim((string)filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $businessName = trim((string)filter_input(INPUT_POST, 'businessName', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $mobile       = trim((string)filter_input(INPUT_POST, 'mobile', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $email        = trim((string)filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $city         = trim((string)filter_input(INPUT_POST, 'city', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $address      = trim((string)filter_input(INPUT_POST, 'address', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $description  = trim((string)filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $termsAgreed  = filter_input(INPUT_POST, 'terms');

    if ($name === '' || $mobile === '' || $email === '' || $city === '' || $termsAgreed !== 'on') {
        http_response_code(400);
        echo 'Required fields are missing or terms not accepted.';
        exit;
    }

    $to      = 'pettomets@gmail.com';
    $subject = 'New On-boarding Submission - Pettomets';

    $bodyLines = [
        "New onboarding submission received:",
        "Name: $name",
        "Business Name: " . ($businessName !== '' ? $businessName : 'N/A'),
        "Mobile: $mobile",
        "Email: $email",
        "City: $city",
        "Address: " . ($address !== '' ? $address : 'N/A'),
        "Service Description: " . ($description !== '' ? $description : 'N/A'),
    ];

    $message = implode("\n", $bodyLines);

    // Set simple headers
    $headers = 'From: no-reply@pettomets.com' . "\r\n" .
            'Reply-To: ' . ($email !== '' ? $email : 'no-reply@pettomets.com') . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

    // Attempt to send email; continue to thank-you screen regardless
    @mail($to, $subject, $message, $headers);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Thank You | Pettomets</title>
	<meta http-equiv="refresh" content="5;url=index.html">
	<style>
		body {
			font-family: Arial, sans-serif;
			display: flex;
			align-items: center;
			justify-content: center;
			min-height: 100vh;
			margin: 0;
			background: #f7f7f7;
			color: #333;
		}
		.thankyou {
			background: #fff;
			padding: 24px 28px;
			border: 1px solid #e0e0e0;
			border-radius: 8px;
			box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
			text-align: center;
			max-width: 480px;
		}
		.countdown {
			margin-top: 12px;
			font-weight: bold;
			color: #1a7c4b;
		}
		a {
			color: #1a7c4b;
		}
	</style>
</head>
<body>
	<div class="thankyou">
		<h2>Thank you!</h2>
		<p>We have received your details. Our team will reach out shortly.</p>
		<p class="countdown">Redirecting to home in <span id="counter">5</span> seconds...</p>
		<p>If you are not redirected, <a href="index.html">click here</a>.</p>
	</div>

	<script>
		(function () {
			var counter = 5;
			var interval = setInterval(function () {
				counter -= 1;
				var el = document.getElementById('counter');
				if (el) {
					el.textContent = counter;
				}
				if (counter <= 0) {
					clearInterval(interval);
					window.location.href = 'index.html';
				}
			}, 1000);
		})();
	</script>
</body>
</html>