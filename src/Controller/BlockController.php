<?php

namespace App\Controller;

use App\Entity\Block;
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

    public function list($id)
    {
        $test = $this->getDoctrine()->getRepository(Test::class)->findBy($id);
        $blocks = $this->getDoctrine()->getRepository(Block::class)->findAll();

        return $this->render('block/list.html.twig', [
            'blocks' => $blocks
        ]);
    }

    public function create(Request $request)
    {
        $block = new Block();

        $alias = $request->request->get('alias', NULL);
        $position = $request->request->get('position', NULL);
        $padre = $request->request->get('padre', NULL);

        $block->setAlias($alias);
        $block->setPosition($position);
        $block->setBloquePadre($padre);
        $block->setEstado("No realizada");

        $em = $this->getDoctrine()->getManager();

        $em->persist($block);
        $em->flush();

        $array = array();
        $array['alias'] = $block->getAlias();
        $array['position'] = $block->getPosition();
        $array['padre'] = $block->getBloquePadre();
        $array['estado'] = $block->getEstado();

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
}
