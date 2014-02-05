<!DOCTYPE html>
<html>
<head>
	<title>Вход в систему</title>
	<meta charset="utf8">
	<link href="/Application/Design/css/bootstrap.css" rel="stylesheet">
	<link href="/Application/Design/css/signin.css" rel="stylesheet">
</head>
<body>
	<div class="container">
		<form class="form-horizontal" method="post" action="/SignIn">
			<div class="control-group">
				<label class="control-label" for="inputEmail">Login</label>
				<input type="text" name="login" class="form-control" id="inputEmail" placeholder="Login">
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
<!-- <h1>SignIn</h1>
<form method="post" action="/SignIn">
	Auth form<br /><br />
	<input name="login" type="text" /> Login <br />
	<input name="pass" type="text" /> Pass <br /><br />
	<input type="submit" value="Enter" style="height: 4em; cursor: pointer" />
</form> -->