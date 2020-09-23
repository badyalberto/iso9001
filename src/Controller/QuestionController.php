<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Block;
use App\Entity\Question;
use App\Entity\Test;
use App\Form\QuestionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
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

            /*$question2 = new Question();
            $question2->setDescription($_POST['question']['description']);
            $question2->setObservaciones($_POST['question']['observaciones']);
            $question2->setEstado("NO TESTADO");

            if (isset($valor['desactivar'])) {
                $question2->setDesactivar(1);
            } else {
                $question2->setDesactivar(0);
            }

            $question2->setBlock($block);

            $brochureFile = $form->get('imagen')->getData();

            if ($brochureFile instanceof UploadedFile) {

                $brochureFileName = $fileUploader->upload($brochureFile);
                $question2->setImagen($brochureFileName);

                $em->persist($question2);
                $em->flush();
            }*/
            $cont = 0;
            foreach ($_POST['questions'] as $valor) {

                $question2 = new Question();
                $question2->setDescription($valor['description']);
                $question2->setObservaciones($valor['observaciones']);

                if (isset($valor['desactivar'])) {
                    $question2->setDesactivar(1);
                } else {
                    $question2->setDesactivar(0);
                }

                $question2->setBlock($block);

                $file = $_FILES['questions'];
                $ruta = $file['tmp_name'][$cont]['imagen'];
                $type = $file['type'][$cont]['imagen'];

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

                $em->persist($question2);
                $em->flush();
                $cont++;
            }

            $this->addFlash('success', 'Se han creado correctamente!');

            return $this->redirectToRoute('listar-preguntas-blocks', ['id' => $block->getTest()->getId()]);

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
            'questions' => $questions
        ]);
    }

    public function desactivar($id)
    {
        $question = $this->getDoctrine()
            ->getRepository(Question::class)
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        if ($question->getDesactivar()) {
            $question->setDesactivar(false);
            $question->setEstado("NO TESTADO");
        }
        {
            $question->setDesactivar(true);
            $question->setEstado("DESACTIVADO");
        }

        $em->persist($question);
        $em->flush();

        $this->addFlash('success', 'Se ha desactivado correctamente la question');

        return $this->redirectToRoute('listar-preguntas-blocks', ['id' => $question->getBlock()->getTest()->getId()]);

    }
}
