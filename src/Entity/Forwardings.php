<?php

namespace App\Entity;

use App\Repository\ForwardingsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ForwardingsRepository::class)
 */
class Forwardings
{

    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=800)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=800)
     */
    private $forwarding;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $domain;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $destDomain;

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getForwarding(): ?string
    {
        return $this->forwarding;
    }

    public function setForwarding(string $forwarding): self
    {
        $this->forwarding = $forwarding;

        return $this;
    }

    public function getDomain(): ?string
    {
        return $this->domain;
    }

    public function setDomain(string $domain): self
    {
        $this->domain = $domain;

        return $this;
    }

    public function getDestDomain(): ?string
    {
        return $this->destDomain;
    }

    public function setDestDomain(string $destDomain): self
    {
        $this->destDomain = $destDomain;

        return $this;
    }
}
