<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Form\ProductType;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/admin/product", name="admin_product_index")
     */
    public function index() {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository(Product::class)->findAll();

        return $this->render('product/index.html.twig', [
            'title' => 'Producten',
            'products' => $products,
        ]);
    }

    /**
     * @Route("/admin/function/addproduct", name="admin_function_addproduct")
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
        $category = $em->getRepository(Category::class)->find($data['category']);
        $product->setCategory($category);
        $product->setCreatedAt(new \DateTime('now'));

        $em->persist($product);
        $em->flush();

        $this->addFlash('success', 'Het product met code '. $data['code'] . ' is succesvol toegevoegd!');
        $referer = $request->headers->get('referer');
        return new RedirectResponse($referer);
    }

    /**
     * @Route("/admin/function/updateproductform/{id}", name="admin_function_updateproductform")
     * @param $id
     * @return JsonResponse
     */
    public function getUpdateProductForm($id) {
        $em = $this->getDoctrine()->getManager();

        $product = $em->getRepository(Product::class)->find($id);
        if ($product === null) {
            throw $this->createNotFoundException('Product niet gevonden!');
        } else {
            $productForm = $this->createForm(ProductType::class, $product, [
                'input' => $product->getCode(),
                'action' => $this->generateUrl('admin_function_updateproduct', [
                    'id' => $product->getId(),
                ]),
            ]);

            $html = $this->renderView('sections/update_product_form.html.twig', [
                'form' => $productForm->createView(),
            ]);

            return new JsonResponse($html);
        }
    }

    /**
     * @Route("/admin/function/updateproduct/{id}", name="admin_function_updateproduct")
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function updateProduct(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $data = $request->request->get('product');

        $product = $em->getRepository(Product::class)->find($id);
        if ($product === null) {
            $this->addFlash('danger', 'Product niet gevonden!');
        } else {
            $product->setName($data['name']);
            $product->setCode($data['code']);
            $product->setDescription($data['description']);
            $category = $em->getRepository(Category::class)->find($data['category']);
            $product->setCategory($category);
            $product->setModifiedAt(new \DateTime('now'));

            $em->persist($product);
            $em->flush();
        }

        $this->addFlash('success', 'Het product met code '. $data['code'] . ' is succesvol bewerkt!');
        $referer = $request->headers->get('referer');
        return new RedirectResponse($referer);
    }

    /**
     * @Route("/admin/function/deleteproduct/{id}", name="admin_function_deleteproduct")
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function deleteProduct(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $product = $em->getRepository(Product::class)->find($id);

        if ($product === null) {
            $this->addFlash('danger', 'Product niet gevonden!');
        } else {
            $em->remove($product);
            $em->flush();
            $this->addFlash('success', 'Product succesvol verwijderd!');
        }

        $referer = $request->headers->get('referer');
        return new RedirectResponse($referer);
    }

    /**
     * @Route("/admin/function/showproduct/{id}", name="admin_function_showproduct")
     * @param $id
     * @return JsonResponse
     */
    public function showProduct($id) {
        $em = $this->getDoctrine()->getManager();

        $product = $em->getRepository(Product::class)->find($id);

        if ($product === null) {
            throw $this->createNotFoundException('Product niet gevonden!');
        } else {
            $html = $this->renderView('sections/show_product.html.twig', [
                'product' => $product,
            ]);

            return new JsonResponse($html);
        }
    }
}
