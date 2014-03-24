{extends file="MyCabinet.tpl"}
{block name=title}Мой аккаунт{/block}
{block name=cab_menu_account}active{/block}
{block name=cab_content}

<div class="row">
	<!-- <div class="col-md-4 col-md-offset-4">
		<img src="/Design/Images/picture2.png" alt="..." class="img-thumbnail">
	</div> -->
	<div class="col-md-4 col-md-offset-4 margtp-25">
		<form class="form" action="/cabinet/account" method="post">
			<div class="form-group">
				<label class="control-label" for="old_pass">Старый пароль</label>
				<input type="text" class="form-control" name="old_pass" id="old_pass">
			</div>
			<div class="form-group">
				<label class="control-label" for="new_pass1">Новый пароль</label>
				<input type="text" class="form-control" name="new_pass1" id="new_pass1">
			</div>
			<div class="form-group">
				<label class="control-label" for="new_pass2">Еще раз новый пароль</label>
				<input type="text" class="form-control" name="new_pass2" id="new_pass2">
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-success">Сохранить</button>
			</div>
		</form>
	</div>
</div>

{/block}
