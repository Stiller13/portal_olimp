{extends file="Main.tpl"}
{block name=title}Мои сообщения{/block}
{block name=content}

<h2 class="text-center">Личный кабинет</h2>

<ul class="nav nav-tabs">
	<li><a href="/cabinet/account">Аккаунт</a></li>
	<li><a href="/cabinet/profile">Профиль</a></li>
	<li class="active"><a href="/cabinet/message">Сообщения</a></li>
	<li><a href="/cabinet/statistic">Статистика</a></li>
</ul>

<div class="row margtp-25">
	<div class="col-md-3">
		<ul class="nav nav-pills nav-stacked">
			<li>
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
</div>
{/block}
