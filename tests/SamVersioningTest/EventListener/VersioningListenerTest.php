<?php
namespace SamVersioningTest\EventListener;

use SamVersioning\EventListener\VersioningListener;

/**
 * @coversDefaultClass \SamVersioning\EventListener\VersioningListener
 */
class VersioningListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::__construct
     */
    public function testConstructorWorksWhenServiceIsPassed()
    {
        $versioningServiceMock = $this->getMock('SamVersioning\Service\VersioningServiceInterface');

        $listener = new VersioningListener($versioningServiceMock);

        $this->assertInstanceOf('Zend\EventManager\ListenerAggregateInterface', $listener);
    }

    /**
     * @covers ::attach
     */
    public function testEventsAreAttachedToListenersArray()
    {
//        Heavy Work in Progress....
//        =======================================================
//        $callbackHandlers = array();
//        $me = $this;
//
//        $sharedEventManagerMock = $this->getMock('Zend\EventManager\SharedEventManagerAwareInterface');
//        $sharedEventManagerMock->expects($this->any())
//            ->method('attach')
//            ->will($this->returnCallBack(function() use (&$callbackHandlers, $me) {
//                $callbackHandlers[] = $me->getMock()
//            }));
//
//        $eventManagerMock = $this->getMock('Zend\EventManager\EventManagerInterface');
//        $eventManagerMock->expects($this->once())
//            ->method('getSharedManager')
//            ->will($this->returnValue($sharedEventManagerMock));
//
//        $versioningServiceMock = $this->getMock('SamVersioning\Service\VersioningServiceInterface');
//        $versioningServiceMock->expects($this->once())
//            ->method('getEventsToVersionify')
//            ->will($this->returnValue(array(
//                'foo' => 'bar',
//                'baz' => 'bat'
//            )));
//
//        $listener = new VersioningListener($versioningServiceMock);
//        $listener->attach($eventManagerMock);
    }
}
