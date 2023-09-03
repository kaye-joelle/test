<?php

// src/Controller/UserDeleteController.php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;

class UserDeleteController extends AbstractController
{
    
    #[Route("/utilisateur/supprimer", name: "user.delete.confirm")]
    
    public function confirmDelete()
    {
        return $this->render('user/delete_confirm.html.twig');
    }

    
    #[Route("/utilisateur/supprimer/execute", name: "user.delete.execute")]

    public function executeDelete(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = $this->getUser(); // Récupérez l'utilisateur actuellement connecté

        // Vérifiez si le formulaire de confirmation a été soumis
        if ($request->isMethod('POST')) {
            // Vérifiez le mot de passe de confirmation
            $submittedPassword = $request->request->get('password'); // Remplacez 'password' par le nom de votre champ de mot de passe
            if ($passwordEncoder->isPasswordValid($user, $submittedPassword)) {
                // Supprimez l'utilisateur de la base de données
                $entityManager->remove($user);
                $entityManager->flush();

                // Déconnectez l'utilisateur
                $this->get('security.token_storage')->setToken(null);
                $this->get('session')->invalidate();

                // Redirigez vers une page de confirmation ou la page d'accueil
                return $this->redirectToRoute('home'); // Remplacez 'home' par la route que vous souhaitez rediriger
            } else {
                $this->addFlash('danger', 'Mot de passe incorrect. Veuillez réessayer.');
            }
        }

        // Redirigez vers la page de confirmation
        return $this->redirectToRoute('user.delete.confirm');
    }

    // La méthode deleteUser() précédemment définie a été supprimée
}
