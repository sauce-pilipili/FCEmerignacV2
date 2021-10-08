<?php

namespace App\Controller;

use App\Entity\Albums;
use App\Entity\Photo;
use App\Form\AlbumsType;
use App\Repository\AlbumsRepository;
use App\Repository\SubGaleryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/albums")
 */
class AlbumsController extends AbstractController
{
    /**
     * @Route("/", name="albums_index", methods={"GET"})
     */
    public function index(AlbumsRepository $albumsRepository): Response
    {
        return $this->render('albums/index.html.twig', [
            'albums' => $albumsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new{id}", name="albums_new", methods={"GET","POST"})
     */
    public function new(Request $request ,SubGaleryRepository $subGaleryRepository,$id): Response
    {
        $album = new Albums();
        $form = $this->createForm(AlbumsType::class, $album);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $sousGalery = $subGaleryRepository->find($id);
            $album->setsubGalery($sousGalery);

            $images = $form->get('images')->getData();
            foreach ($images as $image) {
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                // On crée l'image dans la base de données
                $img = new Photo();
                $img->setName($fichier);
                $album->addImage($img);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($album);
            $entityManager->flush();

            return $this->redirectToRoute('sub_galery_show', ['id'=>$id], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('albums/new.html.twig', [
            'album' => $album,
            'form' => $form,
            'id'=>$id
        ]);
    }

    /**
     * @Route("/{id}", name="albums_show", methods={"GET"})
     */
    public function show(Albums $album, AlbumsRepository $albumsRepository): Response
    {
        $albums = $albumsRepository->findAlbums($album->getId());
        return $this->render('albums/show.html.twig', [
            'album' => $albums,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="albums_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Albums $album): Response
    {
        $form = $this->createForm(AlbumsType::class, $album);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('images')->getData() != null) {
                $images = $form->get('images')->getData();

                foreach ($images as $image) {
                    // On génère un nouveau nom de fichier
                    $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                    // On copie le fichier dans le dossier uploads
                    $image->move(
                        $this->getParameter('images_directory'),
                        $fichier
                    );
                    // On crée l'image dans la base de données
                    $img = new Photo();
                    $img->setName($fichier);
                    $album->addImage($img);
                }
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sub_galery_show', ['id' => $album->getSubGalery()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('albums/edit.html.twig', [
            'album' => $album,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="albums_delete", methods={"POST"})
     */
    public function delete(Request $request, Albums $album): Response
    {
        if ($this->isCsrfTokenValid('delete'.$album->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($album);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sub_galery_show', ['id' => $album->getSubGalery()->getId()], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/supprime/photo/{id}", name="albums_delete_image", methods={"DELETE"})
     */
    public function deleteImage(Photo $image, Request $request)
    {
        $data = json_decode($request->getContent(), true);
        // On vérifie si le token est valide

        if ($this->isCsrfTokenValid('delete' . $image->getId(), $data['_token'])) {
            // On récupère le nom de l'image
            $nom = $image->getName();
            // On supprime le fichier
            unlink($this->getParameter('images_directory') . '/' . $nom);
            // On supprime l'entrée de la base
            $em = $this->getDoctrine()->getManager();
            $em->remove($image);
            $em->flush();

            // On répond en json
            return new JsonResponse(['success' => 1]);
        } else {
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }
    }
}
