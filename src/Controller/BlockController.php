<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Block;
use App\Entity\Question;
use App\Entity\Test;
use App\Form\BlockType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BlockController extends AbstractController
{

    public function index()
    {
        return $this->render('block/index.html.twig', [
            'controller_name' => 'BlockController',
        ]);
    }

    public function create(Request $request)
    {
        $alias = $request->request->get('alias', NULL);
        $position = $request->request->get('position', NULL);
        $padre = $request->request->get('padre', NULL);

        $array = array();

        if($alias != null || $position != null || $padre != null) {

            $block = new Block();
            $block->setAlias($alias);
            $block->setPosition($position);
            $block->setBloquePadre($padre);
            $block->setDesactivar(false);
            $block->setEstado("NO INICIADO");

            $em = $this->getDoctrine()->getManager();

            $em->persist($block);
            $em->flush();

            /*$test = $block->getTest();
            var_dump($test->getId());
            exit;
            $test->setEstado('En Curso');

            $em->persist($test);
            $em->flush();*/

            $array['alias'] = $block->getAlias();
            $array['position'] = $block->getPosition();
            $array['padre'] = $block->getBloquePadre();
            $array['estado'] = $block->getEstado();
        }

        return new JsonResponse($array);

    }
    public function blocks()
    {
        $blocks = $this->getDoctrine()
            ->getRepository(Block::class)
            ->findBy([
                'test' => null
            ]);

        //SI ESTA VACIA NO HAY BLOQUES CON TESTS EN NULL
        if (empty($blocks)) {
            return new JsonResponse(true);
        } else {
            return new JsonResponse(false);
        }
    }

    public function desactivar($id)
    {
        $block = $this->getDoctrine()
            ->getRepository(Block::class)
            ->find($id);

        $questions = $this->getDoctrine()
            ->getRepository(Question::class)
            ->findBy([
                'block' => $block
            ]);

        $em = $this->getDoctrine()->getManager();

        if ($block->getDesactivar()) {
            $block->setDesactivar(false);
            if(!isset($questions) || empty($questions) ){
                $block->setEstado("NO INICIADO");
            }else{
                $block->setEstado("EN CURSO");
            }
            $this->addFlash('success', 'Se ha ACTIVADO correctamente el bloque');
        } else {
            $block->setDesactivar(true);
            $block->setEstado("DESACTIVADO");
            $this->addFlash('success', 'Se ha DESACTIVADO correctamente el bloque');
        }

        $em->persist($block);
        $em->flush();

        return $this->redirectToRoute('editar-test',['id' => $block->getTest()->getId()]);
    }

    public function listBlockQuestions($id){
        $block = $this->getDoctrine()
            ->getRepository(Block::class)
            ->find($id);

        $answers = $this->getDoctrine()
            ->getRepository(Answer::class)
            ->findAll();

        if(isset($block) && !empty($block)){
            $questions = $this->getDoctrine()
                ->getRepository(Question::class)
                ->findBy([
                    'block' => $block
                ]);
        }

        return $this->render('block/questionlist.html.twig', [
            'block' => $block,
            'questions' => $questions,
            'answers' => $answers
        ]);
    }

    public function edit($id,Request $request){

        $block = $this->getDoctrine()
            ->getRepository(Block::class)
            ->find($id);

        $desactivar = $block->getDesactivar();

        $form = $this->createForm(BlockType::class, $block, [
            'action' => $this->generateUrl('edit-block', array('id' => $block->getId())),
            'method' => 'POST'
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            if (isset($_POST['desactivar'])) {
                $block->setDesactivar(true);
            } else {
                $block->setDesactivar(false);
            }

            $em->persist($block);
            $em->flush();

            $this->addFlash('success', 'Se ha editado correctamente el bloque');

            return $this->redirectToRoute('editar-test', ['id' => $block->getTest()->getId()]);
        }

        return $this->render('block/edit.html.twig', array(
            'form' => $form->createView(),
            'block' => $block,
            'desactivar' => $desactivar
        ));
    }
}
