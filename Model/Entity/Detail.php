<?php
namespace Model\Entity;

class Detail extends BaseEntity
{ 
    private $quantity;
    private $order_id;
    private $product_id;


    /**
     * Get the value of quantity
     */ 
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set the value of quantity
     *
     * @return  self
     */ 
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }
    
    /**
     * Get the value of order_id
     */ 
    public function getOrderId()
    {
        return $this->order_id;
    }

    /**
     * Set the value of order_id
     *
     * @return  self
     */ 
    public function setOrderId($orderId)
    {
        $this->order_id = $orderId;

        return $this;
    }

    /**
     * Get the value of product_id
     */ 
    public function getProductId()
    {
        return $this->product_id;
    }

    /**
     * Set the value of product_id
     *
     * @return  self
     */ 
    public function setProductId($productId)
    {
        $this->product_id = $productId;

        return $this;
    }
}