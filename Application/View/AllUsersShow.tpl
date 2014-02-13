{extends file="MainPage.tpl"}
{block name=title}Все соседи{/block}
{block name=content}

{$first = ''}
{foreach from=$user_list item=one_user}
{if $first eq ''}
{$first = $one_user->getName()}
{/if}
{$one_user->getName()} {$one_user->getFamily()}<br>
{/foreach}
{$first}
{/block}
