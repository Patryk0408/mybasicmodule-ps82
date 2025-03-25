<?php

namespace MyBasicModule\Controller;

use MyBasicModule\Form\CommentType;
use MyBasicModule\Entity\CommentTest;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends FrameworkBundleAdminController
{
    public function indexAction(Request $request): Response
    {
        $form = $this->createForm(CommentType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $commentTest = new CommentTest();

            $commentTest->setName($form->get('name')->getData());
            $commentTest->setDescription($form->get('description')->getData());
            $commentTest->setPrice($form->get('price')->getData());

            $em->persist($commentTest);
            $em->flush();

            $this->addFlash('success', 'Product added');
        }

        return $this->render(
            "@Modules/mybasicmodule/views/templates/admin/comment.html.twig",
            [
                'test' => 'Hello World testpk',
                'form' => $form->createView()
            ]
        );
    }

    public function listAction(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(CommentTest::class)->findAll();

        return $this->render(
            "@Modules/mybasicmodule/views/templates/admin/list.html.twig",
            [
                'data' => $data,
            ]
        );
    }

    public function updateAction(int $id, Request $request): Response 
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(CommentTest::class)->find($id);
        $form = $this->createForm(CommentType::class, $data);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('success', 'Product added');
        }

        return $this->render(
            "@Modules/mybasicmodule/views/templates/admin/update.html.twig",
            [
                'form' => $form->createView()
            ]
        );
    }

    public function deleteAction(int $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(CommentTest::class)->find($id);

        if (!$data) {
            $this->addFlash('error', 'Entry not found');
            return $this->redirectToRoute('blog_list'); 
        }
        $em->remove($data);
        $em->flush();

        $this->addFlash('success', 'Entry deleted successfully');

        return $this->redirectToRoute('blog_list'); 
    }
}
