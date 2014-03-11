{extends file="AdminMessage.tpl"}
{block name=title}{$group->getDescription()}{/block}
{block name=system_mg}active{/block}
{block name=admin_message_content}

<div class="col-md-5">
	{foreach from=$group->getMessages() item=one_message}
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
	<form role="form" action="/admin_cabinet/message/system/new_message" method="post" enctype="multipart/form-data">
		<div class="form-group">
			<label for="exampleInputText">Текст сообщения</label>
			<input type="textarea" class="form-control" id="exampleInputText" name="text">
		</div>
		<div class="form-group">
			<label for="exampleInputFile">Файл</label>
			<input type="file" id="exampleInputFile" name="uploadfiles[]" multiple="true">
			<p class="help-block">Выберите файл для отправки</p>
		</div>
		<input type="hidden" name="user_id" value={$user->getId()}>
		<input type="hidden" name="group_id" value={$group->getId()}>
		<input type="hidden" name="id_remessage" value="0">
		<input type="hidden" name="status" value="0">
		<input type="submit" class="btn btn-success" value="Отправить">
	</form>
</div>
<!-- <div class="col-md-3">
	<p>Пригласите участников из списка</p>
	<form role="form" action="/cabinet/message/personal/add_users" method="post">
		<div class="form-group">
			<select name="users[]" multiple class="form-control">
			{foreach from=$user_list item=one_user}
				<option value={$one_user->getId()}>{$one_user->getName()} {$one_user->getFamily()}</option>
			{/foreach}
			</select>
		</div>
		<input type="hidden" name="group_id" value={$group->getId()}>
		<input type="hidden" name="secret_param" value='top_s_e_cret'>
		<input type="submit" class="btn btn-primary" value="Пригласить">
	</form>

	<form role="form" action="/cabinet/message/personal/del_me" method="post">
		<div class="form-group">
		</div>
		<input type="hidden" name="group_id" value={$group->getId()}>
		<input type="hidden" name="secret_param" value='s_e_cret_122'>
		<input type="hidden" name="user_id" value={$user->getId()}>
		<input type="submit" class="btn btn-danger" value="Покинуть группу">
	</form>
</div> -->

{/block}
