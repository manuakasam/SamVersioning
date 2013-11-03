<?php
namespace SamVersioningTest;

use SamVersioning\Service\VersioningService;

class VersioningServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructionFailsWithoutRequiredParameters()
    {
        $this->setExpectedException('PHPUnit_Framework_Error');

        $versioningService = new VersioningService();
    }

    public function testConstructionWorksWithRequiredParameters()
    {
        $objectManager = $this->getMock('\Doctrine\Common\Persistence\ObjectManager');
        $voPrototype   = $this->getMock('\SamVersioning\Entity\VersionedObject');
        $events        = array();

        $versioningService = new VersioningService(
            $objectManager,
            $voPrototype,
            $events
        );

        $this->assertInstanceOf('\SamVersioning\Service\VersioningServiceInterface', $versioningService);
    }

    public function testObjectPrototypeCanBeOverwrittenAndRetrieved()
    {
        $objectManager = $this->getMock('\Doctrine\Common\Persistence\ObjectManager');
        $voPrototype   = $this->getMock('\SamVersioning\Entity\VersionedObject');
        $voPrototype2  = $this->getMock('\SamVersioning\Entity\VersionedObjectTwo');
        $events        = array();

        $versioningService = new VersioningService(
            $objectManager,
            $voPrototype,
            $events
        );

        $versioningService->setVersionedObjectPrototype($voPrototype2);

        $this->assertEquals($versioningService->getVersionedObjectPrototype(), $voPrototype2);
    }

    public function testEventsToVerifyCanBeOverwrittenAndRetrieved()
    {
        $objectManager = $this->getMock('\Doctrine\Common\Persistence\ObjectManager');
        $voPrototype   = $this->getMock('\SamVersioning\Entity\VersionedObject');
        $events        = array();
        $events2       = array('foo' => 'bar');

        $versioningService = new VersioningService(
            $objectManager,
            $voPrototype,
            $events
        );

        $versioningService->setEventsToVersionify($events2);

        $this->assertEquals($versioningService->getEventsToVersionify(), $events2);
    }

    public function testObjectsWillBeVersionifiedAndReturnsVersionedObjectPrototype()
    {
        $testObjectMock = $this->getMock('\SamVersioning\Entity\VersionedObject');
        $testObjectMock->expects($this->any())
            ->method('setObjectId')
            ->will($this->returnValue($testObjectMock));
        $testObjectMock->expects($this->any())
            ->method('getId')
            ->will($this->returnValue('1'));

        $objectManager = $this->getMock('\Doctrine\Common\Persistence\ObjectManager');
        $voPrototype   = $this->getMock('\SamVersioning\Entity\VersionedObject');
        $events        = array();

        $versioningService = new VersioningService(
            $objectManager,
            $voPrototype,
            $events
        );

        $prototypeReturn = $versioningService->logVersionForObject($testObjectMock);

        $this->assertInstanceOf('\SamVersioning\Entity\VersionedObjectInterface', $prototypeReturn);
    }
}
