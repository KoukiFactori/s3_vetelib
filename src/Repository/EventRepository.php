<?php

namespace App\Repository;

use App\Entity\Event;
use App\Entity\Veterinaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr;
use Doctrine\Persistence\ManagerRegistry;
use app\Entity\Animal;

/**
 * @extends ServiceEntityRepository<Event>
 *
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function save(Event $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Event $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findEventByAnimal(Animal $animal)
{
    $qb = $this->createQueryBuilder('a');

    $qb
        ->where('a.animal = :animal')
        ->orderBy("a.date", 'ASC')
        ->setParameter('animal', $animal)
    ;

    return $qb->getQuery()->getResult();
}


    /**
     * Récupère tous les events entre deux dates
     * 
     * @return Event[]
     */
    public function getVeterinaireEventsBetween(int $vetoId, \DateTimeInterface $start, \DateTimeInterface $end): array
    {
        return $this->createQueryBuilder('event')
        ->where('event.date BETWEEN :start and :end')
        ->andWhere('event.veterinaire = :vetoId')
        ->setParameter('start', $start->format('Y-m-d H:i:s'))
        ->setParameter('end', $end->format('Y-m-d H:i:s'))
        ->setParameter('vetoId', $vetoId)
        ->getQuery()
        ->getResult();
    }
    
    /*
     * @param integer $veterinaireId
     * @return Event[]
     */
    public function fetchEventsByVeterinaire(int $veterinaireId): array
    {
        $query = $this->createQueryBuilder("ev")
            ->innerJoin("ev.responsable", "vet")
            ->where("vet.id = :id")
            ->orderBy("ev.id")
            ->getQuery();

        return $query->execute(["id" => $veterinaireId]);
    }

    /**
     * @param integer $veterinaireId
     * @return Event[]
     */
    public function fetchEventsAllDataByVeterinaire(int $veterinaireId): array {
        $query = $this->createQueryBuilder("ev")
            ->innerJoin("ev.animal", "ani")
            ->addSelect("ani as animal")

            ->innerJoin("ani.espece", "esp")
            ->addSelect("esp as espece")

            ->innerJoin("ani.client", "cli")
            ->addSelect("cli as client")

            ->innerJoin("ev.responsable", "vet")
            ->addSelect("vet as veterinaire")
            
            ->where("vet.id = :id")
            ->getQuery();

        return $query->execute(["id" => $veterinaireId]);
    }

    /**
     * @param integer $eventId
     * @return Event
     */
    public function fetchEventAllData(int $eventId) {
        $query = $this->createQueryBuilder("ev")
            ->where("ev.id = :id")

            ->innerJoin("ev.animal", "ani")
            ->addSelect("ani as animal")

            ->innerJoin("ani.espece", "esp")
            ->addSelect("esp as espece")

            ->innerJoin("ani.client", "cli")
            ->addSelect("cli as client")
            
            ->setParameter('id', $eventId)
            ->getQuery();

        return $query->setMaxResults(1)->getOneOrNullResult();
    }

//    /**
//     * @return Event[] Returns an array of Event objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Event
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
