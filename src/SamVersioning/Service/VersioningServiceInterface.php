<?php
/**
 * @author    Manuel Stosic <manuel.stosic@duit.de>
 * @copyright 2013 DU-IT GmbH
 */
namespace SamVersioning\Service;

use SamVersioning\Entity\VersionedObjectInterface;

interface VersioningServiceInterface
{
    /**
     * @param object $object
     * @return VersionedObjectInterface
     */
    public function logVersionForObject($object);
}