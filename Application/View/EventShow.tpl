{extends file="EventPanel.tpl"}
{block name=title}Мероприятие{/block}
{block name=epanel_main}active{/block}
{block name=panel_title}{$event->getTitle()}{/block}
{block name=epanel_content}


{if $rule eq "e_admin"}
	<div class="well">
		{$event->getDescription_public()}
	</div>
	<div class="well">
		{$event->getDescription_private()}
	</div>
{elseif $rule eq "e_partner"}
	{$event->getDescription_private()}
	{if $event->getFiles()}
		{foreach from=$event->getFiles() item=one_file name=foo1}
			{if $smarty.foreach.foo1.first}Прикрепленные файлы<br>{/if}
			<a href="/file/{$one_file->getCode()}">{$one_file->getName()}</a><br>
		{/foreach}
	{/if}
{else}
	{$event->getDescription_public()}
{/if}


{if $event->getEvent_type() eq "0"}
<div class="row">
	<div class="alert alert-warning col-md-4 col-md-offset-4">
		<p class="text-center">Данное мероприятие закрытое. Необходимо подтверждение на участие.</p>
	</div>
</div>
{/if}
{if $event->getConfirm() eq "1"}
<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-default">
			<div class="panel-heading">Условие подачи заявки на участие</div>
			<div class="panel-body">
				{$event->getConfirm_description()}
			</div>
		</div>
	</div>
</div>
{/if}

{if $rule}
{if $rule neq "e_user"}
Участники :<br>
	{foreach from=$event->getPartners() item=partner}
		{if $partner->getRule() eq "e_partner"}
			{$partner->getName()}
		{/if}
	{/foreach}
<hr>

{if $event->getComments()}
<ul class="media-list">
	{foreach from=$event->getComments()->getMessages() item=message}
	<li class="media">
		<a class="pull-left" href="#">
			<img class="media-object" src="/Design/images/noavatar92.jpg" alt="" style="width: 64px; height: 64px;">
		</a>
		<div class="media-body">
			<h5 class="media-heading">
				{$message->getAuthor()->getName()} 
				{$message->getAuthor()->GetFamily()}
				<small>{$message->getDate()}</small>
			</h5>
			{$message->getText()}

			<div class="spoiler">
				<label class="btn btn-warning btn-xs" for="{$message->getId()}">Ответить</label>
				<input class="spoiler-input" type="checkbox" id="{$message->getId()}" />
				<div class="spoiler-body">
					<form role="form" action="/event/{$event->getId()}/new_comment" method="post">
						<div class="form-group">
							<label for="exampleInputText">Текст</label>
							<textarea class="form-control" id="exampleInputText" name="text" rows="3" cols="10"></textarea>
						</div>
						<input type="hidden" name="user_id" value={$user->getId()}>
						<input type="hidden" name="group_id" value={$event->getComments()->getId()}>
						<div class="form-group">
							<button type="submit" class="btn btn-primary btn-xs" name="id_remessage" value="{$message->getId()}">Ответить</button>
						</div>
					</form>
				</div>
			</div>
			{if $message->getMessages()}
			{foreach from=$message->getMessages() item=message2}
			<div class="media">
				<a class="pull-left" href="#">
					<img class="media-object" src="/Design/images/noavatar92.jpg" alt="" style="width: 64px; height: 64px;">
				</a>
				<div class="media-body">
					<h5 class="media-heading">
						{$message2->getAuthor()->getName()} 
						{$message2->getAuthor()->GetFamily()}
						<small>{$message2->getDate()}</small>
					</h5>
					{$message2->getText()}

					<div class="spoiler">
						<label class="btn btn-warning btn-xs" for="{$message2->getId()}">Ответить</label>
						<input class="spoiler-input" type="checkbox" id="{$message2->getId()}" />
						<div class="spoiler-body">
							<form role="form" action="/event/{$event->getId()}/new_comment" method="post">
								<div class="form-group">
									<label for="exampleInputText">Текст</label>
									<textarea class="form-control" id="exampleInputText" name="text" rows="3" cols="10"></textarea>
								</div>
								<input type="hidden" name="user_id" value={$user->getId()}>
								<input type="hidden" name="group_id" value={$event->getComments()->getId()}>
								<div class="form-group">
									<button type="submit" class="btn btn-primary btn-xs" name="id_remessage" value="{$message2->getId()}">Ответить</button>
								</div>
							</form>
						</div>
					</div>
					{if $message2->getMessages()}
					{foreach from=$message2->getMessages() item=message3}
					<div class="media">
						<a class="pull-left" href="#">
							<img class="media-object" src="/Design/images/noavatar92.jpg" alt="" style="width: 64px; height: 64px;">
						</a>
						<div class="media-body">
							<h5 class="media-heading">
								{$message3->getAuthor()->getName()} 
								{$message3->getAuthor()->GetFamily()}
								<small>{$message3->getDate()}</small>
							</h5>
							{$message3->getText()}
						</div>
					</div>
					{/foreach}
					{/if}
				</div>
			</div>
			{/foreach}
			{/if}
		</div>
	</li>
	{/foreach}
</ul>
<form role="form" action="/event/{$event->getId()}/new_comment" method="post">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
				<div class="form-group">
					<label for="exampleInputText">Комментировать</label>
					<textarea class="form-control" id="exampleInputText" name="text" rows="3"></textarea>
				</div>
				<input type="hidden" name="user_id" value={$user->getId()}>
				<input type="hidden" name="group_id" value={$event->getComments()->getId()}>
				<button type="submit" class="btn btn-success" name="id_remessage" value="0">Комментировать</button>
		</div>
	</div>
</form>
{/if}
{/if}
{elseif $user}
<div class="row">
	<div class="col-md-3 col-md-offset-5">
		<form class="from" action="/event/{$event->getId()}/change_partners" method="post" enctype="multipart/form-data">
			<input type="hidden" name="users[]" value="{$user->getId()}">
			<input type="hidden" name="redirect" value="/event/{$event->getId()}">
			{if $event->getConfirm() eq "1"}
			<div class="form-group">
				<input type="file" id="exampleInputFile" name="uploadfiles[]" multiple="true">
				<p class="help-block">Выберите файл для отправки</p>
			</div>
			{/if}
			<div class="form-group">
				<button type="submit" class="btn btn-success" name="do" value="add">Хочу учавствовать</button>
			</div>
		</form>
	</div>
</div>
{/if}

{/block}