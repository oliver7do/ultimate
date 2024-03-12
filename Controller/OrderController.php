<?php
/**
 * Summary of namespace Controller
 */
namespace Controller;

use Model\Repository\DetailRepository;
use Model\Repository\OrderRepository;
use Model\Repository\ProductRepository;

/**
 * Summary of OrderController
 */
class OrderController extends BaseController
{
    private ProductRepository $productRepository;
    private OrderRepository $orderRepository;
    private DetailRepository $detailRepository;

    public function __construct()
    {
        $this->productRepository = new ProductRepository;
        $this->orderRepository = new OrderRepository;
        $this->detailRepository = new DetailRepository;

    }   

    public function confirm()
    {
        if(!$this->isUserConnected()){
            redirection(addLink("user", "login"));
        }
        if(!$_SESSION["cart"]){
            
            $this->setMessage("info",  "Votre panier est vide");
            $this->redirectToRoute(["cart", "show"]);
        }

        $cart = $_SESSION["cart"];
        
        $orderId = $this->orderRepository->insertOrder();
        
        foreach ($cart as $value) {   

            $this->detailRepository->insertDetail($value["product"]->getId(), $orderId, $value["quantity"]);
            
            $this->productRepository->updateQuantityInProduct($value["product"]->getId(), $value["quantity"]); 
        }
        $this->remove("cart");
        $this->remove("nombre");
        
        $this->setMessage("success", "Votre commande a été enregistrée");
        $this->redirectToRoute(["home"]);
    
    }

    /**
     * Summary of edit
     * @param mixed $id
     * @return void
     */
    public function edit($id)
    {
        
    }

    public function delete($id)
    {
        
    }

    public function show($id)
    {
        
    }
}