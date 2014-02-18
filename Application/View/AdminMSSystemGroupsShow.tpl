{extends file="AdminCabinet.tpl"}
{block name=admin_cab_menu_message}active{/block}
{block name=admin_cab_content}

<div class="row margtp-25">
	<div class="col-md-4 col-md-offset-3">
		<ul class="nav nav-pills nav-stacked">
		{foreach from=$list_group item=one_group}
			<li>
				<a href="/cabinet/message/personal/{$one_group->getId()}">
					{$one_group->getDescription()}
					<span class="badge pull-right"></span>
				</a>
			</li>
		{/foreach}
		</ul>
	</div>
</div>
{/block}

