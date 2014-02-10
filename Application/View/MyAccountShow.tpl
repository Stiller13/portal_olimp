<!DOCTYPE html>
<html>
	<head>
		<title>Главная</title>
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
							<li class="active"><a href="/cabinet">Кабинет</a></li>
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
				<div class="col-md-4 col-md-offset-4">
					<h2>Личный кабинет</h2>
				</div>
			</div>
			<ul class="nav nav-tabs">
				<li class="active"><a href="/cabinet/account">Аккаунт</a></li>
				<li><a href="/cabinet/profile">Профиль</a></li>
				<li><a href="/cabinet/message">Сообщения</a></li>
				<li><a href="/cabinet/statistic">Статистика</a></li>
			</ul>

			<div class="row">
				<div class="col-md-4 col-md-offset-4">
					<form class="form-horizontal" action="/cabinet/account" method="post">
						<div class="input-group">
							<span class="input-group-addon">Старый пароль</span>
							<input type="text" class="form-control" name="old_pass"}>
						</div>
						<div class="input-group">
							<span class="input-group-addon">Новый пароль</span>
							<input type="text" class="form-control" name="new_pass1"}>
						</div>
						<div class="input-group">
							<span class="input-group-addon">Еще раз новый пароль</span>
							<input type="text" class="form-control" name="new_pass2"}>
						</div>
						<div class="input-group">
							<button type="submit" class="btn btn-success">Сохранить</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
		<script src="/Design/js/bootstrap.min.js"></script>
	</body>
</html>