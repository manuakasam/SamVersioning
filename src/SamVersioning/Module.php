<?php
/**
 * @author    Manuel Stosic <manuel.stosic@duit.de>
 * @copyright 2013 DU-IT GmbH
 */
namespace SamVersioning;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\MvcEvent;

class Module implements
    AutoloaderProviderInterface,
    ConfigProviderInterface
{
    /**
     * Return an array for passing to Zend\Loader\AutoloaderFactory.
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/../../autoload_classmap.php',
            ),
        );
    }

    /**
     * Returns configuration to merge with application configuration
     *
     * @return array|\Traversable
     */
    public function getConfig()
    {
        return array(
            'service_manager' => array(
                'aliases'   => array(
                    'SamVersioning\ObjectManager' => 'Doctrine\ORM\EntityManager'
                ),
                'factories' => array(
                    'SamVersioning\Config'                           => 'SamVersioning\Options\ConfigFactory',
                    'SamVersioning\EventListener\VersioningListener' => 'SamVersioning\EventListener\VersioningListenerFactory',
                    'SamVersioning\Service\VersioningService'        => 'SamVersioning\Service\VersioningServiceFactory'
                )
            ),
            'doctrine'        => array(
                'driver' => array(
                    'SamVersioning_Driver' => array(
                        'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                        'cache' => 'filesystem',
                        'paths' => array(__DIR__ . '/Entity')
                    ),
                    'orm_default'          => array(
                        'drivers' => array(
                            'SamVersioning\Entity' => 'SamVersioning_Driver'
                        )
                    )
                )
            )
        );
    }

    public function onBootstrap(MvcEvent $mvcEvent)
    {
        $app    = $mvcEvent->getApplication();
        $srvmgr = $app->getServiceManager();
        $evmgr  = $app->getEventManager();

        $evmgr->attachAggregate(
            $srvmgr->get('SamVersioning\EventListener\VersioningListener')
        );
    }
}