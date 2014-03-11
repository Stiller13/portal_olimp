{extends file="main.tpl"}
{block name=title}Новость{/block}
{block name=menu_news}active{/block}
{block name=content}

<h2><p class="text-center">{$news->getTitle()}</p></h2>
<hr>
{$news->getText()}

{if $rule eq "p_admin"}
<a href="/news/{$news->getId()}/change"><button class="btn btn-warning">Редактировать</button></a>
{/if}
<hr>

{if $user}
{if $news->getComments()}
<ul class="media-list">
	{foreach from=$news->getComments()->getMessages() item=message}
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
				<label class="btn btn-default btn-xs" for="{$message->getId()}">Ответить</label>
				<input class="spoiler-input" type="checkbox" id="{$message->getId()}" />
				<div class="spoiler-body">
					<form role="form" action="/news/{$news->getId()}/new_comment" method="post">
						<div class="form-group">
							<label for="exampleInputText">Текст</label>
							<textarea class="form-control" id="exampleInputText" name="text" rows="3" cols="10"></textarea>
						</div>
						<input type="hidden" name="user_id" value={$user->getId()}>
						<input type="hidden" name="group_id" value={$news->getComments()->getId()}>
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
						<label class="btn btn-default btn-xs" for="{$message2->getId()}">Ответить</label>
						<input class="spoiler-input" type="checkbox" id="{$message2->getId()}" />
						<div class="spoiler-body">
							<form role="form" action="/news/{$news->getId()}/new_comment" method="post">
								<div class="form-group">
									<label for="exampleInputText">Текст</label>
									<textarea class="form-control" id="exampleInputText" name="text" rows="3" cols="10"></textarea>
								</div>
								<input type="hidden" name="user_id" value={$user->getId()}>
								<input type="hidden" name="group_id" value={$news->getComments()->getId()}>
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

							<div class="spoiler">
								<label class="btn btn-default btn-xs" for="{$message3->getId()}">Ответить</label>
								<input class="spoiler-input" type="checkbox" id="{$message3->getId()}" />
								<div class="spoiler-body">
									<form role="form" action="/news/{$news->getId()}/new_comment" method="post">
										<div class="form-group">
											<label for="exampleInputText">Текст</label>
											<textarea class="form-control" id="exampleInputText" name="text" rows="3" cols="10"></textarea>
										</div>
										<input type="hidden" name="user_id" value={$user->getId()}>
										<input type="hidden" name="group_id" value={$news->getComments()->getId()}>
										<div class="form-group">
											<button type="submit" class="btn btn-primary btn-xs" name="id_remessage" value="{$message3->getId()}">Ответить</button>
										</div>
									</form>
								</div>
							</div>
							{if $message3->getMessages()}
							{foreach from=$message3->getMessages() item=message4}
							<div class="media">
								<a class="pull-left" href="#">
									<img class="media-object" src="/Design/images/noavatar92.jpg" alt="" style="width: 64px; height: 64px;">
								</a>
								<div class="media-body">
									<h5 class="media-heading">
										{$message4->getAuthor()->getName()} 
										{$message4->getAuthor()->GetFamily()}
										<small>{$message4->getDate()}</small>
									</h5>
									{$message4->getText()}

									<div class="spoiler">
										<label class="btn btn-default btn-xs" for="{$message4->getId()}">Ответить</label>
										<input class="spoiler-input" type="checkbox" id="{$message4->getId()}" />
										<div class="spoiler-body">
											<form role="form" action="/news/{$news->getId()}/new_comment" method="post">
												<div class="form-group">
													<label for="exampleInputText">Текст</label>
													<textarea class="form-control" id="exampleInputText" name="text" rows="3" cols="10"></textarea>
												</div>
												<input type="hidden" name="user_id" value={$user->getId()}>
												<input type="hidden" name="group_id" value={$news->getComments()->getId()}>
												<div class="form-group">
													<button type="submit" class="btn btn-primary btn-xs" name="id_remessage" value="{$message4->getId()}">Ответить</button>
												</div>
											</form>
										</div>
									</div>
									{if $message4->getMessages()}
									{foreach from=$message4->getMessages() item=message5}
									<div class="media">
										<a class="pull-left" href="#">
											<img class="media-object" src="/Design/images/noavatar92.jpg" alt="" style="width: 64px; height: 64px;">
										</a>
										<div class="media-body">
											<h5 class="media-heading">
												{$message5->getAuthor()->getName()} 
												{$message5->getAuthor()->GetFamily()}
												<small>{$message5->getDate()}</small>
											</h5>
											{$message5->getText()}
										</div>
									</div>
									{/foreach}
									{/if}
								</div>
							</div>
							{/foreach}
							{/if}
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

<form role="form" action="/news/{$news->getId()}/new_comment" method="post">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
				<div class="form-group">
					<label for="exampleInputText">Комментировать</label>
					<textarea class="form-control" id="exampleInputText" name="text" rows="3"></textarea>
				</div>
				<input type="hidden" name="user_id" value={$user->getId()}>
				<input type="hidden" name="group_id" value={$news->getComments()->getId()}>
				<button type="submit" class="btn btn-success" name="id_remessage" value="0">Комментировать</button>
		</div>
	</div>
</form>
{/if}
{/if}

{/block}