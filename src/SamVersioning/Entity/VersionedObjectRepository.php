<?php
namespace SamVersioning\Entity;

use Doctrine\ORM\EntityRepository;

class VersionedObjectRepository extends EntityRepository implements VersionedObjectRepositoryInterface
{
    public function getVersionsForObjectNameAndId($objectName, $objectId)
    {
        return $this->findBy(array(
            'objectName' => $objectName,
            'objectId'   => $objectId
        ), array(
            'objectDate ASC'
        ));
    }
}
