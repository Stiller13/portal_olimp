{$event->getTitle()}
{$event->getDescription_public()}
{$event->getDescription_private()}
{$event->getEvent_type()}
{$event->getConfirm()}
{$event->getConfirm_description()}


{while $event->getPartners()->valid()}
	{print_r($event->getPartners()->next()->getName())}
{/while}
