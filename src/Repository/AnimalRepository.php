<?php

namespace App\Repository;


use App\Entity\Animal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\ClientRepository;

/**
 * @extends ServiceEntityRepository<Animal>
 *
 * @method Animal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Animal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Animal[]    findAll()
 * @method Animal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnimalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Animal::class);
    }

    public function save(Animal $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Animal $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    /**
     * @param int $clientId client dont on souhaite avoir les animaux
     * @return Animal[] retourne une liste de tout les animaux d'un client
    */
    public function getAllAnimalsByClient(int $clientId): Array 
    {
        $qb = $this->createQueryBuilder('a')
            ->innerJoin('a.client', 'c')
            ->where('c.id = :clientId')
            ->setParameter('clientId', $clientId)
            ->getQuery();

        return $qb->execute();
    }

    /**
     * @param int $veterinaireId ID du vétérinaire
     * @return Animal[] retourne tous les animaux pour un vétérinaire spécifique
     */
    public function fetchAnimalsWithExtraData(int $veterinaireId): array
    {
        $qb = $this->createQueryBuilder('a')
            ->innerJoin("a.espece", "esp")
            ->addSelect("esp")
            
            ->innerJoin("a.client", "cli")
            ->addSelect("cli")

            ->innerJoin("a.events", "ev")
            ->innerJoin("ev.veterinaire", "vet")
            ->where("vet.id = :id")
            
            ->orderBy("cli.lastname", "ASC")
            ->addOrderBy("cli.firstname", "ASC")
            ->addOrderBy("a.name", "ASC")

            ->setParameter("id", $veterinaireId)
            ->getQuery();

        return $qb->execute();
    }

        /**
     * @param int $animalId ID du vétérinaire
     * @return Animal retourne tous les animaux pour un vétérinaire spécifique
     */
    public function fetchAnimalWithExtraData(int $animalId): Animal
    {
        $qb = $this->createQueryBuilder('a')
            ->innerJoin("a.espece", "esp")
            ->addSelect("esp")

            ->where("a.id = :id")
            
            ->innerJoin("a.client", "cli")
            ->addSelect("cli")

            ->innerJoin("a.events", "ev")
            ->addSelect("ev")

            ->innerJoin("ev.veterinaire", "vet")
            ->addSelect("vet")
            
            ->orderBy("cli.lastname", "ASC")
            ->addOrderBy("cli.firstname", "ASC")
            ->addOrderBy("a.name", "ASC")

            ->setParameter("id", $animalId)
            ->getQuery();

        return $qb->getOneOrNullResult();
    }
    
//    /**
//     * @return Animal[] Returns an array of Animal objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Animal
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
