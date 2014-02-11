{if $user}
Пользователь : {$user->getName()} {$user->getFamily()}
{/if}

<a href="/message/personal/groups">Личные</a><br>
<a href="/message/system/groups">Системные</a><br>
<a href="/message/comment/groups">Комментарии</a><br>
<a href="/message/expertise/groups">Експертизы</a><br>