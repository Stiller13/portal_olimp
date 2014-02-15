{extends file="Main.tpl"}
{block name=title}Мой аккаунт{/block}
{block name=content}

<h2 class="text-center">Личный кабинет</h2>

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
{/block}
