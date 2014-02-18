{extends file="MyCabinet.tpl"}
{block name=title}Мой профиль{/block}
{block name=cab_menu_profile}active{/block}
{block name=cab_content}

<div class="row">
	<div class="col-md-4 col-md-offset-4">
		<form class="form-horizontal" action="/cabinet/profile" method="post">
			<div class="input-group">
				<span class="input-group-addon">Имя</span>
				<input type="text" class="form-control" name="name" value={$user->getName()}>
			</div>
			<div class="input-group">
				<span class="input-group-addon">Фамилия</span>
				<input type="text" class="form-control" name="surname" value={$user->getFamily()}>
			</div>
			<div class="input-group">
				<span class="input-group-addon">Отчество</span>
				<input type="text" class="form-control" name="patronymic" value={$user->getPatronymic()}>
			</div>
			<div class="input-group">
				<span class="input-group-addon">Дата рождения</span>
				<input type="date" class="form-control" name="birthday" value={$user->getBirthday()}>
			</div>
			<div class="input-group">
				<span class="input-group-addon">Пол</span>
				<select class="form-control" name="gender">
					<option value=""{if $user->getGender() eq ""}selected{/if}>не выбрано</option>
					<option value="male" {if $user->getGender() eq 'male'}selected{/if}>муж</option>
					<option value="female" {if $user->getGender() eq 'female'}selected{/if}>жен</option>
				</select>
			</div>
			<div class="input-group">
				<span class="input-group-addon">Город</span>
				<input type="text" class="form-control" name="residence" value={$user->getResidence()}>
			</div>
			<div class="input-group">
				<span class="input-group-addon">Почта</span>
				<input type="text" class="form-control" name="mail" value={$user->getMail()}>
			</div>
			<div class="input-group">
				<span class="input-group-addon">Телефон</span>
				<input type="text" class="form-control" name="telephone" value={$user->getTelephone()}>
			</div>
			<div class="input-group">
				<span class="input-group-addon">Статус в системе</span>
				<select class="form-control" name="user_system_status">
				{foreach from=$list_uss item=value}
					<option value={$value["id"]}>{$value["name"]}</option>
				{/foreach}
				</select>
			</div>

			<div class="input-group">
				<button type="submit" class="btn btn-success">Сохранить</button>
			</div>
		</form>
	</div>
</div>

{/block}
