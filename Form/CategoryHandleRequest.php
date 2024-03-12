<?php

namespace Form;

use Service\Session as Sess;
use Model\Entity\Category;
use Model\Repository\CategoryRepository;

class CategoryHandleRequest extends BaseHandleRequest
{
    private $categoryRepository;

    public function __construct()
    {
        $this->categoryRepository  = new CategoryRepository;
    }

    public function handleInsertForm(Category $category)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            extract($_POST);
            $errors = [];

            // Vérification de la validité du formulaire
            if (empty($type)) {
                $errors[] = "Le type de categorie ne peut pas être vide";
            }
            

            // Est-ce que le type existe déjà dans la bdd ?

            $categoryExists = $this->categoryRepository->checkCategoryExists($type);

            //$categoryExists = $this->categoryRepository->findByAttributes($category, ["type" => $type]);
            
            if ($categoryExists) {
                $errors[] = "Le type existe déjà, veuillez en choisir un nouveau";
            }

            if (empty($errors)) {
                $category->setType($type);                
                return $this;
            }
            
            $this->setEerrorsForm($errors);
            return $this;
        }
    }
    public function handleEditForm(Category $category)
    {
        if (($_SERVER['REQUEST_METHOD'] === 'POST')) {

            extract($_POST);
            $errors = [];

            // Vérification de la validité du formulaire
            if (empty($type)) {
                $errors[] = "Le type de categorie ne peut pas être vide";
            }
            

            // Est-ce que le type existe déjà dans la bdd ?

            $categoryExists = $this->categoryRepository->checkCategoryExists($type);
            
            if ($categoryExists) {
                $errors[] = "Le type existe déjà, veuillez en choisir un nouveau";
            }

            if (empty($errors)) {
                $category->setType($type);
                return $this;
            }
            
            $this->setEerrorsForm($errors);
            return $this;
        }
    }

}