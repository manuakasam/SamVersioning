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
     * @return self
     */
    public function setId($id);

    /**
     * @param $objectId
     * @return self
     */
    public function setObjectId($objectId);

    /**
     * @param $objectName
     * @return self
     */
    public function setObjectName($objectName);

    /**
     * @param $objectSerialized
     * @return self
     */
    public function setObjectSerialized($objectSerialized);

    /**
     * @param \DateTime $objectDate
     * @return self
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