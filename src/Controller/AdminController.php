<?php

namespace App\Controller;

use App\Form\EditProfilType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/profil", name="profil")
     */
    public function profil(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $form = $this->createForm(EditProfilType::class, $user);
        $form->handleRequest($request);
        if ($request->isMethod('POST')&&$request->request->get('pass')!=null &&$request->request->get('pass2')!=null ){
            if ($request->request->get('pass')== $request->request->get('pass2')){
            $user->setPassword($passwordEncoder->encodePassword($user,$request->request->get('pass')));
            $em->flush();
            $this->addFlash('profilsuccess','mot de passe mis a jour.');
            }else{
                $this->addFlash('profildanger',' les mots de passe ne correspondent pas.');
            }
        }
        if ($form->isSubmitted()&& $form->isValid()){

            $em->persist($user);
            $em->flush();
            $this->addFlash('profilmailsuccess', 'Profil mis a jour');

            return $this->redirectToRoute('profil');
        }
        return $this->render('admin/profil.html.twig', [
            'form'=>$form->createView(),
        ]);
    }
}
