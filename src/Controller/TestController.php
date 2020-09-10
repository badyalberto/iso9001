<?php

namespace App\Controller;

use App\Entity\Test;
use App\Form\TestType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class TestController extends AbstractController
{

    public function index()
    {
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }

    public function list()
    {
        $tests = $this->getDoctrine()->getRepository(Test::class)->findAll();

        return $this->render('Test/list.html.twig', [
            'tests' => $tests
        ]);
    }

    public function create(Request $request, UserPasswordEncoderInterface $encoder)
    {

        $test = new Test();
        $form = $this->createForm(TestType::class, $test, [
            'action' => $this->generateUrl('crear-test'),
            'method' => 'POST'
        ]);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $encoded = $encoder->encodePassword($test, $test->getPassword());
            $test->setPassword($encoded);

            $em->persist($test);
            $em->flush();

            return $this->redirectToRoute('listar-tests');

        }

        return $this->render('test/create.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
