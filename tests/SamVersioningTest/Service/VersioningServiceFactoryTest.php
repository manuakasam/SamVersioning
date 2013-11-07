<?php
namespace SamVersioningTest\Service;

use SamVersioning\Service\VersioningServiceFactory;

/**
 * @coversDefaultClass \SamVersioning\Service\VersioningServiceFactory
 */
class VersioningServiceFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::createService
     */
    public function testVersioningServiceIsReturnedWhenVersionifyArrayIsConfigured()
    {
        $objectManagerMock = $this->getMock('Doctrine\Common\Persistence\ObjectManager');

        $returnMap = array(
            array('SamVersioning\Config', array('versionify' => array('foo' => 'bar'))),
            array('SamVersioning\ObjectManager', $objectManagerMock)
        );

        $serviceManagerMock = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $serviceManagerMock->expects($this->any())
            ->method('get')
            ->will($this->returnValueMap($returnMap));

        $factory = new VersioningServiceFactory();
        $service = $factory->createService($serviceManagerMock);

        $this->assertInstanceOf('SamVersioning\Service\VersioningServiceInterface', $service);
    }

    /**
     * @covers ::createService
     */
    public function testVersioningServiceIsReturnedWhenVersionifyArrayIsMissing()
    {
        $objectManagerMock = $this->getMock('Doctrine\Common\Persistence\ObjectManager');

        $returnMap = array(
            array('SamVersioning\Config', array()),
            array('SamVersioning\ObjectManager', $objectManagerMock)
        );

        $serviceManagerMock = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $serviceManagerMock->expects($this->any())
            ->method('get')
            ->will($this->returnValueMap($returnMap));

        $factory = new VersioningServiceFactory();
        $service = $factory->createService($serviceManagerMock);

        $this->assertInstanceOf('SamVersioning\Service\VersioningServiceInterface', $service);
    }
}
