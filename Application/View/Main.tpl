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
						<!-- <li><a href="#">Курсы</a></li> -->
						<!-- <li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="#">Action</a></li>
								<li><a href="#">Another action</a></li>
								<li><a href="#">Something else here</a></li>
								<li><a href="#">Separated link</a></li>
								<li><a href="#">One more separated link</a></li>
							</ul>
						</li> -->
					</ul>

					<form class="navbar-form navbar-left" role="search">
						<div class="form-group">
						<input type="text" class="form-control" placeholder="Поиск">
						</div>
						<button type="submit" class="btn btn-primary">Найти</button>
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

			{block name=content}{/block}
			<div class="well margtp-25">БГУ 2014</div>
		</div>
		<script src="/Design/js/jquery-1.10.2.min.js"></script>
		<script src="/Design/js/bootstrap.min.js"></script>
		<script src="/Design/TinyMCE/tiny_mce.js"></script>
		<script type="text/javascript">
		tinyMCE.init({
			mode:"specific_textareas",
			editor_selector: "edit",
			language : "ru",
			plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
			theme : "advanced",
			theme_advanced_buttons1 : "bold,italic,underline,strikethrough,formatselect,forecolor,backcolor,link,unlink,justifyleft,justifycenter,justifyright,bullist,numlist,|,pasteword,pastetext,table,image,|,undo,redo,|,code,fullscreen",
			theme_advanced_buttons2 : "",
			theme_advanced_buttons3 : "",
			theme_advanced_toolbar_align : "left",
			relative_urls : false
		});
		</script>
	</body>
</html>
