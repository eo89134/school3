<?php

namespace App\Controller;

use App\Entity\Story;
use App\Entity\User;
use App\Form\StoryType;
use App\Repository\StoryRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MemberController extends AbstractController
{
    #[Route('/member/home/', name: 'app_member')]
    public function index(): Response
    {
        $stories = $this->getUser()->getStories();
        //dd($u
        return $this->render('member/index.html.twig', [
            'stories' =>$stories,
        ]);
    }
    #[Route('/member/addstory', name: 'app_addstory')]
    public function member(Request $request, EntityManagerInterface $entityManager): Response
    {
        $story = new Story();
        $form = $this->createForm(StoryType::class, $story);
        $form->handleRequest($request);
        //dd($form);
        if ($form->isSubmitted() && $form->isValid()) {
            $task= $form->getData();
            $task->setUser($this->getUser());
            $entityManager->persist($story);
            $entityManager->flush();
            $this->addFlash('success', 'story is toegevoegd !');


            return $this->redirectToRoute('app_member');
        }

        //dd($user);
        return $this->renderForm('member/addstory.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/member/update/{id}', name: 'app_update')]
    public function update(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {

        $story = $entityManager->getRepository(Story::class)->find($id);
        $form = $this->createForm(StoryType::class, $story);
        $form->handleRequest($request);
        //dd($form);
        if ($form->isSubmitted() && $form->isValid()) {
            $task= $form->getData();
            $task->setUser($this->getUser());
            $entityManager->persist($story);
            $entityManager->flush();
            $this->addFlash('success', 'story is geupdate !');


            return $this->redirectToRoute('app_member');
        }
        //dd($u
        return $this->renderForm('member/update.html.twig', [
            'form' =>$form,
        ]);
    }
}
