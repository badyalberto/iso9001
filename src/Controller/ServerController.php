<?php

namespace App\Controller;


use App\Entity\Server;
use App\Form\ServerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ServerController extends AbstractController
{

    public function index()
    {
        return $this->render('server/index.html.twig', [
            'controller_name' => 'ServerController',
        ]);
    }

    public function list()
    {
        $servers = $this->getDoctrine()->getRepository(Server::class)->findAll();

        return $this->render('server/list.html.twig', [
            'servers' => $servers
        ]);
    }

    public function create(Request $request)
    {

        $server = new Server();
        $form = $this->createForm(ServerType::class, $server, [
            'action' => $this->generateUrl('crear-servidor'),
            'method' => 'POST'
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            if (isset($_POST['activo'])) {
                $server->setActivo(true);
            } else {
                $server->setActivo(false);
            }

            if(isset($_POST['server_urlacceso'])){
                $server->setUrlacceso($_POST['server_urlacceso']);
            }

            if (isset($_POST['password'])){
                $server->setPsw($_POST['password']);
            }

            $em->persist($server);
            $em->flush();

            $this->addFlash('success', 'Se ha creado correctamente el servidor');

            return $this->redirectToRoute('listar-servidores');

        }

        return $this->render('server/create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function edit($id, Request $request)
    {

        $server = $this->getDoctrine()
            ->getRepository(Server::class)
            ->find($id);

        if (isset($server) && !empty($server)) {
            $required = false;
        }

        $form = $this->createForm(ServerType::class, $server, [
            'required_password' => $required,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            if (isset($_POST['activo'])) {
                $server->setActivo(true);
            } else {
                $server->setActivo(false);
            }

            if(isset($_POST['urltest'])){
                $server->setUrlacceso($_POST['urltest']);
            }

            $em->persist($server);
            $em->flush();

            $this->addFlash('success', 'Se ha editado correctamente el servidor');

            return $this->redirectToRoute('listar-servidores');

        }

        return $this->render('server/edit.html.twig', array(
            'form' => $form->createView(),
            'server' => $server
        ));
    }

    public function delete($id)
    {

        $em = $this->getDoctrine()->getManager();

        $server = $this->getDoctrine()
            ->getRepository(Server::class)
            ->find($id);

        $em->remove($server);
        $em->flush();

        $this->addFlash('success', 'Se ha eliminado correctamente el servidor');


        return $this->redirectToRoute('listar-servidores');
    }

    public function oneServer(Request $request)
    {
        $id = $request->request->get('id', NULL);
        $server = $this->getDoctrine()
            ->getRepository(Server::class)
            ->find($id);

        if ($server != null) {

            $array = array();
            $array['id'] = $server->getId();
            $array['nombrevps'] = $server->getNombrevps();
            $array['alias'] = $server->getAlias();
            $array['ip'] = $server->getIp();
            $array['urlacceso'] = $server->getUrlacceso();
            $array['usuario'] = $server->getUsuario();
            $array['psw'] = $server->getPsw();
            $array['tipo'] = $server->getTipo();

            return new JsonResponse($array);
        } else {
            return null;
        }


    }
}
