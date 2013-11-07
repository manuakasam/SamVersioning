<?php
/**
 * @author    Manuel Stosic <manuel.stosic@duit.de>
 * @copyright 2013 DU-IT GmbH
 */
namespace SamVersioning\Entity;

interface VersionedObjectRepositoryInterface
{
    /**
     * @param string  $objectName
     * @param integer $objectId
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getVersionsForObjectNameAndId($objectName, $objectId);
}
