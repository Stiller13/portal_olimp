{extends file="EventPanel.tpl"}
{block name=title}Мероприятие{/block}
{block name=epanel_partners}active{/block}
{block name=panel_title}Участники{/block}

{block name=epanel_content}
<div class="row">
	<div class="col-md-3">
		Заявители:
		{foreach from=$users item=one_user}
			{$one_user->getName()}
		{/foreach}
	</div>
	<div class="col-md-3">
		Участники: <br>
		{foreach from=$partners item=one_partner}
			{$one_partner->getName()}<br>
		{/foreach}
	</div>
</div>

{/block}