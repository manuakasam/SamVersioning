<?php
/**
 * @author    Manuel Stosic <manuel.stosic@duit.de>
 * @copyright 2013 DU-IT GmbH
 */
namespace SamVersioning\Service;

use Doctrine\Common\Persistence\ObjectManager;
use SamVersioning\Entity\VersionedObjectInterface;

class VersioningService implements VersioningServiceInterface
{
    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    protected $objectManager;

    /**
     * @var \SamVersioning\Entity\VersionedObjectInterface
     */
    protected $versionedObjectPrototype;

    /**
     * @var array
     */
    protected $eventsToVersionify;

    /**
     * @param ObjectManager            $objectManager
     * @param VersionedObjectInterface $versionedObjectPrototype
     * @param array                    $eventsToVersionify
     */
    public function __construct(ObjectManager $objectManager, VersionedObjectInterface $versionedObjectPrototype, $eventsToVersionify)
    {
        $this->objectManager            = $objectManager;
        $this->versionedObjectPrototype = $versionedObjectPrototype;
        $this->eventsToVersionify       = $eventsToVersionify;
    }

    /**
     * @param $object
     * @return VersionedObjectInterface
     */
    public function logVersionForObject($object)
    {
        $prototype = $this->getVersionedObjectPrototype();

        $prototype->setObjectId($object->getId())
            ->setObjectName(get_class($object))
            ->setObjectSerialized(serialize($object))
            ->setObjectDate(new \DateTime('now'));

        $this->objectManager->persist($prototype);
        $this->objectManager->flush();

        return $prototype;
    }

    public function retrieveVersionsForObjectName($objectName)
    {
        return $this->objectManager->getRepository('SamVersioning\Entity\VersionedObject')->findBy(array(
            'object_name' => $objectName
        ), array(
            'objectDate DESC'
        ));
    }

    public function retrieveVersionsForObjectNameAndId($objectName, $objectId)
    {
        return $this->objectManager->getRepository('SamVersioning\Entity\VersionedObject')->findBy(array(
            'objectName' => $objectName,
            'objectId'   => $objectId
        ), array(
            'objectDate DESC'
        ));
    }

    /**
     * @param \SamVersioning\Entity\VersionedObjectInterface $versionedObjectPrototype
     * @return VersioningService
     */
    public function setVersionedObjectPrototype($versionedObjectPrototype)
    {
        $this->versionedObjectPrototype = $versionedObjectPrototype;

        return $this;
    }

    /**
     * @return \SamVersioning\Entity\VersionedObjectInterface
     */
    public function getVersionedObjectPrototype()
    {
        return $this->versionedObjectPrototype;
    }

    /**
     * @param array $eventsToVersionify
     * @return VersioningService
     */
    public function setEventsToVersionify($eventsToVersionify)
    {
        $this->eventsToVersionify = $eventsToVersionify;

        return $this;
    }

    /**
     * @return array
     */
    public function getEventsToVersionify()
    {
        return $this->eventsToVersionify;
    }
}