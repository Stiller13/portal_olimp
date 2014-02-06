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
				{if $user}
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
			</nav>
			{if $message}<div class="alert alert-danger">{$message}</div>{/if}

			<div class="row">
				<div class="col-sm-6 col-md-4 col-md-offset-5">
					<a href="http://bsu.ru">
					<img src="/Design/images/bsu.gif" alt="ГБУ">
					<!-- цвет картинки #014397 -->
					</a>
				</div>
				<div class="col-sm-10 col-md-offset-1">
					<div class="page-header">
						<h1>Портал олимпиадной информатики <small>будущее зависит только от тебя</small></h1>
					</div>
				</div>
			</div>
			<nav class="navbar navbar-default" role="navigation">
				<div class="collapse navbar-collapse navbar-ex1-collapse">
					<ul class="nav navbar-nav">
						{if $user}
							<li class="active"><a href="/cabinet/profile">Кабинет</a></li>
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
					<form class="navbar-form navbar-right" role="search">
						<div class="form-group">
						<input type="text" class="form-control" placeholder="Search">
						</div>
						<button type="submit" class="btn btn-success">Submit</button>
					</form>
				</div><!-- /.navbar-collapse -->
			</nav>

			<div class="row">
				<div class="col-md-4 col-md-offset-4">
					<h2>Личный кабинет</h2>
				</div>
			</div>
			<ul class="nav nav-tabs">
				<li class="active"><a href="#">Профиль</a></li>
				<li><a href="#">Сообщения</a></li>
				<li><a href="#">Статистика</a></li>
			</ul>

			<div class="row">
				<div class="col-md-4 col-md-offset-4">
					<form class="form-horizontal" action="/cabinet/profile/save" method="post">
						<div class="input-group">
							<span class="input-group-addon">Имя</span>
							<input type="text" class="form-control" name="name" value={$user->getName()}>
						</div>
						<div class="input-group">
							<span class="input-group-addon">Фамилия</span>
							<input type="text" class="form-control" name="surname" value={$user->getFamily()}>
						</div>
						<div class="input-group">
							<span class="input-group-addon">Отчество</span>
							<input type="text" class="form-control" name="patronymic" value={$user->getPatronymic()}>
						</div>
						<div class="input-group">
							<span class="input-group-addon">Дата рождения</span>
							<input type="date" class="form-control" name="birthday" value={$user->getBirthday()}>
						</div>
						<div class="input-group">
							<span class="input-group-addon">Пол</span>
							<input type="text" class="form-control" name="gender" value={$user->getGender()}>
						</div>
						<div class="input-group">
							<span class="input-group-addon">Город</span>
							<input type="text" class="form-control" name="residence" value={$user->getResidence()}>
						</div>
						<div class="input-group">
							<span class="input-group-addon">Почта</span>
							<input type="text" class="form-control" name="mail" value={$user->getMail()}>
						</div>
						<div class="input-group">
							<span class="input-group-addon">Телефон</span>
							<input type="text" class="form-control" name="telephone" value={$user->getTelephone()}>
						</div>

						<div class="input-group">
							<button type="submit" class="btn btn-success">Сохранить</button>
						</div>
					</form>
				</div>
			</div>

		<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
		<script src="/Design/js/bootstrap.min.js"></script>
	</body>
</html>
