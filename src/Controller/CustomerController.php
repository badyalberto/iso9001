<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Customer;
use App\Entity\User;
use App\Form\CustomerType;

class CustomerController extends AbstractController
{

    public function index()
    {
        return $this->render('customer/index.html.twig', [
            'controller_name' => 'CustomerController',
        ]);
    }

    public function list()
    {
        if ($this->getUser()->getRoles()[0] == "ROLE_WIP") {
            $customers = $this->getDoctrine()->getRepository(Customer::class)->findAll();
        } else {
            $customers = $this->getUser()->getCustomers();
            //var_dump($customers);
            //exit;
        }


        return $this->render('customer/list.html.twig', [
            'customers' => $customers
        ]);
    }

    public function create(Request $request)
    {
        $customer = new Customer();
        $form = $this->createForm(CustomerType::class, $customer, [
            'action' => $this->generateUrl('crear-cliente'),
            'method' => 'POST'
        ]);
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $correo = $_POST['customer']['pmmail'];

            $customer2 = $this->getDoctrine()
                ->getRepository(Customer::class)
                ->findOneBy([
                    'pm_mail' => $correo
                ]);

            if ($customer2 != null) {

                return $this->render('customer/create.html.twig', array(
                    'form' => $form->createView(),
                    'users' => $users,
                    'status' => true

                ));
            }

            //var_dump($_POST);
            //exit;
            $array = $_POST['customer']['users'];

            foreach ($array as $valor) {
                $user = $this->getDoctrine()
                    ->getRepository(User::class)
                    ->find($valor);
                $customer->addUser($user);
            }

            if (isset($_POST['activo'])) {
                $customer->setEstado(false);
            } else {
                $customer->setEstado(true);
            }

            $em->persist($customer);
            $em->flush();

            return $this->redirectToRoute('listar-clientes');

        }

        return $this->render('customer/create.html.twig', array(
            'form' => $form->createView(),
            'users' => $users,
            'status' => false
        ));
    }

    public function edit($id, Request $request)
    {

        $customer = $this->getDoctrine()
            ->getRepository(Customer::class)
            ->find($id);

        $activo = $customer->getEstado();
        //var_dump($activo);
        //exit;

        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            //'<pre>';var_dump($_POST);
            //exit;
            //PARAMETRO DEL FORM
            $correo = $_POST['customer']['pmmail'];

            //BUSCA SI EXISTE UN CUSTOMER CON ESE CORREO
            $customer2 = $this->getDoctrine()
                ->getRepository(Customer::class)
                ->findOneBy([
                    'pm_mail' => $correo
                ]);

            //COMPRUEBA SI HA DEVUELTO UN USER
            if ($customer2 != null) {
                //ID DISTINTA Y MISMO CORREO (CORREO REPETIDO EN OTRO USER)
                if ($correo == $customer2->getPmMail() && $id != $customer2->getId()) {
                    return $this->render('customer/edit.html.twig', array(
                        'form' => $form->createView(),
                        'status' => true

                    ));
                }
            }

            if (isset($_POST['activo']) && $_POST['activo'] == "on") {
                $customer->setEstado(1);
            } else {
                $customer->setEstado(0);
            }

            $em->persist($customer);
            $em->flush();

            $this->addFlash('success', 'Se ha editado correctamente al cliente ' . $customer->getNombre());

            return $this->redirectToRoute('listar-clientes');
        }

        return $this->render('customer/edit.html.twig', array(
            'form' => $form->createView(),
            'status' => false,
            'activo' => $activo
        ));
    }

    public function delete($id)
    {

        $em = $this->getDoctrine()->getManager();

        $customer = $this->getDoctrine()
            ->getRepository(Customer::class)
            ->find($id);

        //var_dump($customer->getProjects()[0]->getId());
        //exit;

        if ($customer->getProjects()[0] == null) {
            $em->remove($customer);
            $em->flush();

            $this->addFlash('success', 'Se ha eliminado correctamente al cliente!');

        } else {
            $this->addFlash('failed', 'No se ha podido eliminar el cliente porque tiene proyectos asociados!');

        }
        return $this->redirectToRoute('listar-clientes');
    }

}


