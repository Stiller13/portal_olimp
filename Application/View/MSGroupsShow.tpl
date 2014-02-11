{if $user}
Пользователь : {$user->getName()} {$user->getFamily()}
{/if}
<h1>{$title}</h1>
<a href="/message">Назад</a>
<hr>
{$i = 1}
{foreach from=$listgroup item=group}
	{$i++}. <a href="/message/{$mg_type}/group/{$group->getId()}">{$group->getTitle()}</a> {if $group->getVisit()}{if $group->getVisit()->getCountMessage() > 0}[{$group->getVisit()->getCountMessage()}]{/if}{/if}<br>
{/foreach}
<hr>
<a href="/message/{$mg_type}/group/create">Создать</a>