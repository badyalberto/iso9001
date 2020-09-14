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
        $customers = $this->getDoctrine()->getRepository(Customer::class)->findAll();
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

            var_dump($_POST);
            exit;
            $array = $_POST['customer']['users'];

            foreach ($array as $valor) {
                $user = $this->getDoctrine()
                    ->getRepository(User::class)
                    ->find($valor);
                $customer->addUser($user);
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

        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

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

            $em->persist($customer);
            $em->flush();

            $this->addFlash('success', 'Se ha editado correctamente al cliente '.$customer->getNombre());

            return $this->redirectToRoute('listar-clientes');
        }

        return $this->render('customer/edit.html.twig', array(
            'form' => $form->createView(),
            'status' => false
        ));
    }

    public function delete($id)
    {

        $em = $this->getDoctrine()->getManager();

        $customer = $this->getDoctrine()
            ->getRepository(Customer::class)
            ->find($id);

        if (count($customer->getUsers()) == 0) {
            $em->remove($customer);
            $em->flush();

            $this->addFlash('success', 'Se ha elimnado correctamente al cliente!');

        } else {
            $this->addFlash('failed', 'No se ha podido eliminar el cliente porque tiene asociados usuarios!');

        }
        return $this->redirectToRoute('listar-clientes');
    }

}


