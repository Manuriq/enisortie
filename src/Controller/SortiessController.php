<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\SortieType;
use App\Repository\SortieRepository;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class SortiessController extends AbstractController
{
    #[Route('/listeSorties', name: 'app_sortie')]
    public function index(EntityManagerInterface $entityManager): JsonResponse
    {
        $queryBuilder = $entityManager->createQueryBuilder();
        $queryBuilder->select('s')
            ->from(Sortie::class,'s');
        $query = $queryBuilder->getQuery();

        $sorties = $query->getResult();
        dd($sorties);

        //TODO: à vérifier

        return new JsonResponse($sorties);
    }

    #[Route('/createSortie',name:'app_createSortie')]
    public function createSortie(SortieRepository $sortieRepository,VilleRepository $villeRepository,Request $request,EntityManagerInterface $em) : Response{
        $sortie = new Sortie();
        $sortieForm = $this->createForm(SortieType::class, $sortie);


        $sortieForm->handleRequest($request);
        if($sortieForm->isSubmitted()){
            dd($sortie);
            $em->persist($sortie);
            $em->flush();

            return $this->redirectToRoute('app_home');
        }


        $villes = $villeRepository->findAll();
        return $this->render('sortie/createSortie.html.twig',[
            'sortieForm' => $sortieForm->createView(),
            'villes'=> $villes
        ]);
    }
}
