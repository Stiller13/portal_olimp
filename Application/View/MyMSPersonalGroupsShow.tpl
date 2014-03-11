{extends file="MyMessage.tpl"}
{block name=title}Личная переписка{/block}
{block name=personal_mg}active{/block}
{block name=message_content}

<div class="col-md-4">
	<form role="form" action="/cabinet/message/personal/new" method="post">
		<input type="hidden" name="status" value="0">
		<input type="submit" class="btn btn-success" value="Новая группа">
	</form>
	<ul class="nav nav-pills nav-stacked">
	{foreach from=$list_group item=one_group}
		<li>
			<a href="/cabinet/message/personal/{$one_group->getId()}">
				{foreach from=$one_group->getPartners() item=one_partner name=foo}
					{if $smarty.foreach.foo.first}{else},{/if}
					{if $user->getId() eq $one_partner->getId()}
						Вы
					{else}
						{$one_partner->getName()}
					{/if}
				{/foreach}
				{$count_mess = $one_group->getCountNewMessage()}
				<span class="badge pull-right">{if $count_mess > 0}{$count_mess}{/if}</span>
			</a>
		</li>
	{/foreach}
	</ul>
</div>

{/block}
