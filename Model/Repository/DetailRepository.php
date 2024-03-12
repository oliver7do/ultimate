<?php

namespace Model\Repository;

use Model\Entity\Order;
use Model\Entity\Detail;
use Service\Session;

class DetailRepository extends BaseRepository
{
    public function insertDetail($productId, $orderId, $quantity)
    {
        $detail = new Detail;
        $detail->setQuantity($quantity)
            ->setOrderId($orderId)
            ->setProductId($productId);
        
        try {
            $this->dbConnection->beginTransaction();

            $sql = "INSERT INTO `detail` (quantity, order_id, product_id, created_at) VALUES (:quantity, :orderId, :productId, NOW())";

            $request = $this->dbConnection->prepare($sql);
            
            $request->bindValue(":quantity", $quantity);
            $request->bindValue(":orderId", $orderId);
            $request->bindValue(":productId", $productId);

            $request = $request->execute();
            
            // Validez la transaction si tout s'est bien passé
            $this->dbConnection->commit();

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