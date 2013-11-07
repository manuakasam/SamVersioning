<?php
/**
 * @author    Manuel Stosic <manuel.stosic@duit.de>
 * @copyright 2013 DU-IT GmbH
 */
namespace SamVersioning\Service;

use SamVersioning\Entity\VersionedObject;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class VersioningServiceFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config             = $serviceLocator->get('SamVersioning\Config');
        $eventsToVersionify = array();

        if (isset($config['versionify'])) {
            $eventsToVersionify = $config['versionify'];
        }

        return new VersioningService(
            $serviceLocator->get('SamVersioning\ObjectManager'),
            new VersionedObject(),
            $eventsToVersionify
        );
    }
}
