{extends file="MainPage.tpl"}
{block name=title}Личные сообщения{/block}
{block name=content}
<div class="row">
	<div class="col-md-4 col-md-offset-4">
		<h2>Личный кабинет</h2>
	</div>
</div>
<ul class="nav nav-tabs">
	<li><a href="/cabinet/account">Аккаунт</a></li>
	<li><a href="/cabinet/profile">Профиль</a></li>
	<li class="active"><a href="/cabinet/message">Сообщения</a></li>
	<li><a href="/cabinet/statistic">Статистика</a></li>
</ul>

<div class="row margtp-25">
	<div class="col-md-3">
		<ul class="nav nav-pills nav-stacked">
			<li class="active">
				<a href="/cabinet/message/personal">
					<span class="badge pull-right">{$personal_mess}</span>
					Личные
				</a>
			</li>
			<li>
				<a href="/cabinet/message/system">
					<span class="badge pull-right"></span>
					Системные
				</a>
			</li>
		</ul>
	</div>
	<div class="col-md-4 col-md-3-offset">
		Участники : 
		{foreach from=$group->getPartners() item=partner}
		{if $user->getId() eq $partner->getId()}
		Вы 
		{else}
		{$partner->getName()} {$partner->getFamily()} 
		{/if}
		{/foreach}
		<hr>

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
			</div>
		</div>

		{/foreach}
		<form role="form" action="/cabinet/message/personal/new_message" method="post">
			<div class="form-group">
				<label for="exampleInputText">Текст сообщения</label>
				<input type="textarea" class="form-control" id="exampleInputText" name="text">
			</div>
			<div class="form-group">
				<label for="exampleInputFile">Файл</label>
				<input type="file" id="exampleInputFile">
				<p class="help-block">Выберите файл для отправки</p>
			</div>
			<input type="hidden" name="user_id" value={$user->getId()}>
			<input type="hidden" name="group_id" value={$group->getId()}>
			<input type="hidden" name="status" value="0">
			<input type="hidden" name="id_remessage" value="0">
			<input type="hidden" name="secret_param" value='top_secret!'>
			<input type="submit" class="btn btn-success" value="Отправить">
		</form>
	</div>
	<div class="col-md-3">
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
	</div>
</div>
{/block}
