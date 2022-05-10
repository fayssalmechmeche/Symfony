<?php

namespace App\Controller;

use App\Entity\User;

use App\Form\ChangePasswordType;
use Doctrine\DBAL\Query;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class AccountPasswordController extends AbstractController
{
    #[Route('/compte/password', name: 'app_account_password')]


    public function index(Request $request, ManagerRegistry $doctrine, UserPasswordHasherInterface $hash): Response
    {
        $notification = null;
        $cloneUser = clone $this->getUser();

        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);


        $form = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $password = $user->getPassword();

            $password = $hash->hashPassword(
                $user,
                $user->getPassword()
            );
            $user->setPassword($password);
            $entityManager = $doctrine->getManager();
            $entityManager->flush();
            $notification = "Vos données ont été mis à jour !";
        } elseif (($form->isSubmitted() && $form->isValid() == false)) {

            $notification = "Des conditions ne sont pas remplises !";
        }
        return $this->render('account/password.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification,

        ]);
    }
}
