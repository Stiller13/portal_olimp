{extends file="EventPanel.tpl"}
{block name=title}Мероприятие{/block}
{block name=epanel_partners}active{/block}
{block name=panel_title}Участники{/block}

{block name=epanel_content}

<form class="form" action="/event/{$event->getId()}/change_partners" method="post">
	<input type="hidden" name="redirect" value="/event/{$event->getId()}/partners">
	<div class="row">
		<div class="col-md-4">
			Заявленные:<br>
			{foreach from=$users item=one_user}
				<label>
					<input name="users[]" type="checkbox" value="{$one_user->getId()}">
					{$one_user->getName()} {$one_user->getFamily()}
				</label><br>
			{/foreach}
		</div>
		<div class="col-md-4">
			Участники: <br>
			{foreach from=$partners item=one_partner}
				<label>
					<input name="users[]" type="checkbox" value="{$one_partner->getId()}">
					{$one_partner->getName()} {$one_partner->getFamily()}
				</label><br>
			{/foreach}
		</div>
		<div class="col-md-4">
			<p>Пригласите участников из списка</p>
			<div class="form-group">
				<select name="users[]" multiple class="form-control">
				{foreach from=$user_list item=one_user}
					<option value={$one_user->getId()}>{$one_user->getName()} {$one_user->getFamily()}</option>
				{/foreach}
				</select>
			</div>
			<button type="submit" class="btn btn-primary" name="do" value="ok">Пригласить</button>
		</div>
	</div>
	<button type="submit" class="btn btn-success" name="do" value="ok">Подтвердить</button>
	<button type="submit" class="btn btn-danger" name="do" value="del">Удалить</button>
</form>

{/block}