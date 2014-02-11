{if $user}
Пользователь : {$user->getName()} {$user->getFamily()}
{/if}
<h1>Создание экспертизы</h1><br>
<a href="/message/expertise/groups">Назад</a>
<hr>
<form method="POST" action="/message/expertise/group/create">
    Название : <input type='text' name='title'><br><br>
    Описание : <input type='text' name='description'><br>
    <input type='submit' value='Создать'>
</form>