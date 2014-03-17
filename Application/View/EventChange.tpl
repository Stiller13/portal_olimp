{extends file="EventPanel.tpl"}
{block name=title}Настройки мероприятия{/block}
{block name=epanel_change}active{/block}
{block name=epanel_content}

<form class="form" action="/event/{$event->getId()}/save" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label class="control-label" for="status">Статус: </label>
		{$event->getStatus()}

		<div class="form-group">
			{if $event->getStatus() eq "create"}
				<button class="btn btn-success" type="submit" name="status" value="open">Опубликовать</button>
			{elseif $event->getStatus() eq "open"}
				<button class="btn btn-danger" type="submit" name="status" value="closed">Закрыть</button>
			{else}
				<button class="btn btn-success" type="submit" name="status" value="open">Опубликовать</button>
			{/if}
		</div>
	</div>
	<div class="form-group">
		<label class="control-label" for="inputTitle">Название</label>
		<input type="text" name="title" class="form-control" id="inputTitle" value="{$event->getTitle()}">
	</div>
	<div class="form-group">
		<label class="control-label" for="inputdpub">Описание для всех</label>
		<textarea class="form-control edit" name="description_public" rows="10" cols="40" id="inputdpub"> {$event->getDescription_public()}</textarea>
	</div>
	<div class="form-group">
		<label class="control-label" for="inputdpriv">Описание для участников</label>
		<textarea class="form-control edit" name="description_private" rows="10" cols="40" id="inputdpriv">{$event->getDescription_private()}
		</textarea>
	</div>

	{if $event->getFiles()}
	Прикрепленные файлы<br>
		{foreach from=$event->getFiles() item=one_file}
			<a href="/file/{$one_file->getCode()}">{$one_file->getName()}</a><br>
		{/foreach}
	{/if}
	<div class="form-group">
			<label for="exampleInputFile">Добавить файлы</label>
			<input type="file" id="exampleInputFile" name="uploadfiles[]" multiple="true">
		</div>
	Тип<br>
	<div class="form-group">
		<label class="control-label">
			<input type="radio" name="event_type" value="public" {if $event->getEvent_type() eq "public"}checked{/if}>
			Публичное
		</label>
	</div>
	<div class="form-group">
		<label class="control-label">
			<input type="radio" name="event_type" value="private" {if $event->getEvent_type() eq "private"}checked{/if}>
			Закрытое
		</label>
		(с модерацией пользователей)
	</div>

	Требуется ли подтверждающий документ<br>
	<div class="form-group">
		<label class="control-label">
			<input type="radio" name="confirm" value="1" {if $event->getConfirm() eq "1"}checked{/if}>
			Да
		</label>
	</div>
	<div class="form-group">
		<label class="control-label">
			<input type="radio" name="confirm" value="0" {if $event->getConfirm() eq "0"}checked{/if}>
			Нет
		</label>
	</div>

	<div class="form-group">
		<label class="control-label" for="inputсd">Описание подтверждющего документа</label>
		<textarea class="form-control edit" name="confirm_description" rows="10" cols="40" id="inputсd"> {$event->getConfirm_description()}</textarea>
	</div>
	<input type="hidden" name="e_id" value="{$event->getId()}">
	<div class="form-group">
		<button type="submit" class="btn btn-success">{if $event}Сохранить{else}Создать{/if}</button>
	</div>
</form>

<script src="/Design/TinyMCE/tiny_mce.js"></script>
<script src="/Design/TinyMCE/tiny_mce_my.js"></script>

{/block}