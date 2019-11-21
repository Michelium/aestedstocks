<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin_page_")
 */
class PageController extends AbstractController
{
    /**
     * @Route("/page", name="index")
     */
    public function index()
    {
        return $this->render('admin/page/index.html.twig', [
            'title' => 'Pages',
        ]);
    }
}
