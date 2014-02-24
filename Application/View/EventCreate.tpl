{extends file="Main.tpl"}
{block name=title}Создание мероприятия{/block}
{block name=content}

<h1 class="text-center">Создание мероприятия</h1>

<form class="form" action="/event/save" method="post">
	<div class="form-group">
		<label class="control-label" for="inputTitle">Название</label>
		<input type="text" name="title" class="form-control" id="inputTitle" {if $event}value={$event->getTitle()}{/if}>
	</div>
	<div class="form-group">
		<label class="control-label" for="inputdpub">Описание для всех</label>
		<textarea class="form-control" name="description_public" rows="10" cols="40" id="inputdpub"> {if $event}{$event->getDescription_public()}{/if}</textarea>
	</div>
	<div class="form-group">
		<label class="control-label" for="inputdpriv">Описание для участников</label>
		<textarea class="form-control" name="description_private" rows="10" cols="40" id="inputdpriv">{if $event}{$event->getDescription_private()}{/if}
		</textarea>
	</div>
	Тип<br>
	<div class="form-group">
		<select name="event_type">
			<option value="open" {if $event}{if $event->getEvent_type() eq "open"}selected{/if}{/if}>Открытое</option>
			<option value="close" {if $event}{if $event->getEvent_type() eq "close"}selected{/if}{/if}>Закрытое</option>
		</select>
	</div>
	Требуется ли подтверждающий документ<br>
	<div class="form-group">
		<select name="confirm">
			<option value="1" {if $event}{if $event->getConfirm() eq "1"}selected{/if}{/if}>Да</option>
			<option value="0" {if $event}{if $event->getConfirm() eq "0"}selected{/if}{/if}>Нет</option>
		</select> 
	</div>
	<div class="form-group">
		<label class="control-label" for="inputсd">Описание подтверждющего документа</label>
		<textarea class="form-control" name="confirm_description" rows="10" cols="40" id="inputсd"> {if $event}{$event->getConfirm_description()}{/if}</textarea>
	</div>
	{if $event}<input type="hidden" name="e_id" value={$event->getId()}>{/if}
	<div class="form-group">
		<button type="submit" class="btn btn-success">{if $event}Сохранить{else}Создать{/if}</button>
	</div>
</form>

{/block}