<?php
/**
 * @author    Manuel Stosic <manuel.stosic@duit.de>
 * @copyright 2013 DU-IT GmbH
 */
namespace SamVersioning\Entity;

use Doctrine\Common\Persistence\EntityRepository;

class VersionedObjectRepository extends EntityRepository
{
    public function getVersionsForObjectNameAndId($objectName, $objectId)
    {
        return $this->_em->createQuery('SELECT v FROM SamVersioning\Entity\VersionedObject v WHERE v.objectName = :objectName AND v.objectId = :objectId')
            ->setParameters(array(
                'objectName' => $objectName,
                'objectId'   => $objectId
            ))->getResult();
    }
}