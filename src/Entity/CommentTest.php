<?php

namespace MyBasicModule\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table
 */

class CommentTest 
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @ORM\Column(type="string", length=255)
     */

    private $name;
    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @ORM\Column(type="decimal", scale=2)
     */

    private int $price;

    public function getPrice(): int
    {
        return $this->price;
    }
 
    public function setPrice(int $price): void 
    {
        $this->price = $price;
    }

    /**
     * @ORM\Column(type="text")
     */

    private $description;

    public function getDescription(): string
    {
        return $this->description;
    }
 
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
}