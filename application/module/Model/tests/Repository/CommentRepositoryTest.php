<?php

use PHPUnit\Framework\TestCase;
use Model\Repository\CommentRepository;
use Model\Repository\CommentRepositoryInterface;
use Model\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;
use Framework\Instantiator\Instantiator;
use Doctrine\ORM\EntityManager as RealEntityManager;

class CommentRepositoryTest extends TestCase
{
    public function testCanBeCreated()
    {
        echo PHP_EOL . " -- MODEL: CommentRepository tests" . PHP_EOL;
        echo PHP_EOL . "    ---- Can be created test" . PHP_EOL;

        $repository = new CommentRepository(new EntityManager());
        $this->assertInstanceOf(
            CommentRepository::class,
            $repository
        );

        return $repository;
    }

    /**
     * @param CommentRepositoryInterface $repository
     * @depends clone testCanBeCreated
     */
    public function testCanSave($repository)
    {
        echo PHP_EOL . "    ---- Can save entity test" . PHP_EOL;
        $this->assertTrue($repository->save(new Comment()));
    }

    /**
     * @param CommentRepositoryInterface $repository
     * @depends clone testCanBeCreated
     */
    public function testCanSaveManyEntities($repository)
    {
        echo PHP_EOL . "    ---- Can save many entities test" . PHP_EOL;
        $this->assertTrue($repository->save(
            [new Comment(), new Comment(), new Comment()]
        ));
    }

    public function testCanFetchAllForList()
    {
        echo PHP_EOL . "    ---- Can fetch all for list test" . PHP_EOL;
        $instantiator = new Instantiator();
        $entityManager = $instantiator->instantiate(RealEntityManager::class);
        $repository = new CommentRepository($entityManager);
        $this->assertTrue(is_array($repository->fetchAllForList(1)));

        return $repository;
    }

    /**
     * @param CommentRepositoryInterface $repository
     * @depends testCanFetchAllForList
     */
    public function testCanCountAll($repository)
    {
        echo PHP_EOL . "    ---- Can count all test" . PHP_EOL;
        $this->assertTrue(is_numeric($repository->countAll()));
    }
}

class EntityManager implements EntityManagerInterface
{
    public function find($className, $id){}

    public function persist($object){}

    public function remove($object){}

    public function merge($object){}

    public function clear($objectName = null){}

    public function detach($object){}

    public function refresh($object){}

    public function flush()
    {
        return true;
    }

    public function getRepository($className){}

    public function getClassMetadata($className){}

    public function getMetadataFactory(){}

    public function initializeObject($obj){}

    public function contains($object){}

    public function getCache(){}

    public function getConnection(){}

    public function getExpressionBuilder(){}

    public function beginTransaction(){}

    public function transactional($func){}

    public function commit(){}

    public function rollback(){}

    public function createQuery($dql = ''){}

    public function createNamedQuery($name){}

    public function createNativeQuery($sql, ResultSetMapping $rsm){}

    public function createNamedNativeQuery($name){}

    public function createQueryBuilder(){}

    public function getReference($entityName, $id){}

    public function getPartialReference($entityName, $identifier){}

    public function close(){}

    public function copy($entity, $deep = false){}

    public function lock($entity, $lockMode, $lockVersion = null){}

    public function getEventManager(){}

    public function getConfiguration(){}

    public function isOpen(){}

    public function getUnitOfWork(){}

    public function getHydrator($hydrationMode){}

    public function newHydrator($hydrationMode){}

    public function getProxyFactory(){}

    public function getFilters(){}

    public function isFiltersStateClean(){}

    public function hasFilters(){}
}