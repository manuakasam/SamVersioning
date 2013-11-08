<?php
namespace SamVersioningTest\Entity;

use SamVersioning\Entity\VersionedObject;

/**
 * @coversDefaultClass \SamVersioning\Entity\VersionedObject
 */
class VersionedObjectTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::setId
     * @covers ::setObjectid
     * @covers ::setObjectName
     * @covers ::setObjectSerialized
     * @covers ::setObjectDate
     * @covers ::getId
     * @covers ::getObjectid
     * @covers ::getObjectName
     * @covers ::getObjectSerialized
     * @covers ::getObjectDate
     */
    public function testSettersAndGettersDefinedByInterface()
    {
        $checkData = array(
            'id' => 1,
            'objectId' => 2,
            'objectName' => 'test',
            'objectSerialized' => 's:4:"test"',
            'objectDate' => new \DateTime('now')
        );

        $versionedObject = new VersionedObject();
        $versionedObject->setId($checkData['id']);
        $versionedObject->setObjectId($checkData['objectId']);
        $versionedObject->setObjectName($checkData['objectName']);
        $versionedObject->setObjectSerialized($checkData['objectSerialized']);
        $versionedObject->setObjectDate($checkData['objectDate']);

        $this->assertEquals($versionedObject->getId(), $checkData['id']);
        $this->assertEquals($versionedObject->getObjectId(), $checkData['objectId']);
        $this->assertEquals($versionedObject->getObjectName(), $checkData['objectName']);
        $this->assertEquals($versionedObject->getObjectSerialized(), $checkData['objectSerialized']);
        $this->assertEquals($versionedObject->getObjectDate(), $checkData['objectDate']);
    }

    /**
     * @covers ::setId
     * @covers ::setObjectid
     * @covers ::setObjectName
     * @covers ::setObjectSerialized
     * @covers ::setObjectDate
     */
    public function testFluentInterfaceOfSetters()
    {
        $versionedObject = new VersionedObject();

        $this->assertInstanceOf('SamVersioning\Entity\VersionedObjectInterface',
            $versionedObject->setId(1));
        $this->assertInstanceOf('SamVersioning\Entity\VersionedObjectInterface',
            $versionedObject->setObjectId(1));
        $this->assertInstanceOf('SamVersioning\Entity\VersionedObjectInterface',
            $versionedObject->setObjectName('test'));
        $this->assertInstanceOf('SamVersioning\Entity\VersionedObjectInterface',
            $versionedObject->setObjectSerialized('test'));
        $this->assertInstanceOf('SamVersioning\Entity\VersionedObjectInterface',
            $versionedObject->setObjectDate(new \DateTime('now')));
    }
}
