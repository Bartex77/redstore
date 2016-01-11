<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Product;

/**
 * CartLog
 *
 * @ORM\Table(name="cart_log")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CartLogRepository")
 */
class CartLog
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
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="cartLogs")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $product;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="selectionDatetime", type="datetime")
     */
    private $selectionDatetime;


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
     * Set product
     *
     * @param Product $product
     *
     * @return CartLog
     */
    public function setProduct($product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set selectionDatetime
     *
     * @param \DateTime $selectionDatetime
     *
     * @return CartLog
     */
    public function setSelectionDatetime($selectionDatetime)
    {
        $this->selectionDatetime = $selectionDatetime;

        return $this;
    }

    /**
     * Get selectionDatetime
     *
     * @return \DateTime
     */
    public function getSelectionDatetime()
    {
        return $this->selectionDatetime;
    }
}

