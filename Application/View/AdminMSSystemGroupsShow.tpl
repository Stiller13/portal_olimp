{extends file="AdminMessage.tpl"}
{block name=admin_message_content}

<div class="col-md-4">
	{if $to_init}
	<form role="form" action="/admin_cabinet/message/system/init" method="post">
		<input type="hidden" name="secret_param" value='top_secret!'>
		<input type="submit" class="btn btn-success" value="Провести инициализацию">
	</form>
	{/if}

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