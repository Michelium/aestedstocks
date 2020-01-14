<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController {

    /**
     * @Route("/admin", name="admin_home_index")
     */
    public function index() {
        return $this->render('home/index.html.twig', [
            'title' => 'Home',
        ]);
    }
}
