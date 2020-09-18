<?php

namespace App\Controller;

use App\Entity\Block;
use App\Entity\Customer;
use App\Entity\Project;
use App\Entity\Question;
use App\Entity\Test;
use App\Form\QuestionType;
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
            //print_r($_POST);
            //exit;
            //GUARDA TODOS LOS BLOQUES DEL TEST CREADO
            if (isset($_POST['blocks']) && $_POST['blocks'][0]['alias'] != "" && $_POST['blocks'][0]['position'] != "" && $_POST['blocks'][0]['padre'] != "") {
                foreach ($_POST['blocks'] as $clave => $valor) {

                    $block = new Block();
                    $block->setAlias($valor['alias']);
                    $block->setPosition($valor['position']);
                    $block->setBloquePadre($valor['padre']);
                    $block->setEstado("No realizada");
                    //var_dump($test->getAlias());
                    //exit;
                    $block->setTest($test);

                    //GUARDA UN BLOQUE EN CONCRETO
                    $em->persist($block);
                    $em->flush();
                }
            }

            $this->addFlash('success', 'Se ha creado correctamente el Test ' . $test->getAlias());

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

            //print_r($_POST);
            //exit;

            if (isset($_POST['blocks'])  && $_POST['blocks'][0]['alias'] != "" && $_POST['blocks'][0]['position'] != "" && $_POST['blocks'][0]['bloque_padre'] != "") {
                foreach ($_POST['blocks'] as $clave => $valor) {

                    $block = new Block();
                    $block->setAlias($valor['alias']);
                    $block->setPosition(intval($valor['position']));
                    if(isset($valor['bloque_padre'])){
                        $block->setBloquePadre($valor['bloque_padre']);
                    }else{
                        $block->setBloquePadre("");
                    }

                    $block->setEstado("No realizada");
                    //print_r()
                    //exit;
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

    public function realizeTest($id, Request $request){

        //BUSCO EL TEST
        $test = $this->getDoctrine()
            ->getRepository(Test::class)
            ->find($id);

        //BUSCOS LOS BLOQUES DE ESE TEST
        $blocks = $this->getDoctrine()->getRepository(Block::class)->findBy([
            'test' => $test
        ]);

        //BUSCO LAS PREGUNTAS DE CADA BLOQUE DEL TEST
        $questions = [];
        $cont = 0;
        foreach ($blocks as $clave => $valor) {

            $questionsB = $this->getDoctrine()->getRepository(Question::class)->findBy([
                'block' => $valor
            ]);

            $questions[$cont] = $questionsB;
            $cont++;
        }

        $question = new Question();

        $form = $this->createForm(QuestionType::class, $question, [
            'action' => $this->generateUrl('realizar-test', array('id' => $test->getId())),
            'method' => 'POST'
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($question);
            $em->flush();

            $this->addFlash('success', 'Se ha realizado correctamente el Test ');

            return $this->redirectToRoute('listar-tests');

        }

        return $this->render('test/realize.html.twig', array(
            'form' => $form->createView(),
            'test' => $test,
            'blocks' => $blocks,
            'questions' => $questions
        ));
    }
}
