<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\Project;
use App\Entity\User;
use App\Form\ProjectType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{

    public function index()
    {
        return $this->render('project/index.html.twig', [
            'controller_name' => 'ProjectController',
        ]);
    }

    public function list()
    {
        if($this->getUser()->getRoles()[0] == "ROLE_WIP"){
            $projects = $this->getDoctrine()->getRepository(Project::class)->findAll();
        }else{
            $projects = $this->getUser()->getProjects2();
        }

        return $this->render('project/list.html.twig', [
            'projects' => $projects
        ]);
    }


    public function create(Request $request)
    {

        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project, [
            'action' => $this->generateUrl('crear-proyecto'),
            'method' => 'POST'
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($project);
            $em->flush();

            return $this->redirectToRoute('listar-proyectos');

        }

        return $this->render('project/create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function edit($id, Request $request)
    {
        $project = $this->getDoctrine()
            ->getRepository(Project::class)
            ->find($id);

        $form = $this->createForm(ProjectType::class, $project);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($project);
            $em->flush();

            return $this->redirectToRoute('listar-proyectos');

        }

        return $this->render('project/edit.html.twig', array(
            'form' => $form->createView(),

        ));
    }

    public function delete($id)
    {

        $em = $this->getDoctrine()->getManager();

        $project = $this->getDoctrine()
            ->getRepository(Project::class)
            ->find($id);

        if (count($project->getManagerCustomer()) == 0 && count($project->getManagerWip()) == 0) {
            $em->remove($project);
            $em->flush();

            $this->addFlash('success', 'Se ha eliminado correctamente al proyecto!');

        } else {
            $this->addFlash('failed', 'No se ha podido eliminar el proyecto porque tiene asociados clientes o usuarios!');

        }
        return $this->redirectToRoute('listar-proyectos');
    }
}
