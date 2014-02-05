<!DOCTYPE html>
<html>
<head>
	<title>Вход в систему</title>
	<meta charset="utf8">
	<link href="/Design/css/bootstrap.css" rel="stylesheet">
	<link href="/Design/css/signin.css" rel="stylesheet">
</head>
<body>
	<div class="container">
		<form class="form-horizontal" method="post" action="/SignIn">
			<div class="control-group">
				<label class="control-label" for="inputLogin">Login</label>
				<input type="text" name="login" class="form-control" id="inputLogin" placeholder="Login">
			</div>
			<div class="control-group">
				<label class="control-label" for="inputPassword">Password</label>
				<input type="password" name="pass" class="form-control" id="inputPassword" placeholder="Password">
			</div>
			<div class="control-group">
				<div class="controls">
					<!-- <label class="checkbox">
						<input type="checkbox"> Remember me
					</label> -->
					<button type="submit" class="btn btn-success">Sign in</button>
				</div>
			</div>
		</form>
	</div>
</body>
</html>