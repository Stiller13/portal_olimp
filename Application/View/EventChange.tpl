<form action="/EventChangeResult" method="post">
	<input type="text" name="title" value={$event->getTitle()}> Название <br>
	<input type="text" name="description_public" value={$event->getDescription_public()}> Описание для всех <br>
	<input type="text" name="description_private" value={$event->getDescription_private()}> Описание для записавшихся<br>
	<select name="event_type">
		{if {$event->getEvent_type()} eq "open"}
			<option value="open" selected>Открытое</option>
			<option value="private">Закрытое</option>
		{else}
			<option value="open">Открытое</option>
			<option value="private" selected>Закрытое</option>
		{/if}
	</select>Тип<br>
	<select name="confirm">
		{if {$event->getConfirm()} eq "1"}
			<option value="1" selected>Есть</option>
			<option value="0">Нет</option>
		{else}
			<option value="1">Есть</option>
			<option value="0" selected>Нет</option>
		{/if}
	</select> Требуется ли подтверждающий документ<br>
	<input type="text" name="confirm_description" value={$event->getConfirm_description()}> Описание этого документа
	<input type="hidden" name="e_id" value={$event->getId()}>
	<button type="submit">Изменить</button> 
</form>

