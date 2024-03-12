<?php
/**
 * Summary of namespace Controller
 */
namespace Controller;

use Model\Entity\User;
use Model\Repository\UserRepository;
use Form\UserHandleRequest;

/**
 * Summary of UserController
 */
class UserController extends BaseController
{
    private UserRepository $userRepository;
    private UserHandleRequest $form;
    private User $user;

    public function __construct()
    {
        $this->userRepository = new UserRepository;
        $this->form = new UserHandleRequest;
        $this->user = new User;
    }

    public function list()
    {
        $users = $this->userRepository->findAll($this->user);

        $this->render("user/index.html.php", [
            "h1" => "Liste des utilisateurs",
            "users" => $users
        ]);
    }

    public function new()
    {
        $user = $this->user;
        $this->form->handleInsertForm($user);

        if ($this->form->isSubmitted() && $this->form->isValid()) {
            
            $this->userRepository->insertUser($user);
            return redirection(addLink("home"));
        }

        $errors = $this->form->getEerrorsForm();
        
        return $this->render("user/form.html.php", [
            "h1" => "Ajouter un nouvel utilisateur",
            "user" => $user,
            "errors" => $errors
        ]);
    }

    /**
     * Summary of edit
     * @param mixed $id
     * @return void
     */
    public function edit($id)
    {
        if (!empty($id) && is_numeric($id) && $this->getUser()) {

            /**
             * @var User
             */
            $user = $this->getUser();

            $this->form->handleEditForm($user);

            if ($this->form->isSubmitted() && $this->form->isValid()) {
                $this->userRepository->updateUser($user);
                return redirection(addLink("home"));
            }

            $errors = $this->form->getEerrorsForm();
            return $this->render("user/form.html.php", [
                "h1" => "Update de l'utilisateur n° $id",
                "user" => $user,
                "errors" => $errors
            ]);
        }
        return redirection("/errors/404.php");
    }

    public function delete($id)
    {
        if (!empty($id) && $id && $this->getUser()) {
            if (is_numeric($id)) {

                $user = $this->user;
            } else {
                $this->setMessage("danger",  "ERREUR 404 : la page demandé n'existe pas");
            }
        } else {
            $this->setMessage("danger",  "ERREUR 404 : la page demandé n'existe pas");
        }

        $this->render("user/form.html.php", [
            "h1" => "Suppresion de l'user n°$id ?",
            "user" => $user,
            "mode" => "suppression"
        ]);
    }

    public function show($id)
    {
        if ($id) {
            if (is_numeric($id)) {
                $user = $this->user;
            } else {
                $this->setMessage("danger",  "Erreur 404 : cette page n'existe pas");
            }
        } else {
            $this->setMessage("danger",  "Erreur 403 : vous n'avez pas accès à cet URL");
            redirection(addLink("user", "list"));
        }

        $this->render("user/show.html.php", [
            "user" => $user,
            "h1" => "Fiche user"
        ]);
    }

    public function login()
    {
        
        if ($this->isUserConnected()) {            
            /**
             * @var User
             */
            $user = $this->getUser();

                $this->setMessage("erreur",  $user->getSurname() . " , vous êtes déjà connecté");
            return redirection(addLink("home"));
        }

        $this->form->handleLogin();
        
        if ($this->form->isSubmitted() && $this->form->isValid()) {
            /**
             * @var User
             */
            $user = $this->getUser();
            $this->setMessage("succes", "Bonjour " . $user->getSurname() .", vous êtes connecté");
            redirection(addLink("home"));
            return redirection(addLink("home"));
        }

        $errors = $this->form->getEerrorsForm();

        return $this->render("security/login.html.php", [
            "h1" => "Entrez vos identifiants de connexion",
            "errors" => $errors
            
        ]);
    }

    public function logout()
    {
        $this->disconnection();
        $this->setMessage("success", "Vous êtes déconnecté");
        redirection(addLink("home"));
    }
}