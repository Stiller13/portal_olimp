{if $user}
Пользователь : {$user->getName()} {$user->getFamily()}
{/if}
<h1>Группа : {$messagegroup->getTitle()}</h1><br>
Описание : [{$messagegroup->getDescription()}]<br>
Участники : 
{foreach from = $messagegroup->getPartners() item = p}
    [{$p->getName()} {$p->getFamily()} {if $p->getRoleInGroup() == 11}(админ){else}(участник){/if}]
{/foreach}
<br>
<a href="/message/system/groups">Назад</a>
<hr>
{foreach from=$messagegroup->getMessages() item=f}
    {if $f->getAuthor()}
    Автор : {$f->getAuthor()->getName()} {$f->getAuthor()->getFamily()}<br>
    {/if}
    Текст : {$f->getText()}<br>
    Время : {$f->getDate()}<br>
    Начало : {$f->getStartShow()}<br>
    Конец : {$f->getStopShow()}<br>
    {if $f->getFiles()}
        Файлы :<br>
        {foreach from=$f->getFiles() item=one_file}
            {$one_file->getName()} <a href="/message/get/file/{$one_file->getCode()}">[Получить]</a><br>
        {/foreach}
    {/if}
    <hr>
{/foreach}

{if $user}
Добавить сообщение<br>
<form method="POST" action="/message/system/group/{$messagegroup->getId()}/send_message" enctype="multipart/form-data">
    Текст : <input type='text' name='text'><br>
    <input type='hidden' name='author_id' value={$user->getId()}>
    <input type='hidden' name='group_id' value={$messagegroup->getId()}>
    Файл  : <input type='file' name='uploadfiles[]' multiple='true'><br>
    Дата начала: <input type="datetime" name="date_start"><br>
    Дата конца: <input type="datetime" name="date_stop"><br>
    <input type='submit' value='Отправить'>
</form>
{/if}