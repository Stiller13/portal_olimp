{extends file="AdminMessage.tpl"}
{block name=notice_mg}active{/block}
{block name=admin_message_content}

<div class="col-md-4">
	<ul class="nav nav-pills nav-stacked">
	{foreach from=$list_group item=one_group}
		<li>
			<a href="/admin_cabinet/message/notice/{$one_group->getId()}">
				{$one_group->getDescription()}
				<span class="badge pull-right"></span>
			</a>
		</li>
	{/foreach}
	</ul>
</div>

{/block}