<?php

/* ⚠ Il faut inclure le fichier autoload AVANT d'exécuter la fonction session_start() sinon il y aura
        une error si on essaye de stocker un objet dans la variable superglobale $_SESSION */
require "autoload.php";
session_start();
include __DIR__ . "/functions.inc.php";
define("ROOT", "/ultimate/");
define("ROLE_USER", "ROLE_USER");
define("ROLE_ADMIN", "ROLE_ADMIN"); 
define("INSERTED", "Enregistrer"); 
define("UPDATED", "Modifier"); 
define("DELETED", "Spprimr"); 
define("UPLOAD_PRODUCTS_IMG", "uploads/products/");
define("EN_ATTENTE", "En Attente");