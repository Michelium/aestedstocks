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
            'title' => 'Home',
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
                'action' => $this->generateUrl('admin_home_addproduct'),
            ]);
            $html = $this->renderView('sections/notfound.html.twig', [
                'input' => $input,
                'form' => $productForm->createView(),
            ]);
        } else {
            $html = $this->renderView('sections/found.html.twig', [
                'input' => $input,
                'product' => $product,
            ]);
        }

        return new JsonResponse($html);
    }

    /**
     * @Route("/admin/function/addproduct", name="admin_home_addproduct")
     * @param Request $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function addProduct(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $data = $request->request->get('product');

        $product = new Product();
        $product->setName($data['name']);
        $product->setCode($data['code']);
        $product->setDescription($data['description']);
        $product->setCreatedAt(new \DateTime('now'));

        $em->persist($product);
        $em->flush();

        $this->addFlash('success', 'Het product met code '. $data['code'] . ' is succesvol toegevoegd!');
        return $this->redirectToRoute('admin_home_index');
    }
}
