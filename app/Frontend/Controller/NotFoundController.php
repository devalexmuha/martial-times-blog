<?php

namespace App\Frontend\Controller;

use App\Repository\PagesRepository;
use Override;

class NotFoundController extends AbstractController {

    public function __construct(PagesRepository $pagesRepository)
    {
        return parent::__construct($pagesRepository);
    }

    public function error404() {
        return parent::error404();
    }

}