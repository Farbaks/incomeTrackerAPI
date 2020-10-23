<!DOCTYPE html>
<html lang='en' xmlns='http://www.w3.org/1999/xhtml' xmlns:v='urn:schemas-microsoft-com:vml'
	xmlns:o='urn:schemas-microsoft-com:office:office'>

<head>
	<meta charset='utf-8'>
	<meta name='viewport' content='width=device-width'>
	<meta http-equiv='X-UA-Compatible' content='IE=edge'>
	<meta name='x-apple-disable-message-reformatting'>
	<title></title>
	<link href='https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700' rel='stylesheet'>
	<style>
		/* What it does: Remove spaces around the email design added by some email clients. */
		/* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
		html,
		body {
			margin: 0 auto !important;
			padding: 0 !important;
			height: 100% !important;
			width: 100% !important;
			background: #f1f1f1;
		}

		/* What it does: Stops email clients resizing small text. */
		* {
			-ms-text-size-adjust: 100%;
			-webkit-text-size-adjust: 100%;
		}

		/* What it does: Centers email on Android 4.4 */
		div[style*='margin: 16px 0'] {
			margin: 0 !important;
		}

		/* What it does: Fixes webkit padding issue. */
		table {
			border-spacing: 0 !important;
			border-collapse: collapse !important;
			table-layout: fixed !important;
			margin: 0 auto !important;
		}

		@media  only screen and (min-device-width: 320px) and (max-device-width: 374px) {
			u~div .email-container {
				min-width: 320px !important;
			}
		}

		/* iPhone 6, 6S, 7, 8, and X */
		@media  only screen and (min-device-width: 375px) and (max-device-width: 413px) {
			u~div .email-container {
				min-width: 375px !important;
			}
		}

		/* iPhone 6+, 7+, and 8+ */
		@media  only screen and (min-device-width: 414px) {
			u~div .email-container {
				min-width: 414px !important;
			}
		}
	</style>
	<style>
		.bg_white {
			background: #ffffff;
		}

		h1,
		h2,
		h3,
		h4,
		h5,
		h6 {
			font-family: 'Poppins', sans-serif;
			color: #000000;
			margin-top: 0;
			font-weight: 400;
		}

		body {
			font-family: 'Poppins', sans-serif;
			font-weight: 400;
			font-size: 15px;
			line-height: 1.8;
			color: rgba(0, 0, 0, .4);
		}

		a {
			color: #17bebb;
		}

		/*HERO*/
		.hero {
			position: relative;
			z-index: 0;
		}

		.hero .text {
			color: rgba(0, 0, 0, .3);
		}

		.hero .text h2 {
			color: #000;
			font-size: 34px;
			margin-bottom: 0;
			font-weight: 200;
			line-height: 1.4;
		}

		.hero .text h3 {
			font-size: 22px;
			font-weight: 300;
		}

		.hero .text h2 span {
			font-weight: 600;
			color: #000;
		}

		ul.social {
			padding: 0;
		}

		ul.social li {
			display: inline-block;
			margin-right: 10px;
		}
	</style>
</head>

<body width='100%' style='margin: 0; padding: 0 !important; background-color: #f1f1f1;'>
	<center style='width: 100%; background-color: #f1f1f1;'>
		<div style='max-width: 600px; margin: 0 auto;background-color: white !important;' class='email-container'>
			<table align='center' role='presentation' cellspacing='0' cellpadding='0' border='0' width='100%'
				style='margin: auto;'>
				<tr>
					<td valign='middle' class='hero bg_white' style='padding: 2em 20px 4em 20px;'>
						<p>Dear <?php echo e($name); ?>,</p>
						<p>
							The password for your email account <strong><?php echo e($email); ?></strong> was reset.
						</p>
						<p>
							Use your new temporary password - <strong><?php echo e($password); ?></strong> to log in.
                        </p>
                        <p>
                            <strong>
                                Do not share your password with anyone and once you log in, change your password.
                            </strong>
                        </p>
						<p>Best Regards,</p>
						<strong>
							Income Tracker
						</strong>
					</td>
				</tr>
			</table>
		</div>
	</center>
</body>

</html><?php /**PATH C:\Users\NAMI\Desktop\farouk\laravel\incomeTrackerAPI\resources\views/resetpasswordmail.blade.php ENDPATH**/ ?>