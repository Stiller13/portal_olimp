{extends file="MyMessage.tpl"}
{block name=title}Оповещения{/block}
{block name=notice_mg}active{/block}
{block name=message_content}

<div class="col-md-5">
	<!-- <div style="height:450px;overflow-x:hidden;overflow-y:scroll"> -->
	{foreach from=$messages item=one_message}
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"> 
				<p class="text-center">{$one_message->getDate()}</p>
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
	<!-- </div> -->
</div>

{/block}
