{extends file="MyMessage.tpl"}
{block name=title}Личная переписка{/block}
{block name=message_content}

<div class="col-md-4 col-md-3-offset">
	{if $list_mes}
	{foreach from=$list_mes->getMessages() item=one_message}
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">
				{$one_message->getAuthor()->getName()} 
				{$one_message->getAuthor()->getFamily()} 
				<p class="pull-right">{$one_message->getDate()}</p>
			</h3>
		</div>
		<div class="panel-body">
			{$one_message->getText()}
			{foreach from=$one_message->getFiles() item=one_file name=foo}
				{if $smarty.foreach.foo.first}<hr>{/if}
				<a href="/file/{$one_file->getCode()}">{$one_file->getName()}</a>
			{/foreach}
		</div>
	</div>
	{/foreach}
	{else}
	<p>Поку тут пусто</p>
	{/if}
</div>

{/block}
