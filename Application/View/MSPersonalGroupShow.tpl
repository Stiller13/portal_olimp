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
								<span class="badge pull-right">{$personal_mess}</span>
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
					<p>Добавить участников</p>
					<form role="form" action="/cabinet/message/personal/add_users" method="post">
						<select name="users[]" multiple class="form-control">
						{foreach from=$user_list item=one_user}
							<option value={$one_user->getId()}>{$one_user->getName()} {$one_user->getFamily()}</option>
						{/foreach}
						</select>
						<input type="hidden" name="group_id" value={$group->getId()}>
						<input type="hidden" name="secret_param" value='top_s_e_cret'>
						<button type="submit" class="btn btn-success">Добавить</button>
					</form>
					<hr>
					Участники : 
					{foreach from=$group->getPartners() item=partner}
					{$partner->getName()} {$partner->getFamily()} 
					{/foreach}

					{foreach from=$group->getMessages() item=one_message}
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">
								{$one_message->getAuthor()->getName()} 
								{$one_message->getAuthor()->getFamily()} 
								<p class="pull-right">{$one_message->getDate()}</p>
							</h3>
						</div>
						<div class="panel-body">
							{$one_message->getText()}
						</div>
					</div>

					{/foreach}
					<form role="form" action="/cabinet/message/personal/new_message" method="post">
						<div class="form-group">
							<label for="exampleInputText">Текст сообщения</label>
							<input type="textarea" class="form-control" id="exampleInputText" name="text">
						</div>
						<div class="form-group">
							<label for="exampleInputFile">Файл</label>
							<input type="file" id="exampleInputFile">
							<p class="help-block">Выберите файл для отправки</p>
						</div>
						<input type="hidden" name="user_id" value={$user->getId()}>
						<input type="hidden" name="group_id" value={$group->getId()}>
						<input type="hidden" name="status" value="0">
						<input type="hidden" name="id_remessage" value="0">
						<input type="hidden" name="secret_param" value='top_secret!'>
						<button type="submit" class="btn btn-success">Отправить</button>
					</form>
				</div>
			</div>
			
		</div>
		<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
		<script src="/Design/js/bootstrap.min.js"></script>
	</body>
</html>
