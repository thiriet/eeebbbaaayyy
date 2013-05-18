<?php

namespace Raph\EbayparserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Product
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
     *
     * @ORM\Column(name="name")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="productcountry", type="string")
     */
    private $productCountry;

    /**
     * @var string
     *
     * @ORM\Column(name="ebayID", type="string")
     */
    private $ebayID;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="currency", type="string")
     */
    private $currency;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creationDate", type="date")
     */
    private $creationDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updateDate", type="date")
     */
    private $updateDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="publicationDate", type="date")
     */
    private $publicationDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endDate", type="date")
     */
    private $endDate;

    /**
     * @var float
     *
     * @ORM\Column(name="sellPrice", type="float")
     */
    private $sellPrice;

    /**
     * @var int
     *
     * @ORM\Column(name="bidAmount", type="integer")
     */
    private $bidAmount;

    /**
     * @var boolean
     *
     * @ORM\Column(name="sellingState", type="boolean")
     */
    private $sellingState;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Keyword", inversedBy="products")
     * @ORM\JoinColumn(name="keyword_id", referencedColumnName="id")
     */
    protected $keyword;

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
     * Set creation date
     *
     * @ORM\PrePersist
     */
    public function setCreatedValue()
    {
        $this->creationDate = new \DateTime();
        $this->updateDate = new \DateTime();
    }

    /**
     * Set update date
     *
     * @ORM\PreUpdate
     */
    public function setUpdatedValue()
    {
        $this->updateDate = new \DateTime();
    }

    /**
     * Set name
     *
     * @param string $name
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
     * Set ebayID
     *
     * @param string $ebayID
     * @return Product
     */
    public function setEbayID($ebayID)
    {
        $this->ebayID = $ebayID;
    
        return $this;
    }

    /**
     * Get ebayID
     *
     * @return string
     */
    public function getEbayID()
    {
        return $this->ebayID;
    }

    /**
     * Set price
     *
     * @param float $price
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
     * Set description
     *
     * @param string $description
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
     * Set publicationDate
     *
     * @param \DateTime $publicationDate
     * @return Product
     */
    public function setPublicationDate($publicationDate)
    {
        $this->publicationDate = $publicationDate;
    
        return $this;
    }

    /**
     * Get publicationDate
     *
     * @return \DateTime 
     */
    public function getPublicationDate()
    {
        return $this->publicationDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     * @return Product
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    
        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime 
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set sellPrice
     *
     * @param float $sellPrice
     * @return Product
     */
    public function setSellPrice($sellPrice)
    {
        $this->sellPrice = $sellPrice;
    
        return $this;
    }

    /**
     * Get sellPrice
     *
     * @return float 
     */
    public function getSellPrice()
    {
        return $this->sellPrice;
    }

    /**
     * Set currency
     *
     * @param string $currency
     * @return Product
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    
        return $this;
    }

    /**
     * Get currency
     *
     * @return string 
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set bidAmount
     *
     * @param integer $bidAmount
     * @return Product
     */
    public function setBidAmount($bidAmount)
    {
        $this->bidAmount = $bidAmount;
    
        return $this;
    }

    /**
     * Get bidAmount
     *
     * @return integer 
     */
    public function getBidAmount()
    {
        return $this->bidAmount;
    }

    /**
     * Set sellingState
     *
     * @param boolean $sellingState
     * @return Product
     */
    public function setSellingState($sellingState)
    {
        $this->sellingState = $sellingState;
    
        return $this;
    }

    /**
     * Get sellingState
     *
     * @return boolean 
     */
    public function getSellingState()
    {
        return $this->sellingState;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     * @return Product
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    
        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime 
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set updateDate
     *
     * @param \DateTime $updateDate
     * @return Product
     */
    public function setUpdateDate($updateDate)
    {
        $this->updateDate = $updateDate;
    
        return $this;
    }

    /**
     * Get updateDate
     *
     * @return \DateTime 
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }


    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * Set productCountry
     *
     * @param string $productCountry
     * @return Product
     */
    public function setProductCountry($productCountry)
    {
        $this->productCountry = $productCountry;
    
        return $this;
    }

    /**
     * Get productCountry
     *
     * @return string 
     */
    public function getProductCountry()
    {
        return $this->productCountry;
    }

    /**
     * Set keyword
     *
     * @param \Raph\EbayparserBundle\Entity\Keyword $keyword
     * @return Product
     */
    public function setKeyword(\Raph\EbayparserBundle\Entity\Keyword $keyword = null)
    {
        $this->keyword = $keyword;
    
        return $this;
    }

    /**
     * Get keyword
     *
     * @return \Raph\EbayparserBundle\Entity\Keyword 
     */
    public function getKeyword()
    {
        return $this->keyword;
    }
}