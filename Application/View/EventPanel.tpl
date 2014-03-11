{extends file="Main.tpl"}
{block name=menu_events}active{/block}
{block name=content}

		<h1 class="text-center">{$event->getTitle()}</h1>
		{if $rule eq "e_admin"}
		<ul class="nav nav-tabs">
			<li class="{block name=epanel_main}{/block}"><a href="/event/{$event->getId()}">Главная</a></li>
			<li class="{block name=epanel_change}{/block}"><a href="/event/{$event->getId()}/change">Редактирование</a></li>
			<li class="{block name=epanel_partners}{/block}"><a href="/event/{$event->getId()}/partners">Участники</a></li>
			<li class="{block name=epanel_message}{/block}"><a href="/event/{$event->getId()}/message">Оповещения</a></li>
		</ul>
		<br>
		{else}
		<hr>
		{/if}

		{block name=epanel_content}{/block}

{/block}