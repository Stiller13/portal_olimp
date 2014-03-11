{extends file="EventPanel.tpl"}
{block name=title}Мероприятие{/block}
{block name=epanel_message}active{/block}

{block name=epanel_content}

<form class="form" action="/event/{$event->getId()}/new_notice" method="post">
	<div class="row">
		<div class="col-md-4 col-md-offset-1">
			<div class="form-group">
				<label for="exampleInputText">Текст сообщения</label>
				<textarea class="form-control" id="exampleInputText" name="text" rows="3"></textarea>
			</div>
			<div class="form-group">
				<label for="exampleInputFile">Файл</label>
				<input type="file" id="exampleInputFile" name="uploadfiles[]" multiple="true">
				<p class="help-block">Выберите файл для отправки</p>
			</div>
			<input type="hidden" name="user_id" value="{$user->getId()}">
			<input type="hidden" name="event_title" value="{$event->getTitle()}">
			<input type="hidden" name="event_id" value="{$event->getId()}">
			{$group = $event->getNoticeGroup($mode)}
			<input type="hidden" name="group_id" value="{$group->getId()}">

			<div class="form-group">
				<button type="submit" class="btn btn-success" name="mode" value="{$mode}">Отправить</button>
			</div>
		</div>
		<div class="col-md-5 col-md-offset-1">
			<ul class="nav nav-tabs">
				<li {if $mode eq 'all'}class="active"{/if}><a href="/event/{$event->getId()}/message/all">Всем</a></li>
				<li {if $mode eq 'partners'}class="active"{/if}><a href="/event/{$event->getId()}/message/partners">Участникам</a></li>
				<li {if $mode eq 'users'}class="active"{/if}><a href="/event/{$event->getId()}/message/users">Заявителям</a></li>
			</ul>
			{foreach from=$group->getMessages() item=one_message}
			<div class="panel panel-default margtp-25">
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
		</div>
	</div>
</form>

{/block}