{foreach from=$events item=event}
	Название {$event->getTitle()}<br>
	Описание публичное {$event->getDescription_public()}<br>
	Описание приватное {$event->getDescription_private()}<br>
	Тип {$event->getEvent_type()}<br>
	Подтверждение {$event->getConfirm()}<br>
	Текст {$event->getConfirm_description()}<br>
 	Участники:<br>
	{foreach from=$event->getPartners() item=partner}
		{$partner->getName()}<br> 
	{/foreach}
	<a href="/EventShow/{$event->getId()}"}>Перейти</a>
{/foreach}
