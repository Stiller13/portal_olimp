{extends file="Main.tpl"}
{block name=title}Все соседи{/block}
{block name=content}

{$first = ''}
{foreach from=$user_list item=one_user}
{$name = $one_user->getName()}
{if $first[0] neq $name[0]}
	{$first = $name}
	{$first[0]}<br>
{/if}
<a href="/profile/{$one_user->getId()}">{$one_user->getName()} {$one_user->getFamily()}</a><br>
{/foreach}
{/block}
