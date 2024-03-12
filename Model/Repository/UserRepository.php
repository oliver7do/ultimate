<?php

namespace Model\Repository;

use Model\Entity\User;
use Service\Session;

class UserRepository extends BaseRepository
{
    public function findBySurname($surname)
    {
        $request = $this->dbConnection->prepare("SELECT * FROM user WHERE surname = :surname");
        $request->bindParam(":surname", $surname);

        if ($request->execute()) {
            if ($request->rowCount() == 1) {
                $request->setFetchMode(\PDO::FETCH_CLASS, "Model\Entity\User");
                return $request->fetch();
            } else {
                return false;
            }
        } else {
            return null;
        }
    }
    public function checkUserExist($surname, $email)
    {
        $request = $this->dbConnection->prepare("SELECT COUNT(*) FROM user WHERE email = :email OR surname = :surname");
        $request->bindParam(":surname", $surname);
        $request->bindParam(":email", $email);

        $request->execute(); 
        $count = $request->fetchColumn();
        return $count > 1 ? true : false;
    }

    public function insertUser(User $user)
    {
        $sql = "INSERT INTO user (gender, firstname, lastname, surname, password, email, birthday, role, created_at) VALUES (:gender, :firstname, :lastname, :surname, :password, :email, :birthday, :role, NOW())";
        $request = $this->dbConnection->prepare($sql);
        $request->bindValue(":gender", $user->getGender());
        $request->bindValue(":firstname", $user->getFirstname());
        $request->bindValue(":lastname", $user->getLastname());
        $request->bindValue(":surname", $user->getSurname());
        $request->bindValue(":password", $user->getPassword());
        $request->bindValue(":email", $user->getEmail());
        $request->bindValue(":birthday", $user->getBirthday());
        $request->bindValue(":role", $user->getRole());

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


    public function updateUser(User $user)
    {
        $sql = "UPDATE user 
                SET gender = :gender, firstname = :firstname, lastname = :lastname, surname = :surname, password = :password, email = :email, birthday = :birthday, role = :role
                WHERE id = :id";
        $request = $this->dbConnection->prepare($sql);
        $request->bindValue(":id", $user->getId());
        $request->bindValue(":gender", $user->getGender());
        $request->bindValue(":firstname", $user->getFirstname());
        $request->bindValue(":lastname", $user->getLastname());
        $request->bindValue(":surname", $user->getSurname());
        $request->bindValue(":password", $user->getPassword());
        $request->bindValue(":email", $user->getEmail());
        $request->bindValue(":birthday", $user->getBirthday());
        $request->bindValue(":role", $user->getRole());
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

    public function loginUser($email) {        
        $request = $this->dbConnection->prepare("SELECT * FROM user WHERE email = :email");
        $request->bindParam(":email", $email);

        if ($request->execute()) {
            if ($request->rowCount() == 1) {
                $request->setFetchMode(\PDO::FETCH_CLASS, "Model\Entity\User");
                return $request->fetch();
            } else {
                return false;
            }
        } else {
            return null;
        }
    }
}