<?php
/**
 * Summary of namespace Controller
 */
namespace Controller\Admin;

use Controller\BaseController;
use Model\Entity\Product;
use Model\Entity\Category;
use Form\ProductHandleRequest;
use Model\Repository\ProductRepository;
use Model\Repository\CategoryRepository;
use Service\ImageHandler;

/**
 * Summary of ProductController
 */
class ProductController extends BaseController
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
        $products = $this->productRepository->findProductAndCategory();
        
        $this->render("admin/product/index.html.php", [
            "h1" => "Liste des produits",
            "products" => $products
        ]);
    }

    public function new()
    {
        $product = $this->product;

        $this->form->handleInsertForm($product);

        if ($this->form->isSubmitted() && $this->form->isValid()) {
            
            ImageHandler::handelPhoto($product);
            
            $this->productRepository->insertProduct($product);
            
            return redirection(addLink("home"));
        }

        $errors = $this->form->getEerrorsForm();

        $category = new Category;        
        $categorieRepository = new CategoryRepository;
        $categories = $categorieRepository->findAll($category);

        return $this->render("product/form.html.php", [
            "h1" => "Ajouter un nouveau produit",
            "product" => $product,
            "errors" => $errors,
            "categories"=> $categories
        ]);
    }

    /**
     * Summary of edit
     * @param mixed $id
     * @return void
     */
    public function edit($id)
    {
        if (!empty($id) && is_numeric($id)) {

            /**
             * @var Product
             */
            $product = $this->product;

            $this->form->handleEditForm($product);

            if ($this->form->isSubmitted() && $this->form->isValid()) {
                $this->productRepository->updateProduct($product);
                return redirection(addLink("home"));
            }

            $errors = $this->form->getEerrorsForm();
            return $this->render("product/form.html.php", [
                "h1" => "Update de l'utilisateur n° $id",
                "product" => $product,
                "errors" => $errors
            ]);
        }
        return redirection("/errors/404.php");
    }

    public function delete($id)
    {
        if (!empty($id) && $id > 0) {
            if (is_numeric($id)) {

                $product = $this->product;
            } else {
                $this->setMessage("danger",  "ERREUR 404 : la page demandé n'existe pas");
            }
        } else {
            $this->setMessage("danger",  "ERREUR 404 : la page demandé n'existe pas");
        }

        $this->render("product/form.html.php", [
            "h1" => "Suppresion du produit n°$id ?",
            "product" => $product,
            "mode" => "suppression"
        ]);
    }

    public function show($id)
    {
        if ($id) {
            if (is_numeric($id)) {

                $product = $this->productRepository->findProductAndCategoryById($id);
                $product->setCategory($product);
                
            } else {
                $this->setMessage("danger",  "Erreur 404 : cette page n'existe pas");
            }
        } else {
            $this->setMessage("danger",  "Erreur 403 : vous n'avez pas accès à cet URL");
            redirection(addLink("product", "list"));
        }

        $this->render("product/show.html.php", [
            "product" => $product,
            "h1" => "Fiche product"
        ]);
    }
}