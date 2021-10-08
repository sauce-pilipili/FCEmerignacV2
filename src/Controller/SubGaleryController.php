<?php

namespace App\Controller;

use App\Entity\SubGalery;
use App\Form\SubGaleryType;
use App\Repository\GaleryRepository;
use App\Repository\SubGaleryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sub/galery")
 */
class SubGaleryController extends AbstractController
{
    /**
     * @Route("/", name="sub_galery_index", methods={"GET"})
     */
    public function index(SubGaleryRepository $subGaleryRepository): Response
    {
        return $this->render('sub_galery/index.html.twig', [
            'sub_galeries' => $subGaleryRepository->findAllSubGalery(),
        ]);
    }

    /**
     * @Route("/new{id}", name="sub_galery_new", methods={"GET","POST"})
     */
    public function new(Request $request, $id, GaleryRepository $galeryRepository): Response
    {
        $subGalery = new SubGalery();
        $form = $this->createForm(SubGaleryType::class, $subGalery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $subGalery->setCreatedDate(new \DateTime('now'));
            $galery = $galeryRepository->find($id);
            $subGalery->setGalery($galery);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($subGalery);
            $entityManager->flush();

            return $this->redirectToRoute('galery_show', ['id'=>$id], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sub_galery/new.html.twig', [
            'sub_galery' => $subGalery,
            'id'=>$id,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="sub_galery_show", methods={"GET"})
     */
    public function show(SubGalery $subGalery,SubGaleryRepository $subGaleryRepository): Response
    {
        $subGalerie = $subGaleryRepository->ShowSubGalery($subGalery->getId());
        return $this->render('sub_galery/show.html.twig', [
            'sub_galery' => $subGalerie,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sub_galery_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SubGalery $subGalery): Response
    {
        $form = $this->createForm(SubGaleryType::class, $subGalery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('galery_show', ['id'=> $subGalery->getGalery()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sub_galery/edit.html.twig', [
            'sub_galery' => $subGalery,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="sub_galery_delete", methods={"POST"})
     */
    public function delete(Request $request, SubGalery $subGalery): Response
    {
        if ($this->isCsrfTokenValid('delete'.$subGalery->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($subGalery);
            $entityManager->flush();
        }

        return $this->redirectToRoute('galery_show', ['id'=>$subGalery->getGalery()->getId()], Response::HTTP_SEE_OTHER);
    }
}
