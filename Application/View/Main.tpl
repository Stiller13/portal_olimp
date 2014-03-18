<!DOCTYPE html>
<html>
	<head>
		<title>{block name=title}{/block}</title>
		<meta charset="utf8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="/Design/css/styles.css" rel="stylesheet">
	</head>
	<body>
		<div class="container">
			<a href="/">
			<img src="/Design/images/bsu2.gif" alt="olimpBSU">
			</a>
			<nav class="navbar navbar-default" role="navigation">
				<div class="collapse navbar-collapse navbar-ex1-collapse">
					<ul class="nav navbar-nav">
						{if $user}
						<li class="dropdown {block name=menu_my}{/block}">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Моё <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="/cabinet">Кабинет</a></li>
								<li><a href="/allusers">Все соседи</a></li>
								<li><a href="/SignOut">Выход</a></li>
							</ul>
						</li>
						{/if}
						<li class="{block name=menu_main}{/block}"><a href="/">Главная</a></li>
						<li class="{block name=menu_news}{/block}"><a href="/news">Новости</a></li>
						<li class="{block name=menu_events}{/block}"><a href="/event">Мероприятия</a></li>
						<li class="dropdown {block name=menu_info}{/block}">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Информация <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="#">О проекте</a></li>
								<li><a href="#">О нас</a></li>
							</ul>
						</li>
					</ul>

<!-- 					<form class="navbar-form navbar-left" role="search">
						<div class="form-group">
						<input type="text" class="form-control" placeholder="Поиск">
						</div>
						<button type="submit" class="btn btn-primary">Найти</button>
					</form> -->

					{if $user}
					<p class="navbar-text pull-right">Вы вошли как {$user->getName()} {$user->getFamily()}</p>
					{else}
					<div class="pull-right">
						<a href="/SignIn">
							<button type="button" class="btn btn-default navbar-btn">Вход</button>
						</a>
						<a href="/Registration">
							<button type="button" class="btn btn-primary navbar-btn">Регистрация</button>
						</a>
					</div>
					{/if}
				</div><!-- /.navbar-collapse -->
			</nav>
			{if $message}<div class="alert {$type_message}"><p class="text-center">{$message}</p></div>{/if}

			{block name=content}{/block}

			<div class="well margtp-25">&copy;&nbsp;2014 <a href="http://bsu.ru">Бурятский государственный университет</a></div>
		</div>
		<script src="/Design/js/jquery-1.10.2.min.js"></script>
		<script src="/Design/js/bootstrap.js"></script>
	</body>
</html>
