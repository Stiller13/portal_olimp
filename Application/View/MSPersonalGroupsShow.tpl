<!DOCTYPE html>
<html>
	<head>
		<title>Личные сообщения</title>
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
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Моё <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="/cabinet">Кабинет</a></li>
								<li><a href="/SignOut">Выход</a></li>
							</ul>
						</li>
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

					<form class="navbar-form navbar-left" role="search">
						<div class="form-group">
						<input type="text" class="form-control" placeholder="Search">
						</div>
						<button type="submit" class="btn btn-success">Submit</button>
					</form>

					{if $user}
					<p class="navbar-text pull-right">Вы вошли как {$user->getName()} {$user->getFamily()}</p>
					{else}
					<div class="pull-right">
						<a href="/SignIn" >
							<button type="button" class="btn btn-default navbar-btn">Вход</button>
						</a>
						<a href="/Registration" >
							<button type="button" class="btn btn-primary navbar-btn">Регистрация</button>
						</a>
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
				<li><a href="/cabinet/account">Аккаунт</a></li>
				<li><a href="/cabinet/profile">Профиль</a></li>
				<li class="active"><a href="/cabinet/message">Сообщения</a></li>
				<li><a href="/cabinet/statistic">Статистика</a></li>
			</ul>

			<div class="row margtp-25">
				<div class="col-md-3">
					<ul class="nav nav-pills nav-stacked">
						<li class="active">
							<a href="/cabinet/message/personal">
								<span class="badge pull-right"></span>
								Личные
							</a>
						</li>
						<li>
							<a href="/cabinet/message/system">
								<span class="badge pull-right"></span>
								Системные
							</a>
						</li>
					</ul>
				</div>
				<div class="col-md-4 col-md-3-offset">
					<a href="/cabinet/message/personal/new"><button class="btn btn-success">Новая группа</button></a>
					<ul>
					{foreach from=$list_group item=one_group}
						<li>
							<a href="/cabinet/message/personal/{$one_group->getId()}">
								{foreach from=$one_group->getPartners() item=one_partner}
								{if $user->getId() eq $one_partner->getId()}
								Вы 
								{else}
								{$one_partner->getName()} 
								{/if}
								{/foreach}
								{if $one_group->getVisit()}
								<span class="badge">{$one_group->getVisit()->getCountMessage()}</span>
								{/if}
							</a>
						</li>
					{/foreach}
					</ul>
				</div>
			</div>
			
		</div>
		<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
		<script src="/Design/js/bootstrap.min.js"></script>
	</body>
</html>