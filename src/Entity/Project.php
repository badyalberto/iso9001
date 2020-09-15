<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha_alta;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $alias;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url_test;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url_production;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $estado;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tipo;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="projects")
     */
    private $customers;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="projects",cascade={"persist"})
     * @ORM\JoinTable(name="project_user")
     */
    protected $manager_wip;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="projects",cascade={"persist"})
     * @ORM\JoinTable(name="user_project")
     */
    protected $manager_customer;

    /**
     * @ORM\Column(type="boolean")
     */
    private $desactivar;

    /**
     * @ORM\OneToMany(targetEntity=Test::class, mappedBy="project")
     */
    private $tests;

    public function __construct()
    {
        $this->manager_wip = new ArrayCollection();
        $this->manager_customer = new ArrayCollection();
        $this->tests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFechaAlta(): ?\DateTimeInterface
    {
        return $this->fecha_alta;
    }

    public function setFechaAlta(\DateTimeInterface $fecha_alta): self
    {
        $this->fecha_alta = $fecha_alta;

        return $this;
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(string $alias): self
    {
        $this->alias = $alias;

        return $this;
    }

    public function getUrlTest(): ?string
    {
        return $this->url_test;
    }

    public function setUrlTest(string $url_test): self
    {
        $this->url_test = $url_test;

        return $this;
    }

    public function getUrlProduction(): ?string
    {
        return $this->url_production;
    }

    public function setUrlProduction(string $url_production): self
    {
        $this->url_production = $url_production;

        return $this;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): self
    {
        $this->estado = $estado;

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

    public function getCustomers(): ?Customer
    {
        return $this->customers;
    }

    public function setCustomers(?Customer $customers): self
    {
        $this->customers = $customers;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getManagerWip(): Collection
    {
        return $this->manager_wip;
    }

    public function addManagerWip(User $managerWip): User
    {
        if (!$this->manager_wip->contains($managerWip)) {
            $this->manager_wip[] = $managerWip;
        }

        return $this;
    }

    public function removeManagerWip(User $managerWip): User
    {
        if ($this->manager_wip->contains($managerWip)) {
            $this->manager_wip->removeElement($managerWip);
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getManagerCustomer(): Collection
    {
        return $this->manager_customer;
    }

    public function addManagerCustomer(User $managerCustomer): self
    {
        if (!$this->manager_customer->contains($managerCustomer)) {
            $this->manager_customer[] = $managerCustomer;
        }

        return $this;
    }

    public function removeManagerCustomer(User $managerCustomer): self
    {
        if ($this->manager_customer->contains($managerCustomer)) {
            $this->manager_customer->removeElement($managerCustomer);
        }

        return $this;
    }

    public function getDesactivar(): ?bool
    {
        return $this->desactivar;
    }

    public function setDesactivar(bool $desactivar): self
    {
        $this->desactivar = $desactivar;

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
            $test->setProject($this);
        }

        return $this;
    }

    public function removeTest(Test $test): self
    {
        if ($this->tests->contains($test)) {
            $this->tests->removeElement($test);
            // set the owning side to null (unless already changed)
            if ($test->getProject() === $this) {
                $test->setProject(null);
            }
        }

        return $this;
    }

    public function __ToString(){
        return $this->alias;
    }
}
