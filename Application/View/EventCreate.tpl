<form action="/EventCreateResult" method="post">
	<input type="text" name="title"> Название <br>
	<input type="text" name="description_public"> Описание для всех <br>
	<input type="text" name="description_private"> Описание для записавшихся<br>
	<select name="event_type">
		<option value="open">Открытое</option>
		<option value="private">Закрытое</option>
	</select>Тип<br>
	<select name="confirm">
		<option value="1">Есть</option>
		<option value="0">Нет</option>
	</select> Требуется ли подтверждающий документ<br>
	<input type="text" name="confirm_description"> Описание этого документа
	<button type="submit">Создать</button>
</form>
