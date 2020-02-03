<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Article;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AppSubscriber implements EventSubscriberInterface
{
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function onPreWrite(ViewEvent $event)
    {
        $element = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();
        $connectedUser = $this->tokenStorage->getToken()->getUser();

        if ($element instanceof Article && Request::METHOD_POST === $method) {
            $element->setCreatedBy($connectedUser);
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            ViewEvent::class => ['onPreWrite', EventPriorities::PRE_WRITE],
        ];
    }
}
