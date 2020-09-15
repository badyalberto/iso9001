<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $nombre;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $correo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tipo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToMany(targetEntity=Customer::class, mappedBy="users",cascade={"persist"})
     */
    protected $customers;

    /**
     * @ORM\ManyToMany(targetEntity=Project::class, mappedBy="manager_wip",cascade={"persist"})
     */
    protected $projects;

    /**
     * @ORM\ManyToMany(targetEntity=Project::class, mappedBy="manager_customer",cascade={"persist"})
     */
    protected $projects2;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\OneToMany(targetEntity=Test::class, mappedBy="user")
     */
    private $tests;

    public function __construct()
    {
        $this->customers = new ArrayCollection();
        $this->projects = new ArrayCollection();
        $this->projects2 = new ArrayCollection();
        $this->tests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getCorreo(): ?string
    {
        return $this->correo;
    }

    public function setCorreo(string $correo): self
    {
        $this->correo = $correo;

        return $this;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getActivo(): ?bool
    {
        return $this->activo;
    }

    public function setActivo(bool $activo): self
    {
        $this->activo = $activo;

        return $this;
    }

    public function getUsername()
    {
        return $this->correo;
    }

    public function getSalt()
    {
        //return null;
    }


    public function eraseCredentials()
    {
    }

    /**
     * @return Collection|Customer[]
     */
    public function getCustomers(): Collection
    {
        return $this->customers;
    }

    public function addCustomer(Customer $customer = null): self
    {

        if (!$this->customers->contains($customer)) {
            $this->customers[] = $customer;
            $customer->addUser($this);
            //var_dump("Funcion add");
        }

        return $this;
    }

    public function removeCustomer(Customer $customer): self
    {

        if ($this->customers->contains($customer)) {
            $this->customers->removeElement($customer);
            //var_dump("Funcion delete ".$customer);
            $customer->removeUser($this);

        }

        return $this;
    }

    /**
     * @return Collection|Project[]
     */
    public function getProjects(): Collection
    {
        //Devuelve los projectos con manager wip
        return $this->projects;
    }

    public function addProject(Project $project = null): self
    {
        if (!$this->projects->contains($project)) {
            $this->projects[] = $project;
            $project->addManagerWip($this);
        }

        return $this;
    }

    public function removeProject(Project $project): self
    {
        if ($this->projects->contains($project)) {
            $this->projects->removeElement($project);
            $project->removeManagerWip($this);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->nombre;
    }

    /**
     * @return Collection|Project[]
     */
    public function getProjects2(): Collection
    {
        //Devuelve los projectos con manager cliente
        return $this->projects2;
    }


    public function addProjects2(Project $projects2): self
    {
        if (!$this->projects2->contains($projects2)) {
            $this->projects2[] = $projects2;
            $projects2->addManagerCustomer($this);
        }

        return $this;
    }

    public function removeProjects2(Project $projects2): self
    {
        if ($this->projects2->contains($projects2)) {
            $this->projects2->removeElement($projects2);
            $projects2->removeManagerCustomer($this);
        }

        return $this;
    }

    public function getRoles()
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = '';

        //return (string) $this->roles;
        //return array_unique(array_merge(['ROLE_USER'], $this->roles));
        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return Collection|Test[]
     */
    public function getTests(): Collection
    {
        return $this->tests;
    }

    public function addTest(Test $test): self
    {
        if (!$this->tests->contains($test)) {
            $this->tests[] = $test;
            $test->setUser($this);
        }

        return $this;
    }

    public function removeTest(Test $test): self
    {
        if ($this->tests->contains($test)) {
            $this->tests->removeElement($test);
            // set the owning side to null (unless already changed)
            if ($test->getUser() === $this) {
                $test->setUser(null);
            }
        }

        return $this;
    }
}
