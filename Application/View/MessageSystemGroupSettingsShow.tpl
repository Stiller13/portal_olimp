{if $user}
Пользователь : {$user->getName()} {$user->getFamily()}
{/if}
<h1>Настройка группы</h1><br>
<a href="/message/personal/group/{$messagegroup->getId()}">Назад</a>
<hr>
<form method="POST" action="/message/personal/group/{$messagegroup->getId()}/settings">
	Название : <input type='text' name='title' value='{$messagegroup->getTitle()}'><br><br>
	Описание : <input type='text' name='description' value='{$messagegroup->getDescription()}'><br>
	<p>Участники</p>
	{foreach from = $messagegroup->getPartners() item = p}
		<input name="users[]" type="checkbox" value={$p->getId()} checked>{$p->getName()} {$p->getFamily()}<br>
	{/foreach}
	{foreach from=$users item=f}
		<input name="users[]" type="checkbox" value={$f.user_id}>{$f.user_name} {$f.user_surname}<br>
	{/foreach}
	<p>Админ</p>
	<select name="admin">
		{foreach from = $messagegroup->getPartners() item = p}
		<option value="{$p->getId()}" {if $p->getRoleInGroup() === 11}selected{/if}>{$p->getName()} {$p->getFamily()}</option>
		{/foreach}
		{foreach from=$users item=f}
		<option value={$f.user_id}>{$f.user_name} {$f.user_surname}</option>
		{/foreach}
	</select>
	<input type='submit' value='Сохранить'>
</form>