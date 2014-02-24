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
	<div class="col-md-5">
		<div class="panel panel-default">
			<div class="panel-heading">Условие подачи заявки на участие</div>
			<div class="panel-body">
				{$event->getConfirm_description()}
			</div>
		</div>
	</div>
</div>
{/if}

{if $rule eq "e_partner"}
Участники :<br>
	{foreach from=$event->getPartners() item=partner}
		{$partner->getName()}
	{/foreach}
{/if}
{if $rule}
{elseif $user}
<form class="from" action="/event/{$event->getId()}/change_partners" method="post">
	<div class="form-group">
		<input type="hidden" name="users[]" value={$user->getId()}>
		<input type="hidden" name="redirect" value="/event/{$user->getId()}">
		<button type="submit" class="btn btn-success" name="do" value="add">Хочу учавствовать</button>
	</div>
</form>
{/if}

{/block}