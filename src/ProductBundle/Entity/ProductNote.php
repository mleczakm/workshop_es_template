<?php

namespace ProductBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;


/**
 * Status
 *
 * @ORM\Table(name="product_note")
 * @ORM\Entity(repositoryClass="ProductBundle\Repository\ProductNoteRepository")
 * @JMS\ExclusionPolicy("all")
 */
class ProductNote
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
     * @var integer
     *
     * @ORM\Column(name="note", type="integer")
     * @JMS\Expose
     * @JMS\Groups({"workshop1"})
     * @JMS\Type("integer")
     */
    private $note;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="notes")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    private $products;

    /**
     * @ORM\ManyToOne(targetEntity="NoteCategory")
     * @ORM\JoinColumn(name="note_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     * @JMS\Expose
     * @JMS\Groups({"workshop1"})
     * @JMS\Type("ProductBundle\Entity\NoteCategory")
     */
    private $noteCategory;

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
     * @return int
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param int $note
     * @return ProductNote
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Add products
     *
     * @param  Product $product
     * @return ProductNote
     */
    public function addProduct(Product $product)
    {
        $this->products = $product;

        return $this;
    }

    /**
     * Get products
     *
     * @return ArrayCollection<Product>
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @return string
     */
    public function getCategoryName()
    {
        return $this->getNoteCategory()->getName();
    }

    /**
     * @return NoteCategory
     */
    public function getNoteCategory()
    {
        return $this->noteCategory;
    }

    /**
     * @param NoteCategory $noteCategory
     */
    public function setNoteCategory($noteCategory)
    {
        $this->noteCategory = $noteCategory;
    }


}
