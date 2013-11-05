<?php
/**
 * @author    Manuel Stosic <manuel.stosic@duit.de>
 * @copyright 2013 DU-IT GmbH
 */
namespace SamVersioning\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class VersionedObject
 *
 * @package SamVersioning\Entity
 * @ORM\Entity
 * @ORM\Table(name="sam_versioned_objects", indexes={
 * @ORM\Index(name="search_idx", columns={
 *     "object_name", "object_id", "object_date"
 *   })
 * })
 */
class VersionedObject implements VersionedObjectInterface
{
    /**
     * Primary Key
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var int
     * @access protected
     */
    protected $id;

    /**
     * @ORM\Column(name="object_id", type="integer", nullable=false)
     * @var int
     * @access protected
     */
    protected $objectId;

    /**
     * @ORM\Column(name="object_name", type="string", nullable=false)
     * @var string
     * @access protected
     */
    protected $objectName;

    /**
     * @ORM\Column(name="object_serialized", type="text", nullable=false)
     * @var string
     * @access protected
     */
    protected $objectSerialized;

    /**
     * @ORM\Column(name="object_date", type="datetime", nullable=false)
     * @var \DateTime
     * @access protected
     */
    protected $objectDate;

    /**
     * @param mixed $id
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \DateTime $objectDate
     * @return self
     */
    public function setObjectDate(\DateTime $objectDate)
    {
        $this->objectDate = $objectDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getObjectDate()
    {
        return $this->objectDate;
    }

    /**
     * @param mixed $objectId
     * @return self
     */
    public function setObjectId($objectId)
    {
        $this->objectId = $objectId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getObjectId()
    {
        return $this->objectId;
    }

    /**
     * @param mixed $objectName
     * @return self
     */
    public function setObjectName($objectName)
    {
        $this->objectName = $objectName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getObjectName()
    {
        return $this->objectName;
    }

    /**
     * @param mixed $objectSerialized
     * @return self
     */
    public function setObjectSerialized($objectSerialized)
    {
        $this->objectSerialized = $objectSerialized;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getObjectSerialized()
    {
        return $this->objectSerialized;
    }
}