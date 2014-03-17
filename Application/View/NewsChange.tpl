{extends file="Main.tpl"}
{block name=title}
	{if $news}
		Редактирование новости
	{else}
		Создание новости
	{/if}
{/block}

{block name=menu_news}active{/block}
{block name=content}

<h1 class="text-center">
	{if $news}
		Редактирование новости
	{else}
		Создание новости
	{/if}
</h1>

<form class="form" action="/news/{if $news}{$news->getId()}/save{else}create{/if}" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label class="control-label" for="inputTitle">Заголовок</label>
		<input type="text" name="title" class="form-control" id="inputTitle" {if $news}value="{$news->getTitle()}"{/if}>
	</div>
	<div class="form-group">
		<label class="control-label" for="inputdpub">Текст</label>
		<textarea class="form-control edit" name="text" rows="20" cols="40" id="inputdpub">{if $news}{$news->getText()}{/if}</textarea>
	</div>

<!-- 	<div class="form-group">
		<label for="exampleInputFile">Добавить файлы</label>
		<input type="file" id="exampleInputFile" name="uploadfiles[]" multiple="true">
</div> -->

	<div class="form-group">
		<button type="submit" class="btn btn-success">{if $news}Сохранить{else}Создать{/if}</button>
	</div>
</form>

<script src="/Design/TinyMCE/tiny_mce.js"></script>
<script src="/Design/TinyMCE/tiny_mce_my.js"></script>


{/block}