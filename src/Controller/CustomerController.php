<?php

namespace App\Controller;

use PhpParser\Node\Expr\Array_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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

        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();

        if (isset($_POST) && !empty($_POST) && $_POST != null && $_POST != "") {

            $em = $this->getDoctrine()->getManager();

            $correo = $_POST['email'];

            $customer2 = $this->getDoctrine()
                ->getRepository(Customer::class)
                ->findOneBy([
                    'pm_mail' => $correo
                ]);

            if ($customer2 != null) {

                return $this->render('customer/create.html.twig', array(
                    //'form' => $form->createView(),
                    'users' => $users,
                    'status' => true

                ));
            }

            $customer->setNombre($_POST['nombre']);
            $customer->setAlias($_POST['alias']);
            $customer->setPmNombre($_POST['contacto']);
            $customer->setPmMail($_POST['email']);

            if (isset($_POST['users'])) {
                $array = $_POST['users'];

                foreach ($array as $valor) {
                    $user = $this->getDoctrine()
                        ->getRepository(User::class)
                        ->find($valor);
                    $customer->addUser($user);
                }
            }

            if (isset($_POST['activo'])) {
                $customer->setEstado(1);
            } else {
                $customer->setEstado(0);
            }

            $em->persist($customer);
            $em->flush();

            $data = [
                'correcto' => 200,
                'ruta' => 'http://localhost/wiip/public/index.php/clientes/listar'
            ];


            /*$serializer = \SerializerBuilder::create()->build();
            $jsonContent = $serializer->serialize($data, 'json');*/
            $this->addFlash('success', 'Se ha creado correctamente al cliente ' . $customer->getNombre());

            return $this->redirectToRoute('listar-clientes');

        }

        return $this->render('customer/create.html.twig', array(
            'users' => $users,
            'status' => false
        ));
    }

    public function edit($id, Request $request)
    {
        //BUSCO SI EXISTE EL CUSTOMER
        $customer = $this->getDoctrine()
            ->getRepository(Customer::class)
            ->find($id);

        $activo = $customer->getEstado();

        //BUSCO TODOS LOS USUARIOS PARA EL DESPLEGABLE
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();

        /*$query = $em->createQuery("SELECT u.nombre FROM App\Entity\User u
                                    LEFT JOIN App\Entity\Customer c WITH u.customers = c
                                    WHERE u.customers NOT IN (:customer)")
            ->setParameter('customer', $customer);
        $users = $query->getResult();*/
        $cont = 0;
        $usersCustomer = array(
            $cont => array(
                "nombre" => '',
                "id" => '',
                "selected" => ''
            )
        );


        foreach ($users as $clave => $valor) {
            if ($customer->getUsers()->contains($valor)) {
                $usersCustomer[$cont]['nombre'] = $valor->getNombre();
                $usersCustomer[$cont]['id'] = $valor->getId();
                $usersCustomer[$cont]['selected'] = true;
                $cont++;
            } else {
                $usersCustomer[$cont]['nombre'] = $valor->getNombre();
                $usersCustomer[$cont]['id'] = $valor->getId();
                $usersCustomer[$cont]['selected'] = false;
                $cont++;
            }
        }

        /*$query = $em->createQueryBuilder();

        $users = $query->select(['DISTINCT user.id,user.nombre'])
            ->from('App\Entity\User', 'user')
            ->innerJoin('user.customers','customer')
            ->where($query->expr()->neq('customer',':customer'))
            //->setParameter(['customer' => $customer])
            ->orWhere($query->expr()->eq('customer',':null'))
            ->setParameters(['customer' => $customer,'null' => ''])
            ->groupBy('user.id')
            ->getQuery()->getResult();*/

        if (isset($_POST) && !empty($_POST) && $_POST != null && $_POST != "") {

            $em = $this->getDoctrine()->getManager();

            $correo = $_POST['email'];

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
                        'status' => false,
                        'activo' => $activo,
                        'customer' => $customer,
                        'users' => $usersCustomer
                    ));
                }
            }

            $customer->setNombre($_POST['nombre']);
            $customer->setAlias($_POST['alias']);
            $customer->setPmNombre($_POST['contacto']);
            $customer->setPmMail($_POST['email']);

            if (isset($_REQUEST['users'])) {

                $array = $_POST['users'];

                foreach ($customer->getUsers() as $clave => $valor) {
                    $customer->removeUser($valor);
                }

                foreach ($array as $valor) {
                    $user = $this->getDoctrine()
                        ->getRepository(User::class)
                        ->find($valor);
                    $customer->addUser($user);
                }
            }

            if (isset($_POST['activo'])) {
                $customer->setEstado(1);
            } else {
                $customer->setEstado(0);
            }

            $em->persist($customer);
            $em->flush();

            $data = [
                'correcto' => 200,
                'ruta' => 'http://localhost/wiip/public/index.php/clientes/listar'
            ];

            $em->persist($customer);
            $em->flush();

            $this->addFlash('success', 'Se ha editado correctamente al cliente ' . $customer->getNombre());

            return $this->redirectToRoute('listar-clientes');
        }

        return $this->render('customer/edit.html.twig', array(
            'status' => false,
            'activo' => $activo,
            'customer' => $customer,
            'users' => $usersCustomer
        ));
    }

    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();

        $customer = $this->getDoctrine()
            ->getRepository(Customer::class)
            ->find($id);

        if ($customer->getProjects()[0] == null) {
            $em->remove($customer);
            $em->flush();

            $this->addFlash('success', 'Se ha eliminado correctamente al cliente!');

        } else {
            $this->addFlash('failed', 'No se ha podido eliminar el cliente porque tiene proyectos asociados!');

        }
        return $this->redirectToRoute('listar-clientes');
    }

    public function buscaCustomer($id)
    {

        $customer = $this->getDoctrine()
            ->getRepository(Customer::class)
            ->find($id);

        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();

        if (isset($customer) && !empty($customer) && $customer != null) {
            $cont = 0;
            $usersCustomer = array(
                $cont => array(
                    "nombre" => '',
                    "id" => '',
                    "selected" => ''
                )
            );


            foreach ($users as $clave => $valor) {
                if ($customer->getUsers()->contains($valor)) {
                    $usersCustomer[$cont]['nombre'] = $valor->getNombre();
                    $usersCustomer[$cont]['id'] = $valor->getId();
                    $usersCustomer[$cont]['selected'] = true;
                    $cont++;
                } else {

                    //var_dump($valor->getNombre());
                    //die();
                    $usersCustomer[$cont]['nombre'] = $valor->getNombre();
                    $usersCustomer[$cont]['id'] = $valor->getId();
                    $usersCustomer[$cont]['selected'] = false;
                    $cont++;
                }
            }

            $data = [
                'users' => $usersCustomer,
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


