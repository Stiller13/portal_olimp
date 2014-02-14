{$event->getTitle()}
{$event->getDescription_public()}
{$event->getDescription_private()}
{$event->getEvent_type()}
{$event->getConfirm()}
{$event->getConfirm_description()}


{foreach from=$event->getPartners() item=partner}
	{$partner->getName()}
{/foreach}
