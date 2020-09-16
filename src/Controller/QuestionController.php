<?php

namespace App\Controller;

use App\Entity\Block;
use App\Entity\Question;
use App\Entity\Test;
use App\Form\QuestionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{

    public function index()
    {
        return $this->render('question/index.html.twig', [
            'controller_name' => 'QuestionController',
        ]);
    }

    public function create($id, Request $request)
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

            //echo '<pre>' . var_export($_POST, true) . '</pre>';
            //exit;
            //var_dump($_POST);
            //exit;

            for ($i = 0; $i < count($_POST['questions']); $i++) {
                $question2 = new Question();
                $question2->setDescription($_POST['questions'][$i]['description']);
                $question2->setObservaciones($_POST['questions'][$i]['observaciones']);
                $question2->setEstado("NO TESTADO");
                if (isset($valor['desactivar'])) {
                    $question2->setDesactivar($_POST['questions'][$i]['desactivar']);
                } else {
                    $question2->setDesactivar(0);
                }
                $question2->setBlock($block);

                $brochureFile = $form->get('imagen')->getData();

                // this condition is needed because the 'brochure' field is not required
                // so the PDF file must be processed only when a file is uploaded
                if ($brochureFile) {
                    $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                    // this is needed to safely include the file name as part of the URL
                    $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                    $newFilename = $safeFilename . '-' . uniqid() . '.' . $brochureFile->guessExtension();

                    // Move the file to the directory where brochures are stored
                    try {
                        $brochureFile->move(
                            $this->getParameter('images_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                    }

                    // updates the 'brochureFilename' property to store the PDF file name
                    // instead of its contents
                    $question->setImagen($newFilename);
                }

                $em->persist($question2);
                $em->flush();
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
