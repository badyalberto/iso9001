<?php

namespace App\Controller;

use App\Entity\ResetPasswordRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Entity\User;
use App\Entity\Customer;
use App\Form\UserType;

class UserController extends AbstractController
{

    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    public function list()
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render('user/list.html.twig', [
            'users' => $users
        ]);
    }

    public function create(Request $request, UserPasswordEncoderInterface $encoder)
    {

        $user = new User();
        $form = $this->createForm(UserType::class, $user, [
            'action' => $this->generateUrl('crear-usuario'),
            'method' => 'POST'
        ]);

        $customers = $this->getDoctrine()
            ->getRepository(Customer::class)
            ->findAll();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $correo = $_POST['user']['correo'];

            $user2 = $this->getDoctrine()
                ->getRepository(User::class)
                ->findOneBy([
                    'correo' => $correo
                ]);

            if ($user2 != null) {

                return $this->render('user/create.html.twig', array(
                    'form' => $form->createView(),
                    'customers' => $customers,
                    'status' => true

                ));
            }

            if (!empty($_POST['user']['customers'])) {
                $array = $_POST['user']['customers'];
                foreach ($array as $valor) {
                    $customer = $this->getDoctrine()
                        ->getRepository(Customer::class)
                        ->find($valor);
                    $user->addCustomer($customer);
                }
            }

            if ($_REQUEST['user']['tipo'] == "WIIP") {
                $user->setRoles(['ROLE_WIP']);
            } else {
                $user->setRoles(['ROLE_USER']);
            }

            $encoded = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encoded);

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Se ha creado correctamente al usuario '.$user->getNombre());

            return $this->redirectToRoute('listar-usuarios');

        }

        return $this->render('user/create.html.twig', array(
            'form' => $form->createView(),
            'customers' => $customers,
            'status' => false
        ));
    }


    public function edit($id, Request $request, UserPasswordEncoderInterface $encoder)
    {

        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            //PARAMETRO DEL FORM
            $correo = $_POST['user']['correo'];

            //BUSCA SI EXISTE UN USER CON ESE CORREO
            $user2 = $this->getDoctrine()
                ->getRepository(User::class)
                ->findOneBy([
                    'correo' => $correo
                ]);

            //COMPRUEBA SI HA DEVUELTO UN USER
            if ($user2 != null) {
                //ID DISTINTA Y MISMO CORREO (CORREO REPETIDO EN OTRO USER)
                if ($correo == $user2->getCorreo() && $id != $user2->getId()) {
                    return $this->render('user/edit.html.twig', array(
                        'form' => $form->createView(),
                        'status' => true

                    ));
                }
            }



            if (!empty($_POST['user']['customers'])) {
                $array = $_POST['user']['customers'];
                foreach ($array as $valor) {
                    $customer = $this->getDoctrine()
                        ->getRepository(Customer::class)
                        ->find($valor);
                    //echo '<pre>';var_dump($customer->getAlias());
                    //exit;
                    $user->addCustomer($customer);
                }
            }

            $data = $form->getData();

            $encoded = $encoder->encodePassword($user, $data->getPassword());
            $user->setPassword($encoded);

            if ($_REQUEST['user']['tipo'] == "WIIP") {
                $user->setRoles(["ROLE_WIP"]);
            } else {
                $user->setRoles(["ROLE_USER"]);

            }

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Se ha editado correctamente al usuario '.$user->getNombre());

            return $this->redirectToRoute('listar-usuarios');

        }

        return $this->render('user/edit.html.twig', array(
            'form' => $form->createView(),
            'status' => false
        ));
    }

    public function delete($id)
    {

        $em = $this->getDoctrine()->getManager();

        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        if (empty($user->getProjects2()) && empty($user->getProjects())) {
            $em->remove($user);
            $em->flush();
            $this->addFlash('success', 'Se ha eliminado correctamente al usuario!');
        } else {
            $this->addFlash('danger', 'No se ha podido eliminar al usuario porque tiene projectos asociados');
        }

        return $this->redirectToRoute('listar-usuarios');
    }

}
