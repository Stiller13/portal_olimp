{if $user}
Пользователь : {$user->getName()} {$user->getFamily()}
{/if}
<h1>Создание группы системных сообщений</h1><br>
<a href="/message/system/groups">Назад</a>
<hr>
<form method="POST" action="/message/system/group/create">
<!-- 	Название : <input type="text" name="title" value="Системная группа"><br><br>
	Описание : <input type="text" name="description" value="Системные сообщения"><br> -->
	Тип группы : 
	<select name="mode">
		{if $new_open_group}
		<option value="open">Открытая</option>
		{/if}
		<option value="close">Закрытая</option>
	</select><br>
	Выберите пользователей для закрытой группы :<br>
	{foreach from=$user_list item=one_user}
	<input name="users[]" type="checkbox" value={$one_user.user_id}>{$one_user.user_name} {$one_user.user_surname}<br>
	{/foreach}
	<input type="submit" value="Создать">
</form>