{extends file="Main.tpl"}
{block name=title}Все Мероприятия{/block}
{block name=menu_events}active{/block}
{block name=content}

<h2 class="text-center">Все Мероприятия</h2>

<div class="row margtp-25">
	<div class="col-md-8 col-md-offset-2">
		{if $can_create}
		<p class="text-center"><a href="/event/create"><button class="btn btn-success">Создать мероприятие</button></a></p>
		{/if}
		<p class="text-center">
			<a href="/event/all">Все</a>
			<a href="/event/my">Мои</a>
		</p>
		<table class="table table-striped margtp-25">
			<tr>
				<th><p class="text-center">Название</p></th>
				<th><p class="text-center">Тип</p></th>
				<th><p class="text-center">Подтверждающий документ</p></th>
			</tr>
		{foreach from=$events item=event}
			<tr>
				<td><p class="text-center"><a href="/event/{$event->getId()}">{$event->getTitle()}</a></p></td>
				<td><p class="text-center">{if $event->getEvent_type() eq "public"}открытое{else}закрытое{/if}</p></td>
				<td><p class="text-center">{if $event->getConfirm() eq "1"}требуется{else}не требуется{/if}</p></td>
			</tr>
		{/foreach}
		</table>
	</div>
</div>

{/block}
