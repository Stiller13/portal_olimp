{extends file="MainPage.tpl"}
{block name=title}Моя статистика{/block}
{block name=content}
<div class="row">
	<div class="col-md-4 col-md-offset-4">
		<h2>Личный кабинет</h2>
	</div>
</div>
<ul class="nav nav-tabs">
	<li><a href="/cabinet/account">Аккаунт</a></li>
	<li><a href="/cabinet/profile">Профиль</a></li>
	<li><a href="/cabinet/message">Сообщения</a></li>
	<li class="active"><a href="/cabinet/statistic">Статистика</a></li>
</ul>
<p>Пока ничего нет</p>
{/block}
