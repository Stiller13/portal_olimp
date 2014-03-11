{extends file="Main.tpl"}
{block name=title}Создание мероприятия{/block}
{block name=menu_events}active{/block}
{block name=content}

<h1 class="text-center">Создание мероприятия</h1>

<dic class="row">
	<form class="form" action="/event/create" method="post" enctype="multipart/form-data">
		<div class="col-md-6 col-md-offset-3">
			<div class="form-group">
				<label class="control-label" for="inputTitle">Название</label>
				<input type="text" name="title" class="form-control" id="inputTitle">
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-success">Создать</button>
			</div>
		</div>
	</form>
</div>

{/block}