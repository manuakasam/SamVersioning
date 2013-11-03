<?php
/**
 * @author    Manuel Stosic <manuel.stosic@duit.de>
 * @copyright 2013 DU-IT GmbH
 */
namespace SamVersioning\Entity;

interface VersionedObjectInterface
{
    /**
     * @param $id
     * @return VersionedObjectInterface
     */
    public function setId($id);

    /**
     * @param $objectId
     * @return VersionedObjectInterface
     */
    public function setObjectId($objectId);

    /**
     * @param $objectName
     * @return VersionedObjectInterface
     */
    public function setObjectName($objectName);

    /**
     * @param $objectSerialized
     * @return VersionedObjectInterface
     */
    public function setObjectSerialized($objectSerialized);

    /**
     * @param \DateTime $objectDate
     * @return VersionedObjectInterface
     */
    public function setObjectDate(\DateTime $objectDate);

    /**
     * @return integer
     */
    public function getId();

    /**
     * @return integer
     */
    public function getObjectId();

    /**
     * @return string
     */
    public function getObjectName();

    /**
     * @return string
     */
    public function getObjectSerialized();

    /**
     * @return \DateTime
     */
    public function getObjectDate();
}