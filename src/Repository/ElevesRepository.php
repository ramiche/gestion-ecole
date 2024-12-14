<?php

namespace App\Repository;

use App\Entity\Eleves;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
// src/Repository/EleveRepository.php

/**
 * @extends ServiceEntityRepository<Eleves>
 *
 * @method Eleves|null find($id, $lockMode = null, $lockVersion = null)
 * @method Eleves|null findOneBy(array $criteria, array $orderBy = null)
 * @method Eleves[]    findAll()
 * @method Eleves[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ElevesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Eleves::class);
    }

    public function save(Eleves $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Eleves $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function findElevesAvecMoyenneSuperieureA(float $seuil): array
{
    return $this->createQueryBuilder('e')
        ->andWhere('e.moyenne > :seuil')
        ->setParameter('seuil', $seuil)
        ->getQuery()
        ->getResult();
}


// src/Repository/EleveRepository.php

public function getPourcentageElevesAvecMoyenneParClasse(): array
{
    $qb = $this->createQueryBuilder('e')
        ->select('c.nom AS classe', 'COUNT(e.id) AS totalEleves', 
                 'SUM(CASE WHEN e.moyenne >= 10 THEN 1 ELSE 0 END) AS elevesAvecMoyenne')
        ->innerJoin('e.classe', 'c') // Assurez-vous que la relation entre Élève et Classe est bien configurée
        ->groupBy('c.id')
        ->orderBy('c.nom', 'ASC');

    $results = $qb->getQuery()->getResult();

    // Calculer le pourcentage pour chaque classe
    foreach ($results as &$result) {
        $result['pourcentage'] = $result['totalEleves'] > 0 
            ? round(($result['elevesAvecMoyenne'] / $result['totalEleves']) * 100, 2)
            : 0;
    }

    return $results;
}



//    /**
//     * @return Eleves[] Returns an array of Eleves objects
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

//    public function findOneBySomeField($value): ?Eleves
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
