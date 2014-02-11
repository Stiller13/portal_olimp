{if $user}
Пользователь : {$user->getName()} {$user->getFamily()}
{/if}
<h1>{$messagegroup->getTitle()}</h1><br>
Описание эспертизы : [{$messagegroup->getDescription()}]<br>
Статус : на экспертизе<br>
Текущая версия документа : {if $messagegroup->getDocument()}{$messagegroup->getDocument()->getName()}<a href="/message/get/file/{$messagegroup->getDocument()->getCode()}">[Получить]</a>{else}нет документа{/if}<br>
Участники : 
{foreach from = $messagegroup->getPartners() item = p}
    [{$p->getName()} {$p->getFamily()} {$p->getRoleInGroup()}]
{/foreach}
<br>
<a href="/message/expertise/groups">Назад</a>
<a href="/message/expertise/group/{$messagegroup->getId()}/ok">Одобрен</a>
<hr>
Возвратить документ на доработку
<form method="POST" action="/message/expertise/group/{$messagegroup->getId()}/return" enctype="multipart/form-data">
    <input type='text' name='text' value="Необходимо переработать"><br>
    <input type='hidden' name='author_id' value={$user->getId()}>
    <input type='hidden' name='group_id' value={$messagegroup->getId()}>
    <input type="hidden" name="load_file" value="1">
    <input type='file' name='uploadfiles[]' multiple='true'><br>
    <input type='submit' value='Возврат'>
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