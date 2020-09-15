<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\Project;
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

        return $this->render('test/list.html.twig', [
            'tests' => $tests
        ]);
    }

    public function create(Request $request)
    {

        $test = new Test();
        $customers = $this->getDoctrine()->getRepository(Customer::class)->findAll();
        $form = $this->createForm(TestType::class, $test, [
            'action' => $this->generateUrl('crear-test'),
            'method' => 'POST'
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $test->setEstado("No Iniciado");

            //GUARDA EL CLIENTE EN LA BBDD
            if (!empty($_POST["test"]["customer"])) {
                $id = $_POST["test"]["customer"];
                //exit;
                $customer = $this->getDoctrine()->getRepository(Customer::class)->find($id);
                $test->setCustomer($customer);
            } else {
                $test->setCustomer(null);
            }

            //GUARDA EL PROYECTO EN LA BBDD
            if (!empty($_POST["test"]["project"])) {
                $id = $_POST["test"]["project"];
                $project = $this->getDoctrine()->getRepository(Project::class)->find($id);
                $test->setProject($project);
            } else {
                $test->setProject(null);
            }

            $em->persist($test);
            $em->flush();

            $this->addFlash('success', 'Se ha creado correctamente el Test '.$test->getAlias());

            return $this->redirectToRoute('listar-tests');

        }

        return $this->render('test/create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function edit($id, Request $request)
    {
        $test = $this->getDoctrine()
            ->getRepository(Test::class)
            ->find($id);

        $form = $this->createForm(TestType::class, $test);
        $form->handleRequest($request);
        //var_dump($_POST);
        //exit;
        if ($form->isSubmitted() && $form->isValid()) {
            var_dump("hola");
            exit;
            $em = $this->getDoctrine()->getManager();
            //$test->setEstado($test->getEstado());

            $em->persist($test);
            $em->flush();

            $this->addFlash('success', 'Se ha editado correctamente el Test '.$test->getAlias());

            return $this->redirectToRoute('listar-tests');

        }

        return $this->render('test/edit.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
