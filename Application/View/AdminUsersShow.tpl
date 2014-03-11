{extends file="AdminCabinet.tpl"}
{block name=admin_cab_menu_users}active{/block}
{block name=admin_cab_content}

<div class="row margtp-25">
	<div class="col-md-12">
		<table class="table table-striped margtp-25">
			<tr>
				<th><p class="text-center">Id</p></th>
				<th><p class="text-center">Имя</p></th>
				<th><p class="text-center">Фамилия</p></th>
				<th><p class="text-center">Отчество</p></th>
				<th><p class="text-center">День рождения<p></th>
				<th><p class="text-center">Статус в системе</p></th>
				<th><p class="text-center">Пол</p></th>
				<th><p class="text-center">Телефон</p></th>
				<th><p class="text-center">Город</p></th>
			</tr>
		{foreach from=$user_list item=user}
			<tr>
				<td><p class="text-center">{$user->getId()}</p></td>
				<td><p class="text-center">{$user->getName()}</p></td>
				<td><p class="text-center">{$user->getFamily()}</p></td>
				<td><p class="text-center">{$user->getPatronymic()}</p></td>
				<td><p class="text-center">{$user->getBirthday()}</p></td>
				<td><p class="text-center">{$user->getStatusSys()}</p></td>
				<td><p class="text-center">{$user->getGender()}</p></td>
				<td><p class="text-center">{$user->getTelephone()}</p></td>
				<td><p class="text-center">{$user->getResidence()}</p></td>
			</tr>
		{/foreach}
		</table>
	</div>
</div>

{/block}