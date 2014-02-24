{extends file="EventPanel.tpl"}
{block name=title}Мероприятие{/block}
{block name=epanel_message}active{/block}
{block name=panel_title}Оповещения{/block}

{block name=epanel_content}

<form class="form" action="/event/{$event->getId()}/change_partners" method="post">
	<input type="hidden" name="redirect" value="/event/{$event->getId()}/partners">
	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<label for="exampleInputText">Текст сообщения</label>
				<input type="text" class="form-control" id="exampleInputText" name="text">
			</div>
			<div class="form-group">
				<label for="exampleInputFile">Файл</label>
				<input type="file" id="exampleInputFile" name="uploadfiles[]" multiple="true">
				<p class="help-block">Выберите файл для отправки</p>
			</div>
			<input type="hidden" name="id_remessage" value="0">
			<input type="hidden" name="status" value="0">
			<input type="hidden" name="secret_param" value='top_secret!'>
			<button type="submit" class="btn btn-success" name="message" value="send">Отправить</button>
		</div>
	</div>
</form>

{/block}