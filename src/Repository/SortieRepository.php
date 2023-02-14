<?php

namespace App\Repository;

use App\Entity\Participant;
use App\Entity\Sortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sortie>
 *
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }

    public function save(Sortie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Sortie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function filtrerLaRecherche(mixed $data = null, $user = null)
    {
        $queryBuilder = $this->createQueryBuilder('s');

        if($data){
            if($data['campus']){
                $queryBuilder->andWhere('s.campus = :campus');
                $queryBuilder->setParameter('campus', $data['campus']);
            }

            if($data['nom']){
                $queryBuilder->andWhere('s.nom LIKE :nom');
                $queryBuilder->setParameter('nom', '%'.$data['nom'].'%');
            }

            if($data['dateDebut']){
                $queryBuilder->andWhere('s.dateHeureDebut >= :dateDebut');
                $queryBuilder->setParameter('dateDebut', $data['dateDebut']);
            }

            if($data['dateFin']){
                $queryBuilder->andWhere('s.dateHeureDebut <= :dateFin');
                $queryBuilder->setParameter('dateFin', $data['dateFin']);
            }

            if($data['checkOrganisateur'] ){
                $queryBuilder->andWhere('s.organisateur = :userConnnecte');
                $queryBuilder->setParameter('userConnnecte',$user );
            }

            if($data['checkSortiesInscrit']){
                $queryBuilder->join('s.listeInscrits','u');
                $queryBuilder->andWhere(':userConnecte  MEMBER OF s.listeInscrits')->setParameter(':userConnecte',$user);
            }

            if($data['checkSortiesNonInscrit']){
                $queryBuilder->leftJoin('s.listeInscrits','us');
                $queryBuilder->andWhere(' :userConnecte NOT MEMBER OF s.listeInscrits')->setParameter(':userConnecte',$user);
            }

            if($data['checkSortiesPassees'] ){
                $queryBuilder->andWhere('s.dateHeureDebut < :checkSortiesPassees');
                $queryBuilder->setParameter('checkSortiesPassees', new \DateTime());
            }
        }

        $query = $queryBuilder->getQuery();
        return $query->getResult();
    }
}
