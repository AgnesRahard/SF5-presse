<?php

namespace App\Controller;

use App\Entity\Cahier;
use App\Form\CahierType;
use App\Repository\CahierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cahier")
 */
class CahierController extends AbstractController
{
    /**
     * @Route("/", name="cahier_index", methods={"GET"})
     */
    public function index(CahierRepository $cahierRepository): Response
    {
        return $this->render('cahier/index.html.twig', [
            'cahiers' => $cahierRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="cahier_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $cahier = new Cahier();
        $form = $this->createForm(CahierType::class, $cahier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cahier);
            $entityManager->flush();

            return $this->redirectToRoute('cahier_index');
        }

        return $this->render('cahier/new.html.twig', [
            'cahier' => $cahier,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cahier_show", methods={"GET"})
     */
    public function show(Cahier $cahier): Response
    {
        return $this->render('cahier/show.html.twig', [
            'cahier' => $cahier,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="cahier_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Cahier $cahier): Response
    {
        $form = $this->createForm(CahierType::class, $cahier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cahier_index');
        }

        return $this->render('cahier/edit.html.twig', [
            'cahier' => $cahier,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cahier_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Cahier $cahier): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cahier->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($cahier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cahier_index');
    }
}
