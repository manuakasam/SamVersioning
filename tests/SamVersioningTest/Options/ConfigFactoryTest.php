<?php
namespace SamVersioningTest\Options;

use SamVersioning\Options\ConfigFactory;

/**
 * @coversDefaultClass \SamVersioning\Options\ConfigFactory
 */
class ConfigFactoryTest extends \PHPUnit_Framework_TestCase
{
    public $serviceLocatorMock;

    public function setUp()
    {
    }

    /**
     * @covers ::createService
     */
    public function testFactoryReturnsEmptyArrayWhenNoConfigIsPresent()
    {
        $serviceLocatorMock = $this->getMock('Zend\ServiceManager\ServiceManager');
        $serviceLocatorMock->expects($this->once())
            ->method('get')
            ->with('config')
            ->will($this->returnValue(array()));

        $factory = new ConfigFactory();
        $config  = $factory->createService($serviceLocatorMock);

        $this->assertEquals(array(), $config);
    }

    /**
     * @covers ::createService
     */
    public function testFactoryReturnsConfigArrayWhenConfigIsPresent()
    {
        $serviceLocatorMock = $this->getMock('Zend\ServiceManager\ServiceManager');
        $serviceLocatorMock->expects($this->once())
            ->method('get')
            ->with('config')
            ->will($this->returnValue(array('sam_versioning' => array(
                'foo' => 'bar'
            ))));

        $factory = new ConfigFactory();
        $config  = $factory->createService($serviceLocatorMock);

        $this->assertEquals(array('foo' => 'bar'), $config);
    }
}
