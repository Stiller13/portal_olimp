{extends file="Main.tpl"}
{block name=title}Личная переписка{/block}
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
		<form role="form" action="/cabinet/message/personal/new" method="post">
			<input type="hidden" name="status" value="0">
			<input type="hidden" name="secret_param" value='top_secret!'>
			<input type="submit" class="btn btn-success" value="Новая группа">
		</form>
		<ul class="nav nav-pills nav-stacked">
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
					<span class="badge pull-right">{$one_group->getVisit()->getCountMessage()}</span>
					{/if}
				</a>
			</li>
		{/foreach}
		</ul>
	</div>
</div>
{/block}
