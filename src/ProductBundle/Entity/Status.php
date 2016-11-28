<?php

namespace ProductBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;


/**
 * Status
 *
 * @ORM\Table(name="status")
 * @ORM\Entity(repositoryClass="ProductBundle\Repository\StatusRepository")
 * @JMS\ExclusionPolicy("all")
 */
class Status
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

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=true)
     * @JMS\Expose
     * @JMS\Groups({"workshop1"})
     * @JMS\Type("boolean")
     */
    private $enabled;

    /**
     * @ORM\OneToMany(targetEntity="ProductBundle\Entity\Product", mappedBy="statusId")
     */
    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

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
     * @return Status
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

    /**
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return Status
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return bool
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Add products
     *
     * @param  Product $products
     * @return Product
     */
    public function addProduct(Product $products)
    {
        $this->products[] = $products;

        return $this;
    }

    /**
     * Remove products
     *
     * @param Product $products
     */
    public function removeProduct(Product $products)
    {
        $this->products->removeElement($products);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProducts()
    {
        return $this->products;
    }
}
