<?php

namespace Model\Repository;

use Model\Entity\Category;
use Service\Session;

class CategoryRepository extends BaseRepository
{
    public function findByType($type)
    {
        $request = $this->dbConnection->prepare("SELECT * FROM category WHERE type = :type");
        $request->bindParam(":type", $type);

        if ($request->execute()) {
            if ($request->rowCount() == 1) {
                $request->setFetchMode(\PDO::FETCH_CLASS, "Model\Entity\Category");
                return $request->fetch();
            } else {
                return false;
            }
        } else {
            return null;
        }
    }
    public function checkCategoryExists($type)
    {
        $request = $this->dbConnection->prepare("SELECT COUNT(*) FROM category WHERE type = :type");
        $request->bindParam(":type", $type);

        $request->execute(); 
        $count = $request->fetchColumn();
        return $count > 1 ? true : false;
    }

    public function insertCategory(Category $category)
    {
        $sql = "INSERT INTO category (type, created_at) VALUES (:type, NOW())";
        $request = $this->dbConnection->prepare($sql);
        $request->bindValue(":type", $category->getType());

        $request = $request->execute();
        if ($request) {
            if ($request == 1) {
                Session::addMessage("success",  "Le nouvel utilisateur a bien été enregistré");
                return true;
            }
            Session::addMessage("danger",  "Erreur : l'utilisateur n'a pas été enregisté");
            return false;
        }
        Session::addMessage("danger",  "Erreur SQL");
        return null;
    }


    public function updateCategory(Category $category)
    {
        $sql = "UPDATE $category 
                SET type = :type, updated_at = NOW() WHERE id = :id";
        $request = $this->dbConnection->prepare($sql);
        $request->bindValue(":id", $category->getId());
        $request->bindValue(":type", $category->getType());
        $request = $request->execute();
        if ($request) {
            if ($request == 1) {
                Session::addMessage("success",  "La mise à jour de l'utilisateur a bien été éffectuée");
                return true;
            }
            Session::addMessage("danger",  "Erreur : l'utilisateur n'a pas été mise à jour");
            return false;
        }
        Session::addMessage("danger",  "Erreur SQL");
        return null;
    }
}