{extends file="MyCabinet.tpl"}
{block name=title}Мои сообщения{/block}
{block name=cab_menu_message}active{/block}
{block name=cab_content}

<div class="row margtp-25">
	<div class="col-md-2">
		<ul class="nav nav-pills nav-stacked">
			<li class="{block name=personal_mg}{/block}">
				<a href="/cabinet/message/personal">
					<span class="badge pull-right">{if $personal_mess > 0}{$personal_mess}{/if}</span>
					Личные
				</a>
			</li>
			<li class="{block name=system_mg}{/block}">
				<a href="/cabinet/message/system">
					<span class="badge pull-right">{if $system_mess > 0}{$system_mess}{/if}</span>
					Системные
				</a>
			</li>
			<li class="{block name=notice_mg}{/block}">
				<a href="/cabinet/message/notice">
					<span class="badge pull-right">{if $notice_mess > 0}{$notice_mess}{/if}</span>
					Оповещения
				</a>
			</li>
		</ul>
	</div>
	{block name=message_content}{/block}
</div>

{/block}