{extends file="Main.tpl"}
{block name=title}Создание мероприятия{/block}
{block name=menu_events}active{/block}
{block name=content}

<h1 class="text-center">Создание мероприятия</h1>

<form class="form" action="/event/create" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label class="control-label" for="inputTitle">Название</label>
		<input type="text" name="title" class="form-control" id="inputTitle">
	</div>
	<dic class="row">
		<div class="col-md-1 col-md-offset-5">
			<div class="form-group">
				<button type="submit" class="btn btn-success">Создать</button>
			</div>
		</div>
	</dic>
</form>

{/block}