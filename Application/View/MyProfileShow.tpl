{extends file="MyCabinet.tpl"}
{block name=title}Мой профиль{/block}
{block name=cab_menu_profile}active{/block}
{block name=cab_content}

<div class="row">
	<div class="col-md-4 col-md-offset-4 margtp-25">
		<form class="form" action="/cabinet/profile" method="post">
			<div class="form-group">
				<label class="control-label" for="name">Имя</label>
				<input type="text" class="form-control" name="name" id="name" value={$user->getName()}>
			</div>
			<div class="form-group">
				<label class="control-label" for="surname">Фамилия</label>
				<input type="text" class="form-control" name="surname" id="surname" value={$user->getFamily()}>
			</div>
			<div class="form-group">
				<label class="control-label" for="patronymic">Отчество</label>
				<input type="text" class="form-control" name="patronymic" id="patronymic"  value={$user->getPatronymic()}>
			</div>
			<div class="form-group">
				<label class="control-label" for="birthday">Дата рождения</label>
				<input type="date" class="form-control" name="birthday" id="birthday" value={$user->getBirthday()}>
			</div>
			<div class="form-group">
				<label class="control-label" for="gender">Пол</label>
				<select class="form-control" name="gender" id="gender">
					<option value=""{if $user->getGender() eq ""}selected{/if}>не выбрано</option>
					<option value="male" {if $user->getGender() eq 'male'}selected{/if}>муж</option>
					<option value="female" {if $user->getGender() eq 'female'}selected{/if}>жен</option>
				</select>
			</div>
			<div class="form-group">
				<label class="control-label" for="residence">Город</label>
				<input type="text" class="form-control" name="residence" id="residence" value={$user->getResidence()}>
			</div>
			<div class="form-group">
				<label class="control-label" for="mail">Почта</label>
				<input type="text" class="form-control" name="mail" id="mail" value={$user->getMail()}>
			</div>
			<div class="form-group">
				<label class="control-label" for="telephone">Телефон</label>
				<input type="text" class="form-control" name="telephone" id="telephone" value={$user->getTelephone()}>
			</div>
			<div class="form-group">
				<label class="control-label" for="user_system_status">Статус в системе</label>
				<select class="form-control" name="user_system_status" id="user_system_status">
				{foreach from=$list_uss item=value}
					<option value={$value} {if $value eq $user->getStatusSys()}selected{/if}>{$value}</option>
				{/foreach}
				</select>
			</div>

			<div class="form-group">
				<button type="submit" class="btn btn-success">Сохранить</button>
			</div>
		</form>
	</div>
</div>

{/block}
