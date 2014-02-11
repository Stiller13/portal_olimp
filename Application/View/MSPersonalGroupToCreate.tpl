{if $user}
Пользователь : {$user->getName()} {$user->getFamily()}
{/if}
<h1>Создание группы личной переписки</h1><br>
<a href="/message/personal/groups">Назад</a>
<hr>
<form method="POST" action="/message/personal/group/create">
    Название : <input type="text" name="title"><br><br>
    Описание : <input type="text" name="description"><br>
    <input type="submit" value="Создать">
</form>