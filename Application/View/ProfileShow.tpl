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
	<form role="form" action="/cabinet/message/personal/new" method="post">
		<input type="hidden" name="status" value="0">
		<input type="hidden" name="secret_param" value='top_secret!'>
		<input type="hidden" name="users[]" value={$profile->getId()}>
		<input type="submit" class="btn btn-success" value="Написать пользователю">
	</form>
</div>
<div class="clearfix"></div>
{/block}
