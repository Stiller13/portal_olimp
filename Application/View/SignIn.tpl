<<<<<<< HEAD
<!DOCTYPE html>
<html>
<head>
	<title>Вход в систему</title>
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
			margin-left: 75px;
		}
		.control-label[for="inputLogin"] {
			margin-left: 100px;
			margin-bottom: 10px;
		}
		.control-label[for="inputPassword"] {
			margin-left: 90px;
			margin-bottom: 10px;
		}
	</style>
</head>
<body>
	<div class="container">
		<form class="form-horizontal form-signin" method="post" action="/SignIn">
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
					<button type="submit" name="signin" class="btn btn-success">Sign in</button>
				</div>
			</div>
		</form>
		<!-- Кнопка на регистрация -->
		<form class="form-horizontal form-registration" method="get" action="/Registration">
			<div class="control-group">
				<div class="controls">
					<button type="submit" name="registration" class="btn btn-success">Registration</button>
				</div>
			</div>
		</form>
	</div>
</body>
</html>
=======
{extends file="MainPage.tpl"}
{block name=title}Авторизация{/block}
{block name=content}
<div class="row">
	<div class="col-md-3 col-md-offset-4">
		<form class="form-horizontal" method="post" action="/SignIn">
			<div class="form-group">
				<label class="control-label" for="inputLogin">Логин</label>
				<input type="text" name="login" class="form-control" id="inputLogin" placeholder="Логин">
			</div>
			<div class="form-group">
				<label class="control-label" for="inputPassword">Пароль</label>
				<input type="password" name="pass" class="form-control" id="inputPassword" placeholder="Пароль">
			</div>
			<div class="form-group">
				<button type="submit" name="signin" class="btn btn-success">Вход</button>
			</div>
		</form>
	</div>
</div>
{/block}
>>>>>>> 89eb8bd191a9046ada292c7cdab679b5164d3513
