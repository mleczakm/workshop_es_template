<?php

namespace ProductBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="ProductBundle\Repository\ProductRepository")
 */
class Product
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="Status", inversedBy="products")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    private $statusId;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection $productCategories
     *
     * @ORM\ManyToMany(targetEntity="ProductBundle\Entity\Category", mappedBy="products", cascade={"persist"})
     */
    private $productCategories;

    /**
     * @var ArrayCollection<ProductBundle\Entity\ProductNote>
     * @ORM\OneToMany(targetEntity="ProductNote", mappedBy="products", cascade={"persist"})
     */
    private $notes;

    public function __construct()
    {
        $this->productCategories = new ArrayCollection();
        $this->notes = new ArrayCollection();
    }

    public function __toString()
    {
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
     * @return Product
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
     * Set description
     *
     * @param string $description
     *
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set statusId
     *
     * @param integer $statusId
     *
     * @return Product
     */
    public function setStatusId($statusId)
    {
        $this->statusId = $statusId;

        return $this;
    }

    /**
     * Get statusId
     *
     * @return int
     */
    public function getStatusId()
    {
        return $this->statusId;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Product
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Add productCategories
     *
     * @param  Category $productCategory
     * @return Product
     */
    public function addProductCategory(Category $productCategory)
    {
        $productCategory->addProduct($this);
        $this->productCategories[] = $productCategory;

        return $this;
    }

    /**
     * Remove productCategories
     *
     * @param Category $productCategory
     */
    public function removeProductCategory(Category $productCategory)
    {
        $productCategory->removeProduct($this);
        $this->productCategories->removeElement($productCategory);
    }

    /**
     * Get productCategories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductCategories()
    {
        return $this->productCategories;
    }

    /**
     * Get productCategories
     *
     * @param ArrayCollection $productCategories
     * @return Product
     */
    public function setProductCategories(ArrayCollection $productCategories)
    {
        $this->productCategories = $productCategories;

        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     * @return Product
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return ArrayCollection<ProductNote>
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param ProductNote $note
     * @return Product
     */
    public function addNote($note)
    {
        $this->notes->add($note);

        return $this;
    }

}
