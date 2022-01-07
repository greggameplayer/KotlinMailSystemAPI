<?php

namespace App\Entity;

use App\Repository\MailboxRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MailboxRepository::class)
 */
class Mailbox
{

    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $language;

    /**
     * @ORM\Column(type="string", length=800)
     */
    private $storagebasedirectory;

    /**
     * @ORM\Column(type="string", length=800)
     */
    private $storagenode;

    /**
     * @ORM\Column(type="string", length=800)
     */
    private $maildir;

    /**
     * @ORM\Column(type="integer")
     */
    private $quota;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $domain;

    /**
     * @ORM\Column(type="datetime")
     */
    private $passwordlastchange;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(string $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getStoragebasedirectory(): ?string
    {
        return $this->storagebasedirectory;
    }

    public function setStoragebasedirectory(string $storagebasedirectory): self
    {
        $this->storagebasedirectory = $storagebasedirectory;

        return $this;
    }

    public function getStoragenode(): ?string
    {
        return $this->storagenode;
    }

    public function setStoragenode(string $storagenode): self
    {
        $this->storagenode = $storagenode;

        return $this;
    }

    public function getMaildir(): ?string
    {
        return $this->maildir;
    }

    public function setMaildir(string $maildir): self
    {
        $this->maildir = $maildir;

        return $this;
    }

    public function getQuota(): ?int
    {
        return $this->quota;
    }

    public function setQuota(int $quota): self
    {
        $this->quota = $quota;

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

    public function getPasswordlastchange(): ?\DateTimeInterface
    {
        return $this->passwordlastchange;
    }

    public function setPasswordlastchange(\DateTimeInterface $passwordlastchange): self
    {
        $this->passwordlastchange = $passwordlastchange;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }
}
