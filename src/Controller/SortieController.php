<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\FiltreRechercheType;
use App\Form\SortieType;
use App\Form\SortieTypeAnnuler;
use App\Repository\EtatRepository;
use App\Repository\SortieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
class SortieController extends AbstractController
{
    #[Route('/', name: 'app_sortie_index', methods: ['GET','POST'])]
    public function index(SortieRepository $sortieRepository,Request $request): Response
    {
        $formFilter = $this->createForm(FiltreRechercheType::class);
        $formFilter->handleRequest($request);
        if($formFilter->isSubmitted()){
            $data = $formFilter->getData();
            $sorties = $sortieRepository->filtrerLaRecherche($data,$this->getUser());
        }else{
            $sorties =$sortieRepository->filtrerLaRecherche();
        }

        return $this->render('sortie/index.html.twig', [
            'sorties' => $sorties,
            'formFilter' => $formFilter
        ]);
    }

    #[Route('/sortie/new/', name: 'app_sortie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SortieRepository $sortieRepository,EtatRepository $etatRepository): Response
    {
        $sortie = new Sortie();
        $form = $this->createForm(SortieType::class, $sortie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//

            if($form->get('publish')->isClicked()){
                $etat =$etatRepository->findOneBy(['libelle' => 'Ouverte']);
                $sortie->setEtat($etat);
            }

            if($form->get('save')->isClicked()){
                $etat =$etatRepository->findOneBy(['libelle' => 'En création']);
                $sortie->setEtat($etat);
            }
            $sortie->setOrganisateur($this->getUser());
            $sortie->addListeInscrit($this->getUser());
            $sortie->setCampus($sortie->getOrganisateur()->getCampus());

            $sortieRepository->save($sortie, true);

            return $this->redirectToRoute('app_sortie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sortie/new.html.twig', [
            'sortie' => $sortie,
            'form' => $form,
        ]);
    }

    #[Route('/sortie/{id}', name: 'app_sortie_show', methods: ['GET'])]
    public function show(Sortie $sortie): Response
    {
        return $this->render('sortie/show.html.twig', [
            'sortie' => $sortie,
        ]);
    }

    #[Route('/sortie/{id}/edit', name: 'app_sortie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Sortie $sortie, SortieRepository $sortieRepository,EtatRepository $etatRepository): Response
    {
        //Controle si l'utilisateur connecté est bien l'organisateur de la sortie pour pouvoir la modifier
        if($this->getUser() != $sortie->getOrganisateur()){
            return $this->redirectToRoute('app_sortie_index');
        }
        $form = $this->createForm(SortieType::class, $sortie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($form->get('publish')->isClicked()){
                $etat =$etatRepository->findOneBy(['libelle' => 'Ouverte']);
//                dd($etat);
                $sortie->setEtat($etat);
            }

            if($form->get('save')->isClicked()){
                $etat =$etatRepository->findOneBy(['libelle' => 'En création']);
//                    dd($etat);
                $sortie->setEtat($etat);
            }
            $sortieRepository->save($sortie, true);

            return $this->redirectToRoute('app_sortie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sortie/edit.html.twig', [
            'sortie' => $sortie,
            'form' => $form,
        ]);
    }

    #[Route('/sortie/{id}', name: 'app_sortie_delete', methods: ['POST'])]
    public function delete(Request $request, Sortie $sortie, SortieRepository $sortieRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sortie->getId(), $request->request->get('_token'))) {
            $sortieRepository->remove($sortie, true);
        }

        return $this->redirectToRoute('app_sortie_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/sortie/inscription/{id}',name:'app_sortie_inscription')]
    public function inscription(Sortie $sortie,SortieRepository $sortieRepository): Response{
        if($sortie->getDateLimiteInscription() >= new \DateTime() and $sortie->getEtat()->getLibelle() == 'Ouverte'){
            return $this->redirectToRoute('app_sortie_index',[], Response::HTTP_SEE_OTHER);
        }
        $sortie->addListeInscrit($this->getUser());
        $sortieRepository->save($sortie,true);

        return $this->redirectToRoute('app_sortie_index', [], Response::HTTP_SEE_OTHER);

    }

    #[Route('/sortie/desinscription/{id}',name:'app_sortie_desinscription')]
    public function desinscription( Sortie $sortie,SortieRepository $sortieRepository): Response{
        if($sortie->getDateHeureDebut() >= new \DateTime()){
            return $this->redirectToRoute('app_sortie_index',[], Response::HTTP_SEE_OTHER);
        }
        $sortie->removeListeInscrit($this->getUser());
        $sortieRepository->save($sortie,true);

        return $this->redirectToRoute('app_sortie_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/sortie/annulation/{id}',name:'app_sortie_annulation')]
    public function annulation(Sortie $sortie,SortieRepository $sortieRepository, EtatRepository $etatRepository): Response{
            $sortie->setEtat($etatRepository->findOneBy(['libelle'=>'Annulée']));
            $listeParticipant =$sortie->getListeInscrits();
            foreach ($listeParticipant as $participant){
                $sortie->removeListeInscrit($participant);
            }
            $sortieRepository->save($sortie,true);
            return $this->redirectToRoute('app_sortie_index',[],Response::HTTP_SEE_OTHER);


    }

}
