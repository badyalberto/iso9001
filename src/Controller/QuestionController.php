<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Block;
use App\Entity\Question;
use App\Entity\Test;
use App\Form\QuestionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DomCrawler\Image;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\FileUploader;


class QuestionController extends AbstractController
{

    public function index()
    {
        return $this->render('question/index.html.twig', [
            'controller_name' => 'QuestionController',
        ]);
    }

    public function create($id, Request $request, FileUploader $fileUploader)
    {

        $block = $this->getDoctrine()->getRepository(Block::class)->find($id);

        $question = new Question();

        $form = $this->createForm(QuestionType::class, $question, [
            'action' => $this->generateUrl('crear-pregunta', array('id' => $block->getId())),
            'method' => 'POST'
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $cont = 0;

            if (isset($_POST['questions']) && !empty($_POST['questions'])) {

                foreach ($_POST['questions'] as $valor) {
                    $question2 = new Question();
                    $question2->setDescription($valor['description']);
                    $question2->setObservaciones($valor['observaciones']);

                    if (isset($_POST['desactivar'])) {
                        $question2->setDesactivar(true);
                    } else {
                        $question2->setDesactivar(false);
                    }

                    $question2->setBlock($block);

                    $file = $_FILES['questions'];
                    $ruta = $file['tmp_name'][$cont]['image'];
                    $type = $file['type'][$cont]['image'];

                    if ($ruta != "" && $ruta != null) {
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
                        $question2->setImagen($filename);
                    }
                    $block->setEstado("EN CURSO");
                    //$block->getTest()->setEstado("En Curso");

                    $answer = new Answer();
                    $answer->setObservaciones("");
                    $answer->setImagen("");
                    $answer->setEstado("NO TESTEADO");
                    $answer->setQuestion($question2);

                    $em->persist($answer);
                    $em->persist($question2);
                    $em->persist($block);
                    $em->flush();
                    $cont++;
                }
                $this->addFlash('success', 'Se han creado correctamente!');
            } else {
                $this->addFlash('danger', 'No se ha podido crear la pregunta!');
            }
            return $this->redirectToRoute('ver-preguntas-bloque', ['id' => $block->getId()]);
        }

        return $this->render('question/create.html.twig', array(
            'form' => $form->createView(),
            'block' => $block

        ));

    }

    public function listQuestionsBlock($id)
    {
        //BUSCO EL TEST
        $test = $this->getDoctrine()
            ->getRepository(Test::class)
            ->find($id);

        //BUSCOS LOS BLOQUES DE ESE TEST
        $blocks = $this->getDoctrine()->getRepository(Block::class)->findBy([
            'test' => $test
        ]);

        $answers = $this->getDoctrine()
            ->getRepository(Answer::class)
            ->findAll();

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

        return $this->render('question/list.html.twig', [
            'blocks' => $blocks,
            'test' => $test,
            'questions' => $questions,
            'answers' => $answers
        ]);
    }

    public function desactivar($id, $q_tests)
    {
        $em = $this->getDoctrine()->getManager();

        $question = $this->getDoctrine()
            ->getRepository(Question::class)
            ->find($id);

        $answer = $this->getDoctrine()
            ->getRepository(Answer::class)
            ->findOneBy([
                'question' => $question
            ]);


        if ($question->getDesactivar()) {

            $question->setDesactivar(false);
            $answer->setEstado("NO TESTEADO");
            $this->addFlash('success', 'Se ha ACTIVADO correctamente la question');
        } else {
            $question->setDesactivar(true);
            $answer->setEstado("DESACTIVADO");
            $this->addFlash('success', 'Se ha DESACTIVADO correctamente la question');
        }
        $em->persist($answer);
        $em->persist($question);
        $em->flush();

        //BUSCO EL ID DEL BLOQUE DE LA QUESTION
        $query = $em->createQuery("SELECT IDENTITY(q.block) FROM App\Entity\Question q
                                    WHERE q = (:q)")
            ->setParameter('q', $question);
        $block = $query->getResult();

        $block = $this->getDoctrine()
            ->getRepository(Block::class)
            ->find($block[0][1]);

        $cont = 0;

        //MIRO SI TODOS LAS QUESTIONES DEL BLOCK ESTAN DESACTIVADAS
        foreach ($block->getQuestions() as $clave => $valor) {
            if ($valor->getDesactivar() == true) {
                $cont++;
            }
        }

        //SI TODAS LAS QUESTIONES ESTAN DESACTIVADAS EL BLOQUE ESTARA DESACTIVADO
        if ($cont == count($block->getQuestions())) {
            $block->setEstado("DESACTIVADO");
            $block->setDesactivar(true);
        } else {
            $block->setEstado("EN CURSO");
            $block->setDesactivar(false);
        }
        $em->persist($block);
        $em->flush();

        if ($q_tests == 1) {
            return $this->redirectToRoute('listar-preguntas-blocks', ['id' => $question->getBlock()->getTest()->getId()]);
        } else {
            return $this->redirectToRoute('ver-preguntas-bloque', ['id' => $question->getBlock()->getId()]);
        }
    }

    public function edit($id, Request $request, FileUploader $fileUploader)
    {

        $question = $this->getDoctrine()
            ->getRepository(Question::class)
            ->find($id);

        $desactivar = $question->getDesactivar();

        $form = $this->createForm(QuestionType::class, $question, [
            'action' => $this->generateUrl('edit-question', array('id' => $question->getId())),
            'method' => 'POST'
        ]);

        $oldFileName = $question->getImagen();
        $oldFileNamePath = $fileUploader->getTargetDirectory() . $oldFileName;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            if(isset($_POST['description'])){

                $question->setDescription($_POST['description']);
            }else{
                $this->addFlash('danger', 'NO se ha podido editar la pregunta ');

                return $this->redirectToRoute('listar-preguntas-blocks', ['id' => $question->getBlock()->getTest()->getId()]);
            }

            if (isset($_POST['desactivar'])) {
                $question->setDesactivar(true);
            } else {
                $question->setDesactivar(false);
            }

            if (isset($_FILES['image'])) {
                $file = $_FILES['image'];

                if ($file['name'] != "") {

                    $ruta = $file['tmp_name'];
                    $type = $file['type'];

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
                    $question->setImagen($filename);

                    //ELIMINA LA IMAGEN ANTIGUA SI HAY ALGUNA
                    if ($oldFileName != null) {
                        $fileUploader->delete($oldFileNamePath);
                    }
                }
            } else {
                $question->setImagen($oldFileName);
            }

            $em->persist($question);
            $em->flush();

            $this->addFlash('success', 'Se ha editado correctamente la pregunta ');

            return $this->redirectToRoute('listar-preguntas-blocks', ['id' => $question->getBlock()->getTest()->getId()]);

        }

        return $this->render('question/edit.html.twig', array(
            'form' => $form->createView(),
            'question' => $question,
            'desactivar' => $desactivar
        ));
    }
}
