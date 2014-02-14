{extends file="MainPage.tpl"}
{block name=title}Все соседи{/block}
{block name=content}

{$first = ''}
{foreach from=$user_list item=one_user}
{$name = $one_user->getName()}
{if $first neq $name[0]}
	{$first = $name[0]}
	{$first}<br>
{/if}
{$one_user->getName()} {$one_user->getFamily()}<br>
{/foreach}
{/block}
