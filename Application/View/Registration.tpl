{extends file="Main.tpl"}
{block name=title}Регистрация{/block}
{block name=content}

<div class="row">
	<div class="col-md-3 col-md-offset-4">
		<form class="form" method="post" action="/Registration">
			<div class="form-group">
				<label class="control-label" for="inputLogin">Логин</label>
				<input type="text" name="login" class="form-control" id="inputLogin" placeholder="Логин">
			</div>
			<div class="form-group">
				<label class="control-label" for="inputPassword">Пароль</label>
				<input type="password" name="pass1" class="form-control" id="inputPassword" placeholder="Пароль">
			</div>
			<div class="form-group">
				<label class="control-label" for="inputPassword">Пароль</label>
				<input type="password" name="pass2" class="form-control" id="inputPassword" placeholder="Пароль">
			</div>
			<div class="form-group">
				<button type="submit" name="signin" class="btn btn-success">Регистрация</button>
			</div>
		</form>
	</div>
</div>

{/block}
