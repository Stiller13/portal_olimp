{extends file="AdminUsersPanel.tpl"}
{block name=admin_users_content}

<div class="row">
	<div class="col-md-4">
		<form class="form-horizontal" action="/admin_cabinet/user/{$one_user->getId()}/profile_save" method="post">
			<div class="input-group">
				<span class="input-group-addon">Id</span>
				<input type="text" class="form-control" value={$one_user->getId()}>
			</div>
			<div class="input-group">
				<span class="input-group-addon">Имя</span>
				<input type="text" class="form-control" name="name" value={$one_user->getName()}>
			</div>
			<div class="input-group">
				<span class="input-group-addon">Фамилия</span>
				<input type="text" class="form-control" name="surname" value={$one_user->getFamily()}>
			</div>
			<div class="input-group">
				<span class="input-group-addon">Отчество</span>
				<input type="text" class="form-control" name="patronymic" value={$one_user->getPatronymic()}>
			</div>
			<div class="input-group">
				<span class="input-group-addon">Дата рождения</span>
				<input type="date" class="form-control" name="birthday" value={$one_user->getBirthday()}>
			</div>
			<div class="input-group">
				<span class="input-group-addon">Пол</span>
				<select class="form-control" name="gender">
					<option value=""{if $one_user->getGender() eq ""}selected{/if}>не выбрано</option>
					<option value="male" {if $one_user->getGender() eq 'male'}selected{/if}>муж</option>
					<option value="female" {if $one_user->getGender() eq 'female'}selected{/if}>жен</option>
				</select>
			</div>
			<div class="input-group">
				<span class="input-group-addon">Город</span>
				<input type="text" class="form-control" name="residence" value={$one_user->getResidence()}>
			</div>
			<div class="input-group">
				<span class="input-group-addon">Почта</span>
				<input type="text" class="form-control" name="mail" value={$one_user->getMail()}>
			</div>
			<div class="input-group">
				<span class="input-group-addon">Телефон</span>
				<input type="text" class="form-control" name="telephone" value={$one_user->getTelephone()}>
			</div>
			<div class="input-group">
				<span class="input-group-addon">Статус в системе</span>
				<select class="form-control" name="user_system_status">
				{foreach from=$list_uss item=value}
					<option value={$value} {if $value eq $user->getStatusSys()}selected{/if}>{$value}</option>
				{/foreach}
				</select>
			</div>

			<div class="input-group">
				<button type="submit" class="btn btn-success" name="mode" value="profile">Изменить</button>
			</div>
		</form>
	</div>
	<div class="col-md-4">
		<form class="form-horizontal" action="/cabinet/account" method="post">
			<div class="input-group">
				<span class="input-group-addon">Новый пароль</span>
				<input type="text" class="form-control" name="new_pass1"}>
			</div>
			<div class="input-group">
				<button type="submit" class="btn btn-success">Изменить</button>
			</div>
		</form>
	</div>
</div>

{/block}