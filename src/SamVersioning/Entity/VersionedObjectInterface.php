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
     * @param $objectDate
     * @return VersionedObjectInterface
     */
    public function setObjectDate($objectDate);

    /**
     * @return VersionedObjectInterface
     */
    public function getId();

    /**
     * @return VersionedObjectInterface
     */
    public function getObjectId();

    /**
     * @return VersionedObjectInterface
     */
    public function getObjectName();

    /**
     * @return VersionedObjectInterface
     */
    public function getObjectSerialized();

    /**
     * @return VersionedObjectInterface
     */
    public function getObjectDate();
}