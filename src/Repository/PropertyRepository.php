<?php

namespace App\Repository;

use App\Entity\Property;
use App\Entity\PropertySearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Property::class);
    }


    public function findAllVisible(PropertySearch $propertySearch)
    {
        $query= $this->findVisibleQuery();
        if($propertySearch->getMaxPrice()){
            $query=$query->andWhere("p.price < :maxPrice")
                         ->setParameter("maxPrice",$propertySearch->getMaxPrice());

        }
        if($propertySearch->getMinSurface()){
            $query=$query->andWhere('p.surface >= :min')
                         ->setParameter('min',$propertySearch->getMinSurface());


        }

        return $query->getQuery();
        }
  
    public function findLatest()
    {
        return $this->findVisibleQuery()
            ->setMaxResults(4)
            ->orderBy('p.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
    private function findVisibleQuery()
    {
        return $this->createQueryBuilder('p')
            ->Where('p.sold =true');
    }        
    // /**
    //  * @return Property[] Returns an array of Property objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Property
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
