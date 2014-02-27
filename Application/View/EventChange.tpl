{extends file="EventPanel.tpl"}
{block name=title}Настройки мероприятия{/block}
{block name=epanel_change}active{/block}
{block name=panel_title}{$event->getTitle()}{/block}
{block name=epanel_content}

<form class="form" action="/event/save" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label class="control-label" for="inputTitle">Название</label>
		<input type="text" name="title" class="form-control" id="inputTitle" {if $event}value={$event->getTitle()}{/if}>
	</div>
	<div class="form-group">
		<label class="control-label" for="inputdpub">Описание для всех</label>
		<textarea class="form-control edit" name="description_public" rows="10" cols="40" id="inputdpub"> {if $event}{$event->getDescription_public()}{/if}</textarea>
	</div>
	<div class="form-group">
		<label class="control-label" for="inputdpriv">Описание для участников</label>
		<textarea class="form-control edit" name="description_private" rows="10" cols="40" id="inputdpriv">{if $event}{$event->getDescription_private()}{/if}
		</textarea>
	</div>

	{if $event}
	{if $event->getFiles()}
	Прикрепленные файлы<br>
		{foreach from=$event->getFiles() item=one_file}
			<a href="/file/{$one_file->getCode()}">{$one_file->getName()}</a><br>
		{/foreach}
	{/if}
	{/if}
	<div class="form-group">
			<label for="exampleInputFile">Добавить файлы</label>
			<input type="file" id="exampleInputFile" name="uploadfiles[]" multiple="true">
		</div>
	Тип<br>
	<div class="form-group">
		<label class="control-label">
			<input type="radio" name="event_type" value="open" {if $event}{if $event->getEvent_type() eq "open"}checked{/if}{/if}>
			Открытое
		</label>
	</div>
	<div class="form-group">
		<label class="control-label">
			<input type="radio" name="event_type" value="close" {if $event}{if $event->getEvent_type() eq "close"}checked{/if}{/if}>
			Закрытое
		</label>
	</div>

	Требуется ли подтверждающий документ<br>
	<div class="form-group">
		<label class="control-label">
			<input type="radio" name="confirm" value="1" {if $event}{if $event->getConfirm() eq "1"}checked{/if}{/if}>
			Да
		</label>
	</div>
	<div class="form-group">
		<label class="control-label">
			<input type="radio" name="confirm" value="0" {if $event}{if $event->getConfirm() eq "0"}checked{/if}{/if}>
			Нет
		</label>
	</div>

	<div class="form-group">
		<label class="control-label" for="inputсd">Описание подтверждющего документа</label>
		<textarea class="form-control edit" name="confirm_description" rows="10" cols="40" id="inputсd"> {if $event}{$event->getConfirm_description()}{/if}</textarea>
	</div>
	{if $event}<input type="hidden" name="e_id" value={$event->getId()}>{/if}
	<div class="form-group">
		<button type="submit" class="btn btn-success">{if $event}Сохранить{else}Создать{/if}</button>
	</div>
</form>

{/block}