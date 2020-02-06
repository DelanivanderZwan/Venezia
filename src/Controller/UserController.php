<?php

namespace App\Controller;

use App\Entity\Fruit;
use App\Entity\Ijsrecept;
use App\Entity\User;
use App\Form\FruitType;
use App\Form\IjsreceptType;
use App\Form\RegistrationType;
use App\Repository\FruitRepository;
use App\Repository\IjsreceptRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class UserController extends AbstractController
{
    /**
     * @Route("/", name="Home")
     */
    public function HomepageAction()
    {
        return $this->render('user/index.html.twig');
    }

    /**
     * @Route("/Contact", name="Contact")
     */
    public function ContactpageAction()
    {
        return $this->render('user/contact.html.twig');
    }

    /**
     * @Route("/ReceptenOverzicht", name="receptoverzicht")
     */
    public function ReceptOverzichtShow(IjsreceptRepository $ijsreceptRepository)
    {
        return $this->render('user/receptenoverzicht.html.twig', [
            'ijsrecept' => $ijsreceptRepository->findAll(),
        ]);
    }

    /**
     * @Route("/Recepttoevoegen", name="recepttoevoegen")
     */
    public function RecepttoevoegenAction(Request $request)
    {
        $ijsrecept = new Ijsrecept();

        $form = $this->createForm(IjsreceptType::class. $ijsrecept);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ijsrecept);
            $entityManager->flush();

            return $this->redirectToRoute('receptoverzicht');
        }
        return $this->render('user/recepttoevoegen.html.twig');
    }

    /**
     * @Route("/Fruitlijst", name="Fruitlijst")
     */
    public function FruitlijstAction()
    {
        return $this->render('user/fruitlijst.html.twig');
    }

    /**
     * @Route("/FruitToevoegen", name="fruittoevoegen")
     */
    public function fruittoevoegenAction(Request $request)
    {
        $fruit = new Fruit();

        $form = $this->createForm(FruitType::class, $fruit);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($fruit);
            $entityManager->flush();

            return $this->redirectToRoute('Home');
        }

        return $this->render('user/fruitadd.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }

    /**
     * @Route("/registration", name="registration")
     */


    public function RegistrationAction(Request $request, UserPasswordEncoderInterface $passwordEncoder):Response
    {
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $form->getData();
            $user = $form->getData();
            $user->setRoles(['ROLE_USER']);
            $user->setPassword($passwordEncoder->encodePassword($user, $user->getPassword()));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('Home');
        }

        return $this->render('user/registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
