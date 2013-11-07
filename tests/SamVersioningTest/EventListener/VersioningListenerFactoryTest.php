<?php
namespace SamVersioningTest\EventListener;

use SamVersioning\EventListener\VersioningListenerFactory;

/**
 * @coversDefaultClass \SamVersioning\EventListener\VersioningListenerFactory
 */
class VersioningListenerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::createService
     */
    public function testVersioningListenerIsReturned()
    {
        $versioningServiceMock = $this->getMock('SamVersioning\Service\VersioningServiceInterface');
        $serviceLocatorMock    = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');

        $serviceLocatorMock->expects($this->once())
            ->method('get')
            ->will($this->returnValue($versioningServiceMock));

        $factory = new VersioningListenerFactory();
        $service = $factory->createService($serviceLocatorMock);

        $this->assertInstanceOf('Zend\EventManager\ListenerAggregateInterface', $service);
    }
}
