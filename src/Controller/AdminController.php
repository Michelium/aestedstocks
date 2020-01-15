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

    /**
     *
     * @Route("/admin/function/addproducttolist/{input}", name="admin_home_addproducttolist")
     * @param $input
     * @return JsonResponse
     */
    public function addProductToMultipleList($input) {
        $em = $this->getDoctrine()->getManager();

        $product = $em->getRepository(Product::class)->findOneBy(["code" => $input]);

        if ($product === null) {
            $html = $this->renderView('sections/addproducttolist_row.html.twig', ['found' => false]);
        } else {
            $html = $this->renderView('sections/addproducttolist_row.html.twig', [
                'found' => true,
                'product' => $product,
            ]);
        }

        return new JsonResponse($html);
    }

    /**
     * @Route("/admin/function/submitproductlist", name="admin_home_submitproductlist")
     * @param Request $request
     * @return JsonResponse
     */
    public function submitProductList(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $items = $request->get('items');

        $counted = array_count_values($items);

        foreach ($counted as $key => $value) {
            $product = $em->getRepository(Product::class)->find($key);
            $product->setStock($product->getStock() + $value);

            $em->persist($product);
            $em->flush();
            unset($product);
        }

        return new JsonResponse($counted);
    }
}
