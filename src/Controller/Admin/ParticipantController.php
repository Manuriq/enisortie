<?php

namespace App\Controller\Admin;

use App\Entity\Participant;
use App\Form\Participant1Type;
use App\Repository\ParticipantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/participant')]
class ParticipantController extends AbstractController
{
    #[Route('/', name: 'app_admin_participant_index', methods: ['GET'])]
    public function index(ParticipantRepository $participantRepository): Response
    {
        return $this->render('admin/participant/index.html.twig', [
            'participants' => $participantRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_participant_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ParticipantRepository $participantRepository): Response
    {
        $participant = new Participant();
        $form = $this->createForm(Participant1Type::class, $participant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $participantRepository->save($participant, true);

            return $this->redirectToRoute('app_admin_participant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/participant/new.html.twig', [
            'participant' => $participant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_participant_show', methods: ['GET'])]
    public function show(Participant $participant): Response
    {
        return $this->render('admin/participant/show.html.twig', [
            'participant' => $participant,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_participant_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Participant $participant, ParticipantRepository $participantRepository): Response
    {
        $form = $this->createForm(Participant1Type::class, $participant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $participantRepository->save($participant, true);

            return $this->redirectToRoute('app_admin_participant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/participant/edit.html.twig', [
            'participant' => $participant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_participant_delete', methods: ['POST'])]
    public function delete(Request $request, Participant $participant, ParticipantRepository $participantRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$participant->getId(), $request->request->get('_token'))) {
            $participantRepository->remove($participant, true);
        }

        return $this->redirectToRoute('app_admin_participant_index', [], Response::HTTP_SEE_OTHER);
    }

    // Passer un utilisateur admin
    #[Route('/adminstate/{id}', name: 'app_admin_participant_edit_adminstate', methods: ['GET'])]
    public function edit_adminstate(Participant $participant, ParticipantRepository $participantRepository): Response
    {
        if($participant->getAdministrateur()){
            $participant->setAdministrateur(0);
        }else{
            $participant->setAdministrateur(1);
        }
        $participantRepository->save($participant, true);
        return $this->redirectToRoute('app_admin_participant_index', [], Response::HTTP_SEE_OTHER);
    }
}
