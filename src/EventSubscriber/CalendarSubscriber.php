<?php

namespace App\EventSubscriber;

use App\Repository\EventRepository;
use CalendarBundle\CalendarEvents;
use CalendarBundle\Event\CalendarEvent;
use CalendarBundle\Entity\Event;
use DateTime;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CalendarSubscriber implements EventSubscriberInterface
{
    private EventRepository $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }
    
    public static function getSubscribedEvents(): array
    {
        return [
            CalendarEvents::SET_DATA => 'onCalendarSetData',
        ];
    }

    public function onCalendarSetData(CalendarEvent $calendar)
    {
        $events = $this->eventRepository->getEventsBetween(
            $calendar->getStart(),
            $calendar->getEnd()
        );

        foreach($events as $event) {
            $calendarEvent = new Event(
                $event->getDescription(),
                $event->getDate(),
                DateTime::createFromInterface($event->getDate())->modify('+30 minutes')
            );

            $calendar->addEvent($calendarEvent);
        }
    }
}
