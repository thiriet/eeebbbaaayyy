<?php

namespace Raph\EbayparserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Keyword
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Keyword
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="keyword", type="string", length=255)
     */
    private $keyword;

    /**
     * @var boolean
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @var string
     * @ORM\OneToMany(targetEntity="Product", mappedBy="keyword")
     */
    protected $products;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="keywords")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $category;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->products = new ArrayCollection();;
    }
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set keyword
     *
     * @param string $keyword
     * @return Keyword
     */
    public function setKeyword($keyword)
    {
        $this->keyword = $keyword;
    
        return $this;
    }

    /**
     * Get keyword
     *
     * @return string 
     */
    public function getKeyword()
    {
        return $this->keyword;
    }

    /**
     * Add products
     *
     * @param \Raph\EbayparserBundle\Entity\Product $products
     * @return Keyword
     */
    public function addProduct(\Raph\EbayparserBundle\Entity\Product $products)
    {
        $this->products[] = $products;
    
        return $this;
    }

    /**
     * Remove products
     *
     * @param \Raph\EbayparserBundle\Entity\Product $products
     */
    public function removeProduct(\Raph\EbayparserBundle\Entity\Product $products)
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


    /**
     * Set category
     *
     * @param \Raph\EbayparserBundle\Entity\Category $category
     * @return Keyword
     */
    public function setCategory(\Raph\EbayparserBundle\Entity\Category $category = null)
    {
        $this->category = $category;
    
        return $this;
    }

    /**
     * Get category
     *
     * @return \Raph\EbayparserBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Keyword
     */
    public function setActive($active)
    {
        $this->active = $active;
    
        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }
    public function __toString()
    {
        return (string)$this->keyword;
    }


}
