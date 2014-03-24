{extends file="Main.tpl"}
{block name=title}Новости{/block}
{block name=menu_news}active{/block}
{block name=content}

<div class="row margtp-25">
	<div class="col-md-8 col-md-offset-2">
		{if $can_create}
		<p class="text-center"><a href="/news/create"><button class="btn btn-success">Создать новость</button></a></p>
		{/if}

		<ul class="pager">
			{if $page eq 1}
				<li class="disabled"><a>Предыдущая</a></li>
			{else}
				<li><a href="/news/page/{$page-1}">Предыдущая</a></li>
			{/if}
			<li><a href="/news/page/{$page+1}">Следующая</a></li>
		</ul>

		{foreach from=$news item=one_news}
		<div class="panel panel-default">
			<div class="panel-body">
			{$my_date = date_parse($one_news->getDate())}
			{$my_date["year"]}-{$my_date["month"]}-{$my_date["day"]}

				<h4><p class="text-center">{$one_news->getTitle()}</p></h4>
				<p class="pull-left">Оценка : {$one_news->getRatio()}</p>
				<p class="pull-right"><a href="/news/{$one_news->getId()}">Подробнее</a></p>
			</div>
<!-- 			<div class="panel-footer">
				{$one_news->getDate()}
				<p class="pull-right"><a href="/news/{$one_news->getId()}">Подробнее</a></p>
			</div> -->
		</div>
		{/foreach}

	</div>
</div>

{/block}
