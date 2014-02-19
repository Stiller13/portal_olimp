{extends file="Main.tpl"}
{block name=content}

<h2 class="text-center">Кабинет администратора</h2>

<ul class="nav nav-tabs">
	<li class="{block name=admin_cab_menu_users}{/block}"><a href="/admin_cabinet/users">Пользователи</a></li>
	<li class="{block name=cab_menu_profile}{/block}"><a href="/admin_cabinet/events">Мероприятия</a></li>
	<li class="{block name=cab_menu_message}{/block}"><a href="/admin_cabinet/news">Новости</a></li>
	<li class="{block name=admin_cab_menu_message}{/block}"><a href="/admin_cabinet/message">Сообщения</a></li>
</ul>

{block name=admin_cab_content}{/block}

{/block}
