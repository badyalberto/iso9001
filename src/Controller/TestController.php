<?php

namespace App\Controller;

use App\Entity\Block;
use App\Entity\Customer;
use App\Entity\Project;
use App\Entity\Test;
use App\Form\TestType;
use phpDocumentor\Reflection\DocBlock;
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
        $form = $this->createForm(TestType::class, $test, [
            'action' => $this->generateUrl('crear-test'),
            'method' => 'POST'
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            //echo '<pre>' . var_export($_POST, true) . '</pre>';
            //var_dump($_POST['blocks'][0]["alias"]);
            //exit;
            $test->setEstado("No Iniciado");


            //GUARDA EL CLIENTE EN LA BBDD
            if (!empty($_POST["test"]["customer"])) {
                $id = $_POST["test"]["customer"];
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

            if (isset($_POST['test']['desactivar'])) {
                $test->setDesactivar(true);
                $test->setEstado("Desactivado");
            } else {
                $test->setDesactivar(false);
                $test->setEstado("No Iniciado");
            }

            //GUARDA EL TEST
            $em->persist($test);
            $em->flush();

            //GUARDA TODOS LOS BLOQUES DEL TEST CREADO
            if (isset($_POST['blocks']) && empty($_POST['blocks'])) {
                foreach ($_POST['blocks'] as $clave => $valor) {
                    //var_dump($valor['position']);
                    //exit;
                    $block = new Block();
                    $block->setAlias($valor['alias']);
                    $block->setPosition($valor['position']);
                    $block->setBloquePadre($valor['padre']);
                    $block->setEstado("No realizada");

                    $block->setTest($test);

                    //GUARDA UN BLOQUE EN CONCRETO
                    $em->persist($block);
                    $em->flush();
                }
            }

            $this->addFlash('success', 'Se ha creado correctamente el Test ' . $test->getAlias());

            return $this->redirectToRoute('listar-tests-questions');

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

        //POR SI NO SE MODIFICA EL CAMPO PROYECTO
        $proyecto = $test->getProject();

        $blocks = $this->getDoctrine()
            ->getRepository(Block::class)
            ->findBy([
                'test' => $test
            ]);

        $form = $this->createForm(TestType::class, $test);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            //var_dump($_POST);
            //exit;
            $em = $this->getDoctrine()->getManager();

            //GUARDA EL CLIENTE EN LA BBDD
            if (!empty($_POST["test"]["customer"])) {
                $id = $_POST["test"]["customer"];
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
                $test->setProject($proyecto);
            }

            if (isset($_POST['test']['desactivar'])) {
                $test->setDesactivar(true);
                $test->setEstado("Desactivado");
            } else {
                $test->setDesactivar(false);
                $test->setEstado("No Iniciado");
            }

            $em->persist($test);
            $em->flush();

            if (isset($_POST['blocks']) && empty($_POST['blocks'])) {
                foreach ($_POST['blocks'] as $clave => $valor) {

                    $block = new Block();
                    $block->setAlias($valor['alias']);
                    $block->setPosition($valor['position']);
                    $block->setBloquePadre($valor['padre']);
                    $block->setEstado("No realizada");

                    $block->setTest($test);

                    //GUARDA UN BLOQUE EN CONCRETO
                    $em->persist($block);
                    $em->flush();
                }
            }

            $this->addFlash('success', 'Se ha editado correctamente el Test ' . $test->getAlias());

            return $this->redirectToRoute('listar-tests');

        }

        return $this->render('test/edit.html.twig', array(
            'form' => $form->createView(),
            'blocks' => $blocks
        ));
    }

    public function desactivar($id)
    {
        $test = $this->getDoctrine()
            ->getRepository(Test::class)
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $test->setDesactivar(true);
        $test->setEstado("Desactivado");
        $em->persist($test);
        $em->flush();

        $this->addFlash('success', 'Se ha desactivado correctamente el Test ' . $test->getAlias());

        return $this->redirectToRoute('listar-tests');

    }
}
