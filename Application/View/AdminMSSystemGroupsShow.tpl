{extends file="AdminMessage.tpl"}
{block name=system_mg}active{/block}
{block name=admin_message_content}

<div class="col-md-4">
	<ul class="nav nav-pills nav-stacked">
	{foreach from=$list_group item=one_group}
		<li>
			<a href="/admin_cabinet/message/system/{$one_group->getId()}">
				{$one_group->getDescription()}
				<span class="badge pull-right"></span>
			</a>
		</li>
	{/foreach}
	</ul>
</div>

{/block}