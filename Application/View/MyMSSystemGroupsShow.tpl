{extends file="MyMessage.tpl"}
{block name=title}Личная переписка{/block}
{block name=message_content}

<div class="col-md-4 col-md-3-offset">
	{if $list_groups}
	<ul class="nav nav-pills nav-stacked">
	{foreach from=$list_groups item=one_group}
		<li>
			<a href="/cabinet/message/system/{$one_group->getId()}">
				{$one_group->getDescription()}
				{if $one_group->getVisit()}
				<span class="badge pull-right">{if $one_group->getVisit()->getCountMessage() > 0}{$one_group->getVisit()->getCountMessage()}{/if}</span>
				{/if}
			</a>
		</li>
	{/foreach}
	</ul>
	{else}
	<p>Поку тут пусто</p>
	{/if}
</div>

{/block}
