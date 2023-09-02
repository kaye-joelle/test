<?php

namespace App\Controller;
use App\Entity\File; // Assurez-vous d'importer la classe File
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

class DownloadController extends AbstractController
{
    #[Route('/download/{id}', name: 'download_existing_file')]
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
