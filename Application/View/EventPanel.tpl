{extends file="Main.tpl"}
{block name=menu_events}active{/block}
{block name=content}

<!-- <div class="row">
	<div class="col-md-10 col-md-offset-1"> -->
		<h1 class="text-center">{block name=panel_title}{/block}</h1>
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
<!-- 	</div>
</div>
 -->
{/block}