<?php

namespace Model\Repository;

use Model\Entity\Order;
use Service\Session;

class OrderRepository extends BaseRepository
{
    public function insertOrder()
    {        
        $order = new Order;
        $order->setUserId($_SESSION["user"]->getId());

        try {
            
            $this->dbConnection->beginTransaction();
            $sql = "INSERT INTO `order` (state, user_id, created_at) VALUES (:state, :userId, NOW())";

            $request = $this->dbConnection->prepare($sql);

            $request->bindValue(":state", $order->getState());
            $request->bindValue(":userId", $order->getUserId());

            $request = $request->execute();
            $idOrder = $this->dbConnection->lastInsertId();
            
            // Validez la transaction si tout s'est bien passé
            $this->dbConnection->commit();

            if ($request) {
                if ($request == 1) {
                    return $idOrder;
                }
                Session::addMessage("danger",  "Erreur : la commande n'a pas été enregisté");
                return false;
            }
        } catch (\PDOException $e) {

            // En cas d'erreur, annulez la transaction
            $this->dbConnection->rollBack();
            echo "Erreur : " . $e->getMessage();
        }
    }


    public function updateOrder(Order $order)
    {
        $sql = "UPDATE order 
                SET state = :state, user_id = :userId
                WHERE id = :id";
        $request = $this->dbConnection->prepare($sql);
        $request->bindValue(":id", $order->getId());
        $request->bindValue(":state", $order->getState());
        $request->bindValue(":userId", $order->getUserId());
        $request = $request->execute();
        if ($request) {
            if ($request == 1) {
                Session::addMessage("success",  "La mise à jour de la commande a bien été éffectuée");
                return true;
            }
            Session::addMessage("danger",  "Erreur : la commande n'a pas été mise à jour");
            return false;
        }
        Session::addMessage("danger",  "Erreur SQL");
        return null;
    }

}