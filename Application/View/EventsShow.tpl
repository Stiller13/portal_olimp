{extends file="Main.tpl"}
{block name=title}Главная{/block}
{block name=content}

<h2 class="text-center">Все Мероприятия</h2>


<table class="table table-striped">
	<tr>
		<th>Название</th>
		<th>Тип</th>
		<th>Подтверждение</th>
	</tr>
{foreach from=$events item=event}
	<tr>
		<td><a href="/event/{$event->getId()}">{$event->getTitle()}</a></td>
		<td>{$event->getEvent_type()}</td>
		<td>{$event->getConfirm()}</td>
	</tr>
{/foreach}
</table>

{/block}
