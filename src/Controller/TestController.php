<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Block;
use App\Entity\Customer;
use App\Entity\Project;
use App\Entity\Question;
use App\Entity\Test;
use App\Form\AnswerType;
use App\Form\BlockTestType;
use App\Form\BlockType;
use App\Form\QuestionTestType;
use App\Form\QuestionType;
use App\Form\TestType;
use App\Service\FileUploader;
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
        if ($this->getUser()->getRoles()[0] == "ROLE_WIP") {
            $tests = $this->getDoctrine()->getRepository(Test::class)->findAll();
            return $this->render('test/list.html.twig', [
                'tests' => $tests
            ]);
        } else {

            $projects = $this->getUser()->getProjects2();
            $tests2 = [];
            $cont = 0;
            foreach ($projects as $clave => $valor) {

                $testsB = $this->getDoctrine()->getRepository(Test::class)->findBy([
                    'project' => $valor
                ]);

                $tests2[$cont] = $testsB;
                $cont++;
            }
            return $this->render('test/list.html.twig', [
                'tests2' => $tests2
            ]);
        }
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

            if (isset($_POST['blocks']) && $_POST['blocks'][0]['alias'] != "" && $_POST['blocks'][0]['position'] != "" && $_POST['blocks'][0]['bloque_padre'] != "") {
                foreach ($_POST['blocks'] as $clave => $valor) {

                    $block = new Block();
                    $block->setAlias($valor['alias']);
                    $block->setPosition(intval($valor['position']));
                    if (isset($valor['bloque_padre'])) {
                        $block->setBloquePadre($valor['bloque_padre']);
                    } else {
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

    public function realizeTest($id, FileUploader $fileUploader)
    {
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

        $answers = $this->getDoctrine()->getRepository(Answer::class)->findAll();

        if (isset($_POST) && !empty($_POST) && $_POST != null && $_POST != "") {
            var_dump("hola");
            exit;

            $em = $this->getDoctrine()->getManager();

            for ($i = 0; $i < count($_POST['question']); $i++) {

                $question = $this->getDoctrine()
                    ->getRepository(Question::class)
                    ->find($_POST['question'][$i]);

                #BUSCO SI EXISTE UNA RESPUESTA
                $answer = $this->getDoctrine()
                    ->getRepository(Answer::class)
                    ->findBy([
                        'question' => $question
                    ]);

                /*'<pre>';
                var_dump($answer[0]->getId());
                exit;*/

                #SINO EXISTE RESPUESTO CREO UNA DE NUEVO
                if ($answer[0] == "" || $answer[0] == null) {
                    $answer = new Answer();
                    $answer->setQuestion($question);

                    /* '<pre>';
                    *var_dump($_POST['observaciones'][$i]);
                     exit;*/
                    $answer->setObservaciones($_POST['observaciones'][$i]);
                    $answer->setEstado($_POST['estado'][$i]);

                    $file = $_FILES['file'];
                    $ruta = $file['tmp_name'][$i];
                    $type = $file['type'][$i];

                    if ($type == "image/png") {
                        $extension = ".png";
                    } elseif ($type = "image/jpeg") {
                        $extension = ".jpeg";
                    } else {
                        $extension = ".jpg";
                    }

                    //CREA EL NUEVO NOMBRE DE LA IMAGEN
                    $filename = md5(uniqid()) . $extension;

                    //MUEVE LA IMAGEN A LA RUTA COMO SEGUNDO PARAMETRO
                    move_uploaded_file($ruta, $fileUploader->getTargetDirectory() . $filename);

                    $answer->setImagen($filename);

                    $em->persist($answer);
                    $em->flush();
                    #SI EXISTE ANSWER REESCRIBO LA ANSWER
                } else {
                    $answer[0]->setQuestion($question);

                    /* '<pre>';
                    *var_dump($_POST['observaciones'][$i]);
                     exit;*/
                    $answer[0]->setObservaciones($_POST['observaciones'][$i]);
                    $answer[0]->setEstado($_POST['estado'][$i]);

                    $file = $_FILES['file'];
                    $ruta = $file['tmp_name'][$i];
                    $type = $file['type'][$i];

                    if ($type == "image/png") {
                        $extension = ".png";
                    } elseif ($type = "image/jpeg") {
                        $extension = ".jpeg";
                    } else {
                        $extension = ".jpg";
                    }

                    //CREA EL NUEVO NOMBRE DE LA IMAGEN
                    $filename = md5(uniqid()) . $extension;

                    //MUEVE LA IMAGEN A LA RUTA COMO SEGUNDO PARAMETRO
                    move_uploaded_file($ruta, $fileUploader->getTargetDirectory() . $filename);

                    $answer[0]->setImagen($filename);

                    $em->persist($answer[0]);
                    $em->flush();
                }
            }

            $this->addFlash('success', 'Se ha realizado correctamente el Test ');

            return $this->redirectToRoute('listar-tests');
        }

        return $this->render('test/realize.html.twig', array(
            //'form' => $form->createView(),
            'test' => $test,
            'blocks' => $blocks,
            'questions' => $questions,
            'answers' => $answers
        ));
    }

}
