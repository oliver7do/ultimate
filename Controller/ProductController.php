<?php
/**
 * Summary of namespace Controller
 */
namespace Controller;

use Model\Repository\ProductRepository;

/**
 * Summary of ProductController
 */
class ProductController extends BaseController
{
    public function list()
    {
        error("404.php");
    }
    
    public function show($id)
    {
        if (!empty($id) && is_numeric($id)) {            
            $pr = new ProductRepository;
            $product = $pr->findById('product', $id);
                if (empty($product)) {
                $this->setMessage("danger",  "Le produit NO $id n'existe pas");
                redirection(addLink("home"));
            }
            $this->render("product/show.html.php", [
            "product" => $product,
            "h1" => "Fiche product"
            ]);
        } else {
            error("404.php");
        }
    }
}