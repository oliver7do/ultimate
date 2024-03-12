<?php

namespace Controller;

use Model\Entity\User;
use Model\Repository\UserRepository;
use Form\UserHandleRequest;
use Service\Search;

class SearchController extends BaseController
{
    public function searchTag() {
        
        Search::searchInDb();
        
    }
    
}