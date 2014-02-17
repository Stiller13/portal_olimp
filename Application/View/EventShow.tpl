{extends file="Main.tpl"}
{block name=title}Главная{/block}
{block name=content}

<h1 class="text-center">{$event->getTitle()}</h1>
<hr>

<div class="panel panel-default">
	<div class="panel-heading">Описание</div>
	<div class="panel-body">
	{if $rule_private}
		{$event->getDescription_private()}
	{else}
		{$event->getDescription_public()}
	{/if}
	</div>
</div>


{if $event->getEvent_type() eq "closed"}
<div class="row">
	<div class="alert alert-warning col-md-4 col-md-offset-4">
		<p class="text-center">Данное мероприятие : закрытое</p>
	</div>
</div>
{/if}
{if $event->getConfirm() eq "1"}
<div class="row">
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">Условие при подаче заявки на участие</div>
			<div class="panel-body">
				{$event->getConfirm_description()}
			</div>
		</div>
	</div>
</div>
{/if}
<!-- Если чувак не подтвержден как участник -->
{if $rule_private}
Участники :<br>
	{foreach from=$event->getPartners() item=partner}
		{$partner->getName()}
	{/foreach}
{/if}

{/block}