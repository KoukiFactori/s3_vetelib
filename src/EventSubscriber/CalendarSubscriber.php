<?php

namespace App\EventSubscriber;

use App\Repository\EventRepository;
use CalendarBundle\CalendarEvents;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\CalendarEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;

class CalendarSubscriber implements EventSubscriberInterface
{
    private EventRepository $eventRepository;
    private Security $security;
    private UrlGeneratorInterface $router;

    public function __construct(EventRepository $eventRepository, Security $security, UrlGeneratorInterface $router)
    {
        $this->eventRepository = $eventRepository;
        $this->security = $security;
        $this->router = $router;
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

        foreach ($events as $event) {
            $calendarEvent = new Event(
                $event->getDescription(),
                $event->getDate(),
                \DateTime::createFromInterface($event->getDate())->modify('+30 minutes')
            );

            $calendarEvent->addOption(
                'url',
                $this->router->generate('app_panel_event_show', [
                    'id' => $event->getId(),
                ])
            );

            $calendar->addEvent($calendarEvent);
        }
    }
}
