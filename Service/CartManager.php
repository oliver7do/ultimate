<?php

namespace Service;

use Model\Repository\ProductRepository;

/**
 * Summary of ProductController
 */
class CartManager
{
    private ProductRepository $productRepository;

    public function __construct()
    {
        $this->productRepository = new ProductRepository;
    }

    public function addCart($id){
        $quantity = $_GET["qte"] ?? 1;
        $pr = $this->productRepository;
        $product = $pr->findById('product', $id);

        if(!isset($_SESSION["cart"]))
            $_SESSION["cart"] = [];
        
        $cart = $_SESSION["cart"]; // on récupère ce qu'il y a dans le cart en session

        $productDejaDanscart = false;
        foreach ($cart as $indice => $value) {
            if ($product->getId() == $value["product"]->getId()) {
                $cart[$indice]["quantity"] += $quantity;
                $productDejaDanscart = true;
                break;  // pour sortir de la boucle foreach
            }
        }
        
        if (!$productDejaDanscart) {
            $cart[] = ["quantity" => $quantity, "product" => $product];  // on ajoute une value au cart => $cart est un array d'array
        }
        
        $_SESSION["cart"] = $cart;  // je remets $cart dans la session, à l'indice 'cart'
        
        $nb = 0;
        foreach ($cart as $value){
            $nb += $value["quantity"];
        }
        $_SESSION["nombre"] = $nb;
        return $nb;
    }
}