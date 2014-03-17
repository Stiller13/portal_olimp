{extends file="AdminUsersPanel.tpl"}
{block name=admin_users_menu_moderators}active{/block}
{block name=admin_users_content}

<div class="row margtp-25">
	<div class="col-md-12">
		<table class="table table-striped margtp-25">
			<tr>
				<th>
					<p class="text-center">
						{if $id_up}<a href="/admin_cabinet/users/all/id_down">Id</a>{else}<a href="/admin_cabinet/users/all/id_up">Id</a>{/if}
					</p>
				</th>
				<th>
					<p class="text-center">
						{if $name_up}<a href="/admin_cabinet/users/all/name_down">Имя</a>{else}<a href="/admin_cabinet/users/all/name_up">Имя</a>{/if}
					</p>
				</th>
				<th>
					<p class="text-center">
						{if $surname_up}<a href="/admin_cabinet/users/all/surname_down">Фамилия</a>{else}<a href="/admin_cabinet/users/all/surname_up">Фамилия</a>{/if}
					</p>
				</th>
				<th><p class="text-center">Отчество</p></th>
				<th><p class="text-center">День рождения<p></th>
				<th><p class="text-center">Статус в системе</p></th>
				<th>
					<p class="text-center">
						{if $gender_up}<a href="/admin_cabinet/users/all/gender_down">Пол</a>{else}<a href="/admin_cabinet/users/all/gender_up">Пол</a>{/if}
					</p>
				</th>
				<th><p class="text-center">Телефон</p></th>
				<th><p class="text-center">Город</p></th>
				<th><p class="text-center">Действие</p></th>
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
				<td><a href="/admin_cabinet/user/{$user->getId()}">Изм</a>
				<a href="/admin_cabinet/users/moderators/{$user->getId()}/del">Уд</a></td>
			</tr>
		{/foreach}
		</table>
	</div>
</div>

{/block}