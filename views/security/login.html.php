<?php
require "views/errors_form.html.php";
?>

<form method="post">
    <div class="form-group">
        <label for="email">Email <sup>*</sup></label>
        <input type="text" name="email" id="email" class="form-control">
    </div>

    <div class="form-group">
        <label for="password">Mot de passe <sup>*</sup></label>
        <input type="text" name="password" id="password" class="form-control">
    </div>

    <div class="d-flex justify-content-between">
        <button type="submit" class="btn btn-primary" name="login">
            Connexion
        </button>
    </div>
</form>