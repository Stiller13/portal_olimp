{extends file="EventPanel.tpl"}
{block name=title}Мероприятие{/block}
{block name=epanel_partners}active{/block}

{block name=epanel_content}

<form class="form" action="/event/{$event->getId()}/change_partners" method="post">
	<input type="hidden" name="redirect" value="/event/{$event->getId()}/partners">
	<div class="row">
		<div class="col-md-4">
			Заявленные:<br>
			{foreach from=$event->getPartners() item=one_user}
				{if $one_user->getRule() eq "e_user"}
				<label>
					<input name="users[]" type="checkbox" value="{$one_user->getId()}">
					<a href="/profile/{$one_user->getId()}">
					{$one_user->getName()} 
					{$one_user->getFamily()}</a>
					{if $one_user->getFile()} <a href="/file/{$one_user->getFile()->getCode()}"><span class="glyphicon glyphicon-file"></span></a>{/if}
				</label><br>
				{/if}
			{/foreach}
		</div>
		<div class="col-md-4">
			Участники: <br>
			{foreach from=$event->getPartners() item=one_user}
				{if $one_user->getRule() eq "e_partner"}
				<label>
					<input name="users[]" type="checkbox" value="{$one_user->getId()}">
					<a href="/profile/{$one_user->getId()}">
					{$one_user->getName()} 
					{$one_user->getFamily()}</a>
					{if $one_user->getFile()} !{/if}
				</label><br>
				{/if}
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
			<button type="submit" class="btn btn-primary" name="do" value="invit">Пригласить</button>
		</div>
	</div>
	<button type="submit" class="btn btn-success" name="do" value="ok">Подтвердить</button>
	<button type="submit" class="btn btn-danger" name="do" value="del">Удалить</button>
</form>

{/block}