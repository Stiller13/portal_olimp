{extends file="Main.tpl"}
{block name=title}Мой профиль{/block}
{block name=content}
<div class="col-md-3 col-md-offset-3">
	<p>
		<strong>Имя : </strong>{$profile->getName()}<br>
		<strong>Фамилия : </strong>{$profile->getFamily()}<br>
		<strong>Отчество : </strong>{$profile->getPatronymic()}<br>
		<strong>Город : </strong>{$profile->getResidence()}<br>
	</p>
</div>
<div class="clearfix"></div>
{/block}
