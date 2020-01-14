<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController {

    /**
     * @Route("/admin", name="admin_home_index")
     */
    public function index() {
        return $this->render('home/index.html.twig', [
            'title' => 'Scan',
        ]);
    }

    /**
     * @Route("/admin/function/scaninput/{input}", name="admin_home_scaninput")
     * @param $input
     * @return JsonResponse
     */
    public function scanProduct($input) {
        $em = $this->getDoctrine()->getManager();

        $product = $em->getRepository(Product::class)->findOneBy(["code" => $input]);

        if ($product === null) {
            $productForm = $this->createForm(ProductType::class, null, [
                'input' => $input,
                'action' => $this->generateUrl('admin_function_addproduct'),
            ]);
            $html = $this->renderView('sections/notfound.html.twig', [
                'input' => $input,
                'form' => $productForm->createView(),
            ]);
        } else {
            $productForm = $this->createForm(ProductType::class, $product, [
                'input' => $input,
                'action' => $this->generateUrl('admin_function_updateproduct', [
                    'id' => $product->getId(),
                ]),
            ]);
            $html = $this->renderView('sections/found.html.twig', [
                'input' => $input,
                'product' => $product,
                'form' => $productForm->createView(),
            ]);
        }

        return new JsonResponse($html);
    }
}
