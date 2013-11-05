<?php
namespace SamVersioningTest;

use SamVersioning\Service\VersioningService;

/**
 * @coversDefaultClass \SamVersioning\Service\VersioningService
 */
class VersioningServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::__construct()
     */
    public function testConstructionWorksWithRequiredParameters()
    {
        $events        = array();
        $objectManager = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $voPrototype   = $this->getMock('SamVersioning\Entity\VersionedObject');

        $versioningService = new VersioningService(
            $objectManager,
            $voPrototype,
            $events
        );

        $this->assertInstanceOf('\SamVersioning\Service\VersioningServiceInterface', $versioningService);
    }

    /**
     * @covers ::setVersionedObjectPrototype()
     * @covers ::getVersionedObjectPrototype()
     */
    public function testObjectPrototypeCanBeOverwrittenAndRetrieved()
    {
        $events        = array();
        $objectManager = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $voPrototype   = $this->getMock('SamVersioning\Entity\VersionedObject');
        $voPrototype2  = $this->getMock('SamVersioning\Entity\VersionedObjectTwo');

        $versioningService = new VersioningService(
            $objectManager,
            $voPrototype,
            $events
        );

        $versioningService->setVersionedObjectPrototype($voPrototype2);

        $this->assertEquals($versioningService->getVersionedObjectPrototype(), $voPrototype2);
    }

    /**
     * @covers ::setEventsToVersionify()
     * @covers ::getEventsToVersionify()
     */
    public function testEventsToVerifyCanBeOverwrittenAndRetrieved()
    {
        $events        = array();
        $events2       = array('foo' => 'bar');
        $objectManager = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $voPrototype   = $this->getMock('SamVersioning\Entity\VersionedObject');

        $versioningService = new VersioningService(
            $objectManager,
            $voPrototype,
            $events
        );

        $versioningService->setEventsToVersionify($events2);

        $this->assertEquals($versioningService->getEventsToVersionify(), $events2);
    }

    /**
     * @covers ::logVersionForObject()
     */
    public function testObjectsWillBeVersionifiedAndReturnsVersionedObjectPrototype()
    {
        $events         = array();
        $testObjectMock = $this->getMock('SamVersioning\Entity\VersionedObject');
        $objectManager  = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $voPrototype    = $this->getMock('SamVersioning\Entity\VersionedObject');

        $voPrototype->expects($this->once())->method('setObjectId')->will($this->returnSelf());
        $voPrototype->expects($this->once())->method('setObjectName')->will($this->returnSelf());
        $voPrototype->expects($this->once())->method('setObjectSerialized')->will($this->returnSelf());
        $voPrototype->expects($this->once())->method('setObjectDate')->will($this->returnSelf());

        $versioningService = new VersioningService(
            $objectManager,
            $voPrototype,
            $events
        );

        $prototypeReturn = $versioningService->logVersionForObject($testObjectMock);

        $this->assertInstanceOf('\SamVersioning\Entity\VersionedObjectInterface', $prototypeReturn);
    }

    /**
     * @covers ::retrieveVersionsForObjectNameAndId()
     */
    public function testRetrieveVersionsForObjectNameAndIdReturnsArrayCollection()
    {
        $events              = array();
        $objectManager       = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $objectRepository    = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');
        $arrayCollectionMock = $this->getMock('Doctrine\Common\Collections\ArrayCollection');
        $voPrototype         = $this->getMock('SamVersioning\Entity\VersionedObject');

        $objectManager->expects($this->once())->method('getRepository')->will($this->returnValue($objectRepository));
        $objectRepository->expects($this->once())->method('findBy')->will($this->returnValue($arrayCollectionMock));

        $versioningService = new VersioningService(
            $objectManager,
            $voPrototype,
            $events
        );

        $arrayCollection = $versioningService->retrieveVersionsForObjectNameAndId('SomeObject', 1);

        $this->assertInstanceOf('\Doctrine\Common\Collections\ArrayCollection', $arrayCollection);
    }
}
