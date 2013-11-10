<?php
namespace SamVersioningTest;

use SamVersioning\Module;

/**
 * @coversDefaultClass \SamVersioning\Module
 */
class ModuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::getAutoloaderConfig
     */
    public function testGetAutoloaderConfigContainsClassmap()
    {
        $module = new Module();
        $moduleClassmap = $module->getAutoloaderConfig();

        $this->assertTrue(array_key_exists(
            'Zend\Loader\ClassMapAutoloader',
            $moduleClassmap
        ));
    }

    /**
     * @covers ::getAutoloaderConfig
     */
    public function testClassmapFileExists()
    {
        $this->assertTrue(file_exists(__DIR__ . '/../../autoload_classmap.php'));
    }

    /**
     * @covers ::getConfig
     */
    public function testGetConfigReturnsProperConfiguration()
    {
        $module = new Module();
        $moduleConfig = $module->getConfig();

        $this->assertTrue(array_key_exists('doctrine', $moduleConfig));
        $this->assertTrue(array_key_exists('service_manager', $moduleConfig));
    }

    /**
     * @covers ::onBootstrap
     */
    public function testBootstrapRunsWithoutProblems()
    {
        $samVersioningListenerMock = $this->getMock('Zend\EventManager\ListenerAggregateInterface');

        $serviceLocatorMock = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $serviceLocatorMock->expects($this->once())
            ->method('get')
            ->with('SamVersioning\EventListener\VersioningListener')
            ->will($this->returnValue($samVersioningListenerMock));

        $eventManagerMock = $this->getMock('Zend\EventManager\EventManagerInterface');
        $eventManagerMock->expects($this->once())
            ->method('attachAggregate')
            ->with($samVersioningListenerMock)
            ->will($this->returnValue(true));

        $applicationMock = $this->getMock('Zend\Mvc\ApplicationInterface');
        $applicationMock->expects($this->once())
            ->method('getServiceManager')
            ->will($this->returnValue($serviceLocatorMock));

        $applicationMock->expects($this->once())
            ->method('getEventManager')
            ->will($this->returnValue($eventManagerMock));

        $mvcEventMock = $this->getMockBuilder('Zend\Mvc\MvcEvent')
            ->disableOriginalConstructor()
            ->getMock();
        $mvcEventMock->expects($this->once())
            ->method('getApplication')
            ->will($this->returnValue($applicationMock));

        $module = new Module();
        $module->onBootstrap($mvcEventMock);
    }
}
