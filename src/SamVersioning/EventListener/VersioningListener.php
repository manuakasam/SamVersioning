<?php
namespace SamVersioning\EventListener;

use SamVersioning\Service\VersioningServiceInterface;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;

class VersioningListener implements ListenerAggregateInterface
{
    /**
     * @var array
     */
    protected $listeners;

    /**
     * @var \SamVersioning\Service\VersioningServiceInterface
     */
    protected $versioningService;

    /**
     * @param VersioningServiceInterface $versioningService
     */
    function __construct(VersioningServiceInterface $versioningService)
    {
        $this->versioningService = $versioningService;
    }

    /**
     * Attach one or more listeners
     * Implementors may add an optional $priority argument; the EventManager
     * implementation will pass this to the aggregate.
     *
     * @param EventManagerInterface $events
     * @return void
     */
    public function attach(EventManagerInterface $events)
    {
        $sharedEvents = $events->getSharedManager();

        foreach ($this->versioningService->getEventsToVersionify() as $className => $eventName) {
            $this->listeners[] = $sharedEvents->attach($className, $eventName, array($this, 'logVersioning'));
        }
    }

    /**
     * Detach all previously attached listeners
     *
     * @param EventManagerInterface $events
     * @return void
     */
    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }

    /**
     * @param EventInterface $event
     */
    public function logVersioning(EventInterface $event)
    {
        $this->versioningService->logVersionForObject(
            $event->getParam('object')
        );
    }
}