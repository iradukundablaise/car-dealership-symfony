<?php

namespace App\Repository;

use App\Entity\Car;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * @extends ServiceEntityRepository<Car>
 *
 * @method Car|null find($id, $lockMode = null, $lockVersion = null)
 * @method Car|null findOneBy(array $criteria, array $orderBy = null)
 * @method Car[]    findAll()
 * @method Car[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class
CarRepository extends ServiceEntityRepository
{
    private PaginatorInterface $paginator;

    public function __construct(
        ManagerRegistry $registry,
        PaginatorInterface $paginator
    )

    {
        parent::__construct($registry, Car::class);
        $this->paginator = $paginator;
    }

    public function save(Car $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Car $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByName(string $name): array
    {
        return $this->createQueryBuilder('c')
            ->where('c.name LIKE :name')
            ->setParameter('name', "%$name%")
            ->getQuery()
            ->getResult();
    }

    public function findByPaginated($conditions, $page = 1){
        $queryBuilder = $this->createQueryBuilder('c');
        foreach($conditions as $key => $value){
            $queryBuilder->where("c.$key = :$key");
            $queryBuilder->setParameter($key, $value);
        }

        $queryBuilder->orderBy('c.id', 'DESC');

        return $this->paginator->paginate(
            $queryBuilder->getQuery(),
            $page ?? 1,
            20
        );

    }
    public function findAllPaginated(
        $page = 1
    ): PaginationInterface
    {
        $query = $this->createQueryBuilder('c')
            ->orderBy('c.id', 'DESC')
            ->getQuery();
        return $this->paginator->paginate(
            $query,
            $page ?? 1,
            20
        );
    }
}
