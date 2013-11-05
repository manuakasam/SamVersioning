<?php
namespace SamVersioningTest;

use SamVersioning\Entity\VersionedObjectRepository;

/**
 * Class VersionedObjectRepositoryTest
 * @package SamVersioningTest
 * @coversBaseClass \SamVersioning\Entity\VersionedObjectRepository
 */
class VersionedObjectRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::getVersionsForObjectNameAndId
     */
    public function testGetVersionsForObjectNameAndIdReturnsArrayCollection()
    {
        $arrayCollectionMock = $this->getMock('Doctrine\Common\Collections\ArrayCollection');

        $persisterMock = $this->getMockBuilder('Doctrine\ORM\Persisters\BasicEntityPersister')
            ->disableOriginalConstructor()
            ->getMock();

        $persisterMock->expects($this->once())
            ->method('loadAll')
            ->will($this->returnValue($arrayCollectionMock));

        $unitOfWorkMock = $this->getMockBuilder('Doctrine\ORM\UnitOfWork')
            ->disableOriginalConstructor()
            ->getMock();

        $unitOfWorkMock->expects($this->once())
            ->method('getEntityPersister')
            ->will($this->returnValue($persisterMock));

        $entityManagerMock = $this->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();

        $entityManagerMock->expects($this->once())
            ->method('getUnitOfWork')
            ->will($this->returnValue($unitOfWorkMock));

        $classMetadataMock = $this->getMockBuilder('Doctrine\ORM\Mapping\ClassMetadata')
            ->disableOriginalConstructor()
            ->getMock();

        $testRepository          = new VersionedObjectRepository($entityManagerMock, $classMetadataMock);
        $shouldBeArrayCollection = $testRepository->getVersionsForObjectNameAndId('test', 1);

        $this->assertInstanceOf('\Doctrine\Common\Collections\ArrayCollection', $shouldBeArrayCollection);
    }
}
