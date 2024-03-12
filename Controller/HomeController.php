<?php

namespace Controller;

use Model\Entity\Product;
use Form\ProductHandleRequest;
use Model\Repository\ProductRepository;
use Controller\BaseController;

class HomeController extends BaseController
{
    private ProductRepository $productRepository;
    private ProductHandleRequest $form;
    private Product $product;

    public function __construct()
    {
        $this->productRepository = new ProductRepository;
        $this->form = new ProductHandleRequest;
        $this->product = new Product;
    }
    public function list()
    {
        $products = $this->productRepository->findAll($this->product);
        $this->render("home.html.php", [
            "h1" => "Liste des produits",
            "products" => $products
        ]);
    }
}