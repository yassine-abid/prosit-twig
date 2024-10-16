<?php

namespace App\Controller;

use App\Entity\Aeroport;
use App\Form\AeroportType;
use App\Repository\AeroportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AeroportController extends AbstractController
{
    #[Route('/aeroport', name: 'app_aeroport')]
    public function index(): Response
    {
        return $this->render('aeroport/index.html.twig', [
            'controller_name' => 'AeroportController',
        ]);
    }

    #[Route('/aeroport/list', name: 'aeroport_list')]
    public function list(AeroportRepository $aeroportRepository): Response
    {
        $aeroport = $aeroportRepository->findAll();
        return $this->render('aeroport/aeroportlist.html.twig', ['aeroport' => $aeroport]);
    }

    #[Route('/aeroport/update/{id}', name: 'aeroport_update')]
    public function update(int $id, Request $request, AeroportRepository $aeroportRepository, EntityManagerInterface $entityManager): Response
    {
        $aeroport = $aeroportRepository->find($id);
        if ($aeroport) {
            $form = $this->createForm(AeroportType::class, $aeroport);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->flush();
                return $this->redirectToRoute('aeroport_list');
            }
            return $this->render('aeroport/update.html.twig', [
                'form' => $form->createView(),
                'aeroport' => $aeroport,
            ]);
        }
        return $this->redirectToRoute('aeroport_list');
    }

    #[Route('/aeroport/create', name: 'aeroport_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $aeroport = new Aeroport();
        $form = $this->createForm(AeroportType::class, $aeroport);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($aeroport);
            $entityManager->flush();

            return $this->redirectToRoute('aeroport_list');
        }
        return $this->render('aeroport/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

