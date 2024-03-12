<?php
namespace Model\Entity;

class Order extends BaseEntity
{ 
    private $state;
    private $user_id;

    public function __construct()
    {
        $this->state = EN_ATTENTE;
    }

    /**
     * Get the value of state
     */ 
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set the value of state
     *
     * @return  self
     */ 
    public function setState($state = null)
    {
        
        $this->state = $state !== null ? $state : EN_ATTENTE;        

        return $this;
    }

    /**
     * Get the value of user_id
     */ 
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     *
     * @return  self
     */ 
    public function setUserId($userId)
    {
        $this->user_id = $userId;

        return $this;
    }

}