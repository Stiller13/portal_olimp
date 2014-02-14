<<<<<<< HEAD
<!DOCTYPE html>
<html>
	<head>
		<title>Регистрация</title>
		<meta charset="utf8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="/Design/css/styles.css" rel="stylesheet">
	</head>
	<body>
		<div class="container">
			<nav class="navbar navbar-default" role="navigation">
				<div class="collapse navbar-collapse navbar-ex1-collapse">
					<ul class="nav navbar-nav">
						{if $user}
							<li><a href="/cabinet">Кабинет</a></li>
						{/if}
						<li><a href="/">Главная</a></li>
						<li><a href="#">Новости</a></li>
						<li><a href="#">Мероприятия</a></li>
						<li><a href="#">Курсы</a></li>
						<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="#">Action</a></li>
							<li><a href="#">Another action</a></li>
							<li><a href="#">Something else here</a></li>
							<li><a href="#">Separated link</a></li>
							<li><a href="#">One more separated link</a></li>
						</ul>
						</li>
					</ul>

					{if $user}
					<form class="navbar-form navbar-left" role="search">
						<div class="form-group">
						<input type="text" class="form-control" placeholder="Search">
						</div>
						<button type="submit" class="btn btn-success">Submit</button>
					</form>
					<p class="navbar-text pull-right">Signed in as {$user->getName()} {$user->getFamily()} <a class="btn btn-danger btn-xs" href="/SignOut">SignOut</a></p>
					{else}
					<div class="collapse navbar-collapse navbar-ex1-collapse">
						<form class="navbar-form navbar-right" action="/SignIn" method="post">
							<div class="form-group">
								<a href="/Registration" class="navbar-link">Registration</a>
							</div>
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Login" name="login">
							</div>
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Password" name="pass">
							</div>
							<button type="submit" class="btn btn-success">SigIn</button>
						</form>
					</div>
					{/if}
				</div><!-- /.navbar-collapse -->
			</nav>
			{if $message}<div class="alert {$type_message}"><p class="text-center">{$message}</p></div>{/if}

			<div class="row">
				<div class="col-md-4 col-md-offset-3">
					<form class="form-horizontal" method="post" action="/Registration">
						<div class="input-group">
							<label class="control-label" for="inputLogin">Login</label>
							<input type="text" name="login" class="form-control" id="inputLogin" placeholder="Login">
						</div>
						<div class="input-group">
							<label class="control-label" for="inputPassword">Password1</label>
							<input type="password" name="pass1" class="form-control" id="inputPassword" placeholder="Password1">
						</div>
						<div class="input-group">
							<label class="control-label" for="inputPassword">Password2</label>
							<input type="password" name="pass2" class="form-control" id="inputPassword" placeholder="Password2">
						</div>
						<div class="input-group">
							<!-- <div class="controls"> -->
								<button type="submit" name="signin" class="btn btn-success">Registration</button>
							<!-- </div> -->
						</div>
					</form>
				</div>
=======
{extends file="MainPage.tpl"}
{block name=title}Регистрация{/block}
{block name=content}<!DOCTYPE html>
<div class="row">
	<div class="col-md-3 col-md-offset-4">
		<form class="form-horizontal" method="post" action="/Registration">
			<div class="form-group">
				<label class="control-label" for="inputLogin">Логин</label>
				<input type="text" name="login" class="form-control" id="inputLogin" placeholder="Логин">
>>>>>>> 89eb8bd191a9046ada292c7cdab679b5164d3513
			</div>
			<div class="form-group">
				<label class="control-label" for="inputPassword">Пароль</label>
				<input type="password" name="pass1" class="form-control" id="inputPassword" placeholder="Пароль">
			</div>
			<div class="form-group">
				<label class="control-label" for="inputPassword">Пароль</label>
				<input type="password" name="pass2" class="form-control" id="inputPassword" placeholder="Пароль">
			</div>
			<div class="form-group">
				<button type="submit" name="signin" class="btn btn-success">Регистрация</button>
			</div>
		</form>
	</div>
</div>
{/block}
