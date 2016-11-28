<?php

namespace ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;


/**
 * Status
 *
 * @ORM\Table(name="note_category")
 * @ORM\Entity(repositoryClass="ProductBundle\Repository\NoteCategoryRepository")
 * @JMS\ExclusionPolicy("all")
 */
class NoteCategory
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\Expose
     * @JMS\Groups({"workshop1"})
     * @JMS\Type("integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @JMS\Expose
     * @JMS\Groups({"workshop1"})
     * @JMS\Type("string")
     */
    private $name;

    public function __toString() {
        return $this->name;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return NoteCategory
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
