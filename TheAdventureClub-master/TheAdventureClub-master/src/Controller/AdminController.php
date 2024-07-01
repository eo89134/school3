<?php

namespace App\Controller;

use App\Entity\Story;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $allStories = $entityManager->getRepository(Story::class)->findAll();
        return $this->render('admin/index.html.twig', [
            'stories' =>$allStories,
        ]);
    }
    #[Route('/admin/delete/{id}', name: 'app_delete')]
    public function delete(EntityManagerInterface $entityManager, int $id): Response
    {
        $delete = $entityManager->getRepository(Story::class)->find($id);

        $entityManager->remove($delete);
        $entityManager->flush();

        $this->addFlash('success', 'story is verwijderd !');
        //dd($u
        return $this->redirectToRoute('app_admin');
    }
}
