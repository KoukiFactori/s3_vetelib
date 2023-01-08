<?php

namespace App\EventSubscriber;

use App\Repository\EventRepository;
use CalendarBundle\CalendarEvents;
use CalendarBundle\Event\CalendarEvent;
use CalendarBundle\Entity\Event;
use DateTime;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Security;

class CalendarSubscriber implements EventSubscriberInterface
{
    private EventRepository $eventRepository;
    private Security $security;

    public function __construct(EventRepository $eventRepository, Security $security)
    {
        $this->eventRepository = $eventRepository;
        $this->security = $security;
    }
    
    public static function getSubscribedEvents(): array
    {
        return [
            CalendarEvents::SET_DATA => 'onCalendarSetData',
        ];
    }

    public function onCalendarSetData(CalendarEvent $calendar)
    {
        $events = $this->eventRepository->getVeterinaireEventsBetween(
            $this->security->getUser()->getId(),
            $calendar->getStart(),
            $calendar->getEnd()
        );

        foreach($events as $event) {
            $calendarEvent = new Event(
                $event->getDescription(),
                $event->getDate(),
                DateTime::createFromInterface( $event->getDate())->modify('+30 minutes')
            );

            $calendar->addEvent($calendarEvent);
        }
    }
}
