{extends file="Main.tpl"}
{block name=menu_my}active{/block}
{block name=content}

<h2 class="text-center">Личный кабинет</h2>

<ul class="nav nav-tabs">
	<li class="{block name=cab_menu_account}{/block}"><a href="/cabinet/account">Аккаунт</a></li>
	<li class="{block name=cab_menu_profile}{/block}"><a href="/cabinet/profile">Профиль</a></li>
	<li class="{block name=cab_menu_message}{/block}"><a href="/cabinet/message/personal">Сообщения</a></li>
	<li class="{block name=cab_menu_statistic}{/block}"><a href="/cabinet/statistic">Статистика</a></li>
	<li class="{block name=cab_menu_file}{/block}"><a href="/cabinet/file">Файлы</a></li>
</ul>

{block name=cab_content}{/block}

{/block}
