<!DOCTYPE html>
<html>
<head>
	<title>Регистрация</title>
	<meta charset="utf8">
	<link href="/Design/css/bootstrap.css" rel="stylesheet">
	<style type="text/css">
		.form-signin {
			width: 250px;
			margin: 0 auto;
			margin-top: 200px;
			/*border-style: solid;*/
			/*border-bottom: 2px;*/
		}
		.form-registration {
			margin: 0 auto;
			width: 250px;
		}
		.btn[name="signin"] {
			margin-top: 20px;
			margin-left: 90px;
		}
		.btn[name="registration"] {
			margin-top: 20px;
			margin-left: 60px;
		}
		.control-label[for="inputLogin"] {
			margin-left: 100px;
			margin-bottom: 10px;
		}
		.control-label[for="inputPassword"] {
			margin-left: 90px;
			margin-bottom: 10px;
		}
		.alert {
			text-align: center;
		}
	</style>
</head>
<body>
	<div class="container">
		<form class="form-horizontal form-signin" method="post" action="/Registration">
			{if $message_error}<div class="alert alert-danger">{$message_error}</div>{/if}
			<div class="control-group">
				<label class="control-label" for="inputLogin">Login</label>
				<input type="text" name="login" class="form-control" id="inputLogin" placeholder="Login">
			</div>
			<div class="control-group">
				<label class="control-label" for="inputPassword">Password1</label>
				<input type="password" name="pass1" class="form-control" id="inputPassword" placeholder="Password1">
			</div>
			<div class="control-group">
				<label class="control-label" for="inputPassword">Password2</label>
				<input type="password" name="pass2" class="form-control" id="inputPassword" placeholder="Password2">
			</div>
			<div class="control-group">
				<div class="controls">
					<button type="submit" name="signin" class="btn btn-success">Registration</button>
				</div>
			</div>
		</form>
	</div>
</body>
</html>
