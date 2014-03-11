{extends file="MyCabinet.tpl"}
{block name=title}Мои файлы{/block}
{block name=cab_menu_file}active{/block}
{block name=cab_content}

<div class="row margtp-25">
	<div class="col-md-4 col-md-offset-4">
		<table class="table table-striped">
			<tr>
				<th><p class="text-center">Название</p></th>
				<th><p class="text-center">Дата загрузки</p></th>
			</tr>
		{foreach from=$list_file item=one_file}
			<tr>
				<td><p class="text-center"><a href="/file/{$one_file->getCode()}">{$one_file->getName()}</a></p></td>
				<td><p class="text-center">{$one_file->getDate()}</p></td>
			</tr>
		{/foreach}
		</table>
		<form role="form" action="/cabinet/file/add" method="post" enctype="multipart/form-data">
			<div class="form-group">
				<label for="exampleInputFile">Вы можете загрузить файл</label>
				<input type="file" id="exampleInputFile" name="uploadfiles[]">
				<p class="help-block">Выберите файл для загрузки</p>
			</div>
			<input type="hidden" name="user_id" value={$user->getId()}>
			<div class="form-group">
				<button type="submit" class="btn btn-success">Отправить</button>
			</div>
		</form>
	</div>
</div>

{/block}
