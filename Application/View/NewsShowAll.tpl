{extends file="Main.tpl"}
{block name=title}Новости{/block}
{block name=menu_news}active{/block}
{block name=content}

<div class="row margtp-25">
	<div class="col-md-8 col-md-offset-2">
		{if $can_create}
		<p class="text-center"><a href="/event/create"><button class="btn btn-success">Создать мероприятие</button></a></p>
		{/if}
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
