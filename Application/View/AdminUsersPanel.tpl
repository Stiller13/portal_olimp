{extends file="AdminCabinet.tpl"}
{block name=admin_cab_menu_users}active{/block}
{block name=admin_cab_content}
<ul class="nav nav-tabs margtp-15">
	<li class="{block name=admin_users_menu_all}{/block}"><a href="/admin_cabinet/users/all">Все</a></li>
	<li class="{block name=admin_users_menu_moderators}{/block}"><a href="/admin_cabinet/users/moderators">Модераторы</a></li>
	<li class="{block name=admin_users_menu_search}{/block}"><a href="/admin_cabinet/users/search">Поиск</a></li>
</ul>

{block name=admin_users_content}{/block}

{/block}