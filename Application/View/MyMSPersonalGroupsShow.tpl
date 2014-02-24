{extends file="MyMessage.tpl"}
{block name=title}Личная переписка{/block}
{block name=message_content}

<div class="col-md-4">
	<form role="form" action="/cabinet/message/personal/new" method="post">
		<input type="hidden" name="status" value="0">
		<input type="hidden" name="secret_param" value='top_secret!'>
		<input type="submit" class="btn btn-success" value="Новая группа">
	</form>
	<ul class="nav nav-pills nav-stacked">
	{foreach from=$list_group item=one_group}
		<li>
			<a href="/cabinet/message/personal/{$one_group->getId()}">
				{foreach from=$one_group->getPartners() item=one_partner name=foo}

					{if $user->getId() eq $one_partner->getId()}
						Вы
					{else}
						{$one_partner->getName()}
					{/if}
				{/foreach}
				{if $one_group->getVisit()}
				<span class="badge pull-right">{if $one_group->getVisit()->getCountMessage() > 0}{$one_group->getVisit()->getCountMessage()}{/if}</span>
				{/if}
			</a>
		</li>
	{/foreach}
	</ul>
</div>

{/block}
