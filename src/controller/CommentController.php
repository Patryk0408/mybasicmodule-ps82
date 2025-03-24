<?php

namespace MyBasicModule\Controller;

use Dom\Comment;
use MyBasicModule\Form\CommentType;
use MyBasicModule\Entity\CommentTest;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends FrameworkBundleAdminController
{
    public function indexAction(Request $request)
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

    public function listAction()
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

    public function updateAction(int $id, Request $request) {
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
}
