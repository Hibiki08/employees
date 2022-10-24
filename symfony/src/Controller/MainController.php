<?php

namespace App\Controller;

use App\Form\ImportFormType;
use App\Service\Import\ImportService;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    private ImportService $importService;

    public function __construct(ImportService $importService)
    {
        $this->importService = $importService;
    }

    #[Route('/')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(ImportFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->importFile($form->get('file')->getData());
                $this->addFlash('success', 'File was imported successfully!');
                return $this->redirectToRoute('app_main_index');
            } catch (\Exception $e) {
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('main/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function importFile(UploadedFile $uploadedFile)
    {
        try {
            $this->importService->setUploadedFile($uploadedFile);
            $this->importService->import();
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
}
