{if $user}
Пользователь : {$user->getName()} {$user->getFamily()}
{/if}
<h1>{$messagegroup->getTitle()}</h1><br>
Описание эспертизы : [{$messagegroup->getDescription()}]<br>
Статус : экспертиза не начата<br>
Текущая версия документа : {if $messagegroup->getDocument()}{$messagegroup->getDocument()->getName()}{else}нет документа{/if}<br>
Участники : 
{foreach from = $messagegroup->getPartners() item = p}
    [{$p->getName()} {$p->getFamily()} {$p->getRoleInGroup()}]
{/foreach}
<br>
<a href="/message/expertise/groups">Назад</a>
<hr>
Для запуска экспертизы отправьте документ
<form method="POST" action="/message/expertise/group/{$messagegroup->getId()}/start" enctype="multipart/form-data">
    <input type='text' name='text' value="Отправлен документ"><br>
    <input type='hidden' name='author_id' value={$user->getId()}>
    <input type='hidden' name='group_id' value={$messagegroup->getId()}>
    <input type="hidden" name="load_file" value="1">
    <input type='file' name='uploadfiles[]' multiple='true'><br>
    <input type='submit' value='Отправить'>
</form>
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
