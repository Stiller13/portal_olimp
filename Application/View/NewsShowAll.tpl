{extends file="Main.tpl"}
{block name=title}Новости{/block}
{block name=menu_news}active{/block}
{block name=content}

<div class="row margtp-25">
	<div class="col-md-8 col-md-offset-2">
		{if $can_create}
		<p class="text-center"><a href="/news/create"><button class="btn btn-success">Создать новость</button></a></p>
		{/if}
		{foreach from=$news item=one_news}
		<div class="panel panel-default">
			<div class="panel-body">
				{$one_news->getTitle()}
			</div>
			<div class="panel-footer">
				{$one_news->getDate()}
				<p class="pull-right"><a href="/news/{$one_news->getId()}">Подробнее</a></p>
			</div>
		</div>
		{/foreach}
	</div>
</div>

{/block}
