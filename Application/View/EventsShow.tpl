{extends file="Main.tpl"}
{block name=title}Главная{/block}
{block name=menu_events}active{/block}
{block name=content}

<h2 class="text-center">Все Мероприятия</h2>

<div class="row margtp-25">
	<div class="col-md-6 col-md-offset-3">
		{if $can_create}
		<p class="text-center"><a href="/event/create"><button class="btn btn-success">Создать мероприятие</button></a></p>
		{/if}
		<table class="table table-striped margtp-25">
			<tr>
				<th>Название</th>
				<th>Тип</th>
				<th>Подтверждающий документ</th>
			</tr>
		{foreach from=$events item=event}
			<tr>
				<td><a href="/event/{$event->getId()}">{$event->getTitle()}</a></td>
				<td>{if $event->getEvent_type() eq "open"}открытое{else}закрытое{/if}</td>
				<td>{if $event->getConfirm() eq "1"}требуется{else}не требуется{/if}</td>
			</tr>
		{/foreach}
		</table>
	</div>
</div>

{/block}
