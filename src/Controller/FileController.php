<?php

namespace App\Controller;

use App\Entity\File;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as BaseController; // Renommez la classe ici


class FileController extends AbstractController
{
    /**
     * @Route("/download/{id}", name="download_existing_file")
     */
    public function downloadFile(int $id)
    {
        // Récupérez le fichier à partir de la base de données ou de votre système de stockage
        $entityManager = $this->getDoctrine()->getManager();
        $file = $entityManager->getRepository(File::class)->find($id);
        // Assurez-vous que le fichier existe
        if (!$file) {
            throw $this->createNotFoundException('Le fichier demandé n\'existe pas.');
        }

        // Récupérez le chemin du fichier
        $filePath = $file->getFilePath(); // Assurez-vous d'adapter ceci à votre propre logique

        // Créez une réponse de téléchargement binaire pour le fichier
        $response = new BinaryFileResponse($filePath);

        // Configurez le nom de fichier suggéré pour le téléchargement
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $file->getFileName() // Nom du fichier à afficher lors du téléchargement
        );

        return $response;
    }
}
