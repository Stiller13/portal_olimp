{if $user}
Пользователь : {$user->getName()} {$user->getFamily()}
{/if}
<h1>{$messagegroup->getTitle()}</h1><br>
Описание эспертизы : [{$messagegroup->getDescription()}]<br>
Статус : {$messagegroup->getStatus()}<br>
Текущая версия документа : {$messagegroup->getDocument()->getName()}<br>
Участники : 
{foreach from = $messagegroup->getPartners() item = p}
    [{$p->getName()} {$p->getFamily()} {$p->getRoleInGroup()}]
{/foreach}
<br>
<a href="/message/expertise/groups">Назад</a>
<a href="/message/expertise/group/{$messagegroup->getId()}/ok">Одобрен</a>
<a href="/message/expertise/group/{$messagegroup->getId()}/return">Возврат</a><br>
<!-- <a href="/message/expertise/group/{$messagegroup->getId()}/settings">Настройки</a> -->
{if $messagegroup->getStatus() == 6}
<hr>
Отправить документ
<form method="POST" action="/message/expertise/group/{$messagegroup->getId()}/send_message" enctype="multipart/form-data">
    <input type='hidden' name='text' value="Отправлен документ">
    <input type='hidden' name='author_id' value={$user->getId()}>
    <input type='hidden' name='group_id' value={$messagegroup->getId()}>
    <input type='file' name='uploadfiles[]' multiple='true'><br>
    <input type='submit' value='Отправить'>
</form>
{/if}
<hr>
{foreach from=$messagegroup->getMessages() item=f}
    {if $f->getAuthor()}
        Автор : {$f->getAuthor()->getName()} {$f->getAuthor()->getFamily()}<br>
    {/if}
    Текст : {$f->getText()}<br>
    Время : {$f->getDate()}<br>
    {if $f->getFiles()}
        {$flag = true}
        {foreach from=$f->getFiles() item=one_file}
        {if $flag == true}Файлы :{/if}
            {$one_file->getName()} <a href="/message/get/file/{$one_file->getCode()}">[Получить]</a>
        {$flag = false}
        {/foreach}
    {/if}
<hr>
{/foreach}
<!--
{if $user}
Добавить сообщение<br>
<form method="POST" action="/message/expertise/group/{$messagegroup->getId()}/send_message" enctype="multipart/form-data">
    Текст : <input type='text' name='text'><br>
    <input type='hidden' name='author_id' value={$user->getId()}>
    <input type='hidden' name='group_id' value={$messagegroup->getId()}>
    Файл  : <input type='file' name='uploadfiles[]' multiple='true'><br>
    <input type='submit' value='Отправить'>
</form>
{/if}
-->