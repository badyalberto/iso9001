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
use Dompdf\Dompdf;
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

            if (isset($_POST['desactivar'])) {
                $test->setDesactivar(true);
                $test->setEstado("Desactivado");
            } else {
                $test->setDesactivar(false);
                if ($_POST['blocks'][0]['alias'] != "" && $_POST['blocks'][0]['position'] != "" && $_POST['blocks'][0]['bloque_padre'] != "") {
                    $test->setEstado("En Curso");
                } else {
                    $test->setEstado("No Iniciado");
                }
            }

            //GUARDA EL TEST
            $em->persist($test);
            $em->flush();

            //GUARDA TODOS LOS BLOQUES DEL TEST CREADO
            if (isset($_POST['blocks']) && $_POST['blocks'][0]['alias'] != "" && $_POST['blocks'][0]['position'] != "" && $_POST['blocks'][0]['bloque_padre'] != "") {

                if (isset($_POST['desactivar'])) {
                    $test->setDesactivar(true);
                    $test->setEstado("Desactivado");
                } else {
                    $test->setDesactivar(false);
                    $test->setEstado("En Curso");
                }

                foreach ($_POST['blocks'] as $clave => $valor) {
                    $block = new Block();
                    $block->setAlias($valor['alias']);
                    $block->setPosition($valor['position']);
                    $block->setBloquePadre($valor['bloque_padre']);
                    $block->setEstado("NO INICIADO");
                    $block->setDesactivar(false);
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

        $desactivar = $test->getDesactivar();

        $blocks = $this->getDoctrine()
            ->getRepository(Block::class)
            ->findBy([
                'test' => $test
            ]);

        $form = $this->createForm(TestType::class, $test);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {


            /*echo '<pre>';
            var_dump($_POST);
            echo '</pre>';
            die();*/


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

            if (isset($_POST['desactivar'])) {
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
                    //var_dump("hola");
                    //exit;
                    $block = new Block();
                    $block->setAlias($valor['alias']);
                    $block->setPosition(intval($valor['position']));
                    if (isset($valor['bloque_padre'])) {
                        $block->setBloquePadre($valor['bloque_padre']);
                    } else {
                        $block->setBloquePadre("");
                    }

                    $block->setEstado("NO INICIADO");
                    $block->setDesactivar(false);
                    $test->setEstado('En Curso');
                    //print_r()
                    //exit;
                    $block->setTest($test);

                    //GUARDA UN BLOQUE EN CONCRETO
                    $em->persist($test);
                    $em->persist($block);
                    $em->flush();
                }
            }

            $this->addFlash('success', 'Se ha editado correctamente el Test ' . $test->getAlias());

            return $this->redirectToRoute('listar-tests');

        }

        return $this->render('test/edit.html.twig', array(
            'form' => $form->createView(),
            'blocks' => $blocks,
            'desactivar' => $desactivar
        ));
    }

    public function desactivar($id)
    {
        $test = $this->getDoctrine()
            ->getRepository(Test::class)
            ->find($id);

        $em = $this->getDoctrine()->getManager();

        $blocks = $this->getDoctrine()
            ->getRepository(Block::class)
            ->findBy([
                'test' => $test
            ]);

        $questions = [];
        $cont = 0;
        foreach ($blocks as $clave => $valor) {

            $questionsB = $this->getDoctrine()->getRepository(Question::class)->findBy([
                'block' => $valor
            ]);

            $questions[$cont] = $questionsB;
            $cont++;
        }

        if ($test->getDesactivar()) {
            $test->setDesactivar(false);
            if (!isset($questions) || empty($questions)) {
                $test->setEstado("No Iniciado");
            } else {
                $test->setEstado("En Curso");
            }
            $this->addFlash('success', 'Se ha ACTIVADO correctamente el test');
        } else {
            $test->setDesactivar(true);
            $test->setEstado("Desactivado");
            $this->addFlash('success', 'Se ha DESACTIVADO correctamente el test');
        }

        $em->persist($test);
        $em->flush();

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

        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery("SELECT a as cantidad FROM App\Entity\Block b
                                    LEFT JOIN App\Entity\Question q WITH q.block = b
                                    LEFT JOIN App\Entity\Test t WITH b.test = t
                                    LEFT JOIN App\Entity\Customer c WITH t.customer = c
                                    LEFT JOIN App\Entity\Answer a WITH a.question = q
                                    WHERE a.estado != 'DESACTIVADO'");
        //$answers = $query->getResult();

        $answers = $this->getDoctrine()->getRepository(Answer::class)->findAll();
        if (isset($_POST) && !empty($_POST) && $_POST != null && $_POST != "") {
            $em = $this->getDoctrine()->getManager();
            /*var_dump(count($_POST['question']));
            echo '<pre>';
            var_dump($_POST);
            echo '</pre>';
            die();*/
            for ($i = 0; $i < count($_POST['question']); $i++) {

                if (isset($_POST['question'][$i])) {

                    $question = $this->getDoctrine()
                        ->getRepository(Question::class)
                        ->find($_POST['question'][$i]);

                    #BUSCO SI EXISTE UNA RESPUESTA
                    $answer = $this->getDoctrine()
                        ->getRepository(Answer::class)
                        ->findBy([
                            'question' => $question
                        ]);


                    #SI NO EXISTE RESPUESTO CREO UNA DE NUEVO
                    if ($answer[0] == "" || $answer[0] == null) {
                        $answer = new Answer();
                        $answer->setQuestion($question);

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

                    } else {

                        #SI EXISTE ANSWER REESCRIBO LA ANSWER
                        $answer[0]->setQuestion($question);

                        $answer[0]->setObservaciones($_POST['observaciones'][$i]);
                        $answer[0]->setEstado($_POST['estado'][$i]);

                        $file = $_FILES['file'];

                        //SI NO INSERTA IMAGEN LE PODRA LA MISMA IMAGEN
                        if ($file['name'][$i] == "") {
                            $answer[0]->setImagen($answer[0]->getImagen());
                        } else {

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
                        }
                        //echo count($_POST['question']).' '.$i.' '.$_POST['question'][$i].' '.$_POST['observaciones'][$i].' '.$_POST['estado'][$i].' '.'<br>';
                        echo $answer[0]->getObservaciones() . ' ' . $answer[0]->getQuestion()->getId() . ' ' . $answer[0]->getEstado() . ' ' . $answer[0]->getImagen() . '<br>';

                        $em->persist($answer[0]);
                        $em->flush();
                    }
                    /*$respuestas = [];
                    $cont = 0;
                    for ($i = 0; $i < count($_POST['question']); $i++) {

                        $question = $this->getDoctrine()
                            ->getRepository(Question::class)
                            ->find($_POST['question'][$i]);

                        $answer = $this->getDoctrine()
                            ->getRepository(Answer::class)
                            ->findBy([
                                'question' => $question
                            ]);

                        $respuestas[$cont] = $answer;
                        $cont++;
                    }
                    $realizadas = 0;*/

                    /* COMPRUEBA SI LAS ANSWERS ESTAN RESPONDIDAS*/
                    /*foreach ($respuestas as $clave => $valor){
                        if($valor[0]->getEstado() == "SI" || $valor[0]->getEstado() == 'NO IMPLEMENTADA' || $valor[0]->getEstado() == "NO" || $valor[0]->getEstado() == 'DESATIVADO'){
                            $realizadas++;
                        }
                    }

                    if(count($respuestas) == $realizadas){
                        $test->setEstado("Realizado");
                    }else{*/
                    $test->setEstado("En Curso");
                    $test->setFecha(new \DateTime("now"));
                    //}


                    $em->persist($test);
                    $em->flush();
                }

            }
            //die();
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

    public function testesCompleted()
    {
        $tests = $this->getDoctrine()->getRepository(Test::class)->findAll();

        $em = $this->getDoctrine()->getManager();

        $testContados = [];
        $testok = [];
        $questionsko = [];
        $noimplementadas = [];
        $notesteados = [];
        $cont = 0;
        $cont2 = 0;
        $cont3 = 0;
        $cont4 = 0;
        $cont5 = 0;
        foreach ($tests as $clave => $valor) {
            /*ENTIDADES NO BBDD*/

            /*
             * CANTIDAD DE QUESTIONES SIN TENER EN CUENTA LA DESACTIVADAS
             */
            $query = $em->createQuery("SELECT t,count(q) as cantidad FROM App\Entity\Block b
                                    LEFT JOIN App\Entity\Question q WITH q.block = b
                                    LEFT JOIN App\Entity\Test t WITH b.test = t
                                    LEFT JOIN App\Entity\Customer c WITH t.customer = c
                                    LEFT JOIN App\Entity\Answer a WITH a.question = q
                                    WHERE t.id = :test and a.estado != 'DESACTIVADO'")
                ->setParameter('test', $valor->getId());
            $test = $query->getSingleResult();

            /*
             * CANTIDAD DE QUESTIONS CON ESTADO SI (TEST OK)
             */
            $query2 = $em->createQuery("SELECT t,count(q) as ok FROM App\Entity\Block b
                                    LEFT JOIN App\Entity\Question q WITH q.block = b
                                    LEFT JOIN App\Entity\Test t WITH b.test = t
                                    LEFT JOIN App\Entity\Customer c WITH t.customer = c
                                    LEFT JOIN App\Entity\Answer a WITH a.question = q
                                    WHERE t.id = :test and a.estado = 'SI'")
                ->setParameter('test', $valor->getId());
            $test2 = $query2->getSingleResult();

            /*
             * CANTIDAD DE QUESTIONS CON ESTADO NO (TEST KO)
             */
            $query3 = $em->createQuery("SELECT count(a) as ko FROM App\Entity\Block b
                                    LEFT JOIN App\Entity\Question q WITH q.block = b
                                    LEFT JOIN App\Entity\Test t WITH b.test = t
                                    LEFT JOIN App\Entity\Customer c WITH t.customer = c
                                    LEFT JOIN App\Entity\Answer a WITH a.question = q
                                    WHERE t.id = :test and a.estado = 'NO'")
                ->setParameter('test', $valor->getId());
            $test3 = $query3->getSingleResult();

            /*
             * CANTIDAD DE QUESTIONS CON ESTADO NO IMPLEMENTADA
             */
            $query4 = $em->createQuery("SELECT count(a) as no_implementada FROM App\Entity\Block b
                                    LEFT JOIN App\Entity\Question q WITH q.block = b
                                    LEFT JOIN App\Entity\Test t WITH b.test = t
                                    LEFT JOIN App\Entity\Customer c WITH t.customer = c
                                    LEFT JOIN App\Entity\Answer a WITH a.question = q
                                    WHERE t.id = :test and a.estado = 'NO IMPLEMENTADA'")
                ->setParameter('test', $valor->getId());
            $test4 = $query4->getSingleResult();

            /*
            * CANTIDAD DE QUESTIONS CON ESTADO NO TESTADO (CALCULO CANTIDAD DE TEST REALIZADO)
            */
            $query5 = $em->createQuery("SELECT count(a) as no_testeado FROM App\Entity\Block b
                                    LEFT JOIN App\Entity\Question q WITH q.block = b
                                    LEFT JOIN App\Entity\Test t WITH b.test = t
                                    LEFT JOIN App\Entity\Customer c WITH t.customer = c
                                    LEFT JOIN App\Entity\Answer a WITH a.question = q
                                    WHERE t.id = :test and a.estado = 'NO TESTADO' and a.estado != 'DESACTIVADO'")
                ->setParameter('test', $valor->getId());
            $test5 = $query5->getSingleResult();

            $testContados[$cont] = $test;
            $testok[$cont2] = $test2;
            $questionsko[$cont3] = $test3;
            $noimplementadas[$cont4] = $test4;
            $notesteados[$cont5] = $test5;
            $cont++;
            $cont2++;
            $cont3++;
            $cont4++;
            $cont5++;
        }

        /*for ($i = 0; $i < count($testContados); $i++) {
            echo $testContados[$i][0].'<br>'; //. ' Tests realizados: ' . intval($testContados[$i][0]['cantidad']) . ' Respuestas correctas: '.$testok[$i][0]['ok'].'<br>'; //. round((intval($testok[$i][0]['ok']) * 100 )/ intval($testContados[$i][0]['alias'])) . '<br>';

        }*/

        //echo json_encode($testContados);

        return $this->render('test/testscompleted.html.twig', [
            'testscontados' => $testContados,
            'testok' => $testok,
            'questions' => $questionsko,
            'noimplementadas' => $noimplementadas,
            'notesteados' => $notesteados
        ]);
    }

    public function pdf($id)
    {
        $dompdf = new Dompdf();

        $test = $this->getDoctrine()
            ->getRepository(Test::class)
            ->find($id);

        $opciones = $dompdf->getOptions();
        $opciones->setIsHtml5ParserEnabled(true);
        $dompdf->setOptions($opciones);
        $dompdf->loadHtml($test->getAlias());

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream();

    }

}
