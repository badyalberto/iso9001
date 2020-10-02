<?php

namespace App\Controller;

use App\Entity\ResetPasswordRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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

            if (isset($_POST['customers'])) {
                $array = $_POST['customers'];

                foreach ($array as $valor) {
                    $customer = $this->getDoctrine()
                        ->getRepository(Customer::class)
                        ->find($valor);
                    $user->addCustomer($customer);
                }
            }

            /*if (!empty($_POST['user']['customers'])) {
                $array = $_POST['user']['customers'];
                foreach ($array as $valor) {
                    $customer = $this->getDoctrine()
                        ->getRepository(Customer::class)
                        ->find($valor);
                    $user->addCustomer($customer);
                }
            }*/

            if ($_REQUEST['user']['tipo'] == "WIIP") {
                $user->setRoles(['ROLE_WIP']);
            } else {
                $user->setRoles(['ROLE_USER']);
            }

            $encoded = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encoded);

            if (isset($_POST['activo'])) {
                $user->setActivo(true);
            } else {
                $user->setActivo(false);
            }

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Se ha creado correctamente al usuario ' . $user->getNombre());

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
        //BUSCO SI EXISTE EL USUARIO
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        $pass = $user->getPassword();

        $activo = $user->getActivo();

        $required = false;

        //BUSCO TODOS LOS CLIENTES PARA EL DESPLEGABLE
        $customers = $this->getDoctrine()
            ->getRepository(Customer::class)
            ->findAll();

        $cont = 0;
        $customerUsers = array(
            $cont => array(
                "nombre" => '',
                "id" => '',
                "selected" => ''
            )
        );

        foreach ($customers as $clave => $valor) {
            $customerUsers[$cont]['nombre'] = $valor->getNombre();
            $customerUsers[$cont]['id'] = $valor->getId();
            if ($user->getCustomers()->contains($valor)) {
                $customerUsers[$cont]['selected'] = true;
            } else {
                $customerUsers[$cont]['selected'] = false;
            }
            $cont++;
        }

        $form = $this->createForm(UserType::class, $user, [
            'required_password' => $required,
        ]);

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
                        'status' => true,
                        'customers' => $customerUsers
                    ));
                }
            }

            if (isset($_POST['customers'])) {

                $array = $_POST['customers'];

                foreach ($user->getCustomers() as $clave => $valor) {
                    $user->removeCustomer($valor);
                }

                foreach ($array as $valor) {
                    $customer = $this->getDoctrine()
                        ->getRepository(Customer::class)
                        ->find($valor);
                    echo $customer->getAlias() . '<br>';
                    $user->addCustomer($customer);
                }
            }


            $data = $form->getData();

            if ($data->getPassword() != '' && $data->getPassword() != null) {
                $encoded = $encoder->encodePassword($user, $data->getPassword());
                $user->setPassword($encoded);
            } else {
                $user->setPassword($pass);
            }

            if ($_REQUEST['user']['tipo'] == "WIIP") {
                $user->setRoles(["ROLE_WIP"]);
            } else {
                $user->setRoles(["ROLE_USER"]);
            }

            if (isset($_POST['activo']) && $_POST['activo'] == "on") {
                $user->setActivo(1);
            } else {
                $user->setActivo(0);
            }

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Se ha editado correctamente al usuario ' . $user->getNombre());

            return $this->redirectToRoute('listar-usuarios');

        }
        /*echo '<pre>';
        var_dump($customerUsers);
        echo '</pre>';
        die();*/


        return $this->render('user/edit.html.twig', array(
            'form' => $form->createView(),
            'status' => false,
            'activo' => $activo,
            'customers' => $customerUsers
        ));
    }

    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        if ($user->getId() != $this->getUser()->getId()) {
            if ($user->getProjects2()[0] == null && $user->getProjects()[0] == null) {
                $em->remove($user);
                $em->flush();
                $this->addFlash('success', 'Se ha eliminado correctamente al usuario!');
            } else {
                $this->addFlash('danger', 'No se ha podido eliminar al usuario porque tiene projectos asociados');
            }
        } else {
            $this->addFlash('danger', 'No se ha podido eliminar al usuario porque estas logueado con el');
        }

        return $this->redirectToRoute('listar-usuarios');
        //return new JsonResponse();
    }

    private function resjon($data)
    {
        //serializar datos con servicio serializer
        $json = $this->get('serializer')->serializer($data, 'json');
        //response con httpfoundation
        $response = new Response();
        //asignar cotenido a la respuesta
        $response->setContent('json');
        // Indicar formato de respuesta
        $response->headers->set('Content-Type', 'application/json');
        //devolver respuesta
        return response;
    }

    public function buscaUser($id)
    {

        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        if (isset($user) && !empty($user) && $user != null) {
            $customers = [];
            $cont = 0;
            foreach ($user->getCustomers() as $clave => $valor) {
                $customers[$cont]['nombre'] = $valor->getNombre();
                $customers[$cont]['id'] = $valor->getId();
                $cont++;
            }

            $data = [
                'customers' => $customers,
                'correcto' => 200
            ];
        } else {
            $data = [
                'customer' => null,
                'success' => 400
            ];
        }

        return new JsonResponse($data);
    }

}
