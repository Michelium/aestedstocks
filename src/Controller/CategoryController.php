<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/admin/category", name="admin_category_index")
     */
    public function index() {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository(Category::class)->findAll();

        return $this->render('category/index.html.twig', [
            'title' => 'Categoriën',
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/admin/function/categoryform/{id}", name="admin_function_categoryform")
     */
    public function getCategoryForm($id = 0) {
        $em = $this->getDoctrine()->getManager();

        $category = $id === 0 ? new Category() : $em->getRepository(Category::class)->find($id);
        $actionId = $id === 0 ? null : $id;

        $form = $this->createForm(CategoryType::class, $category, [
            'action' => $this->generateUrl('admin_function_categoryformaction', [
                'id' => $actionId,
            ]),
        ]);

        $html = $this->renderView('sections/categoryform.html.twig', [
            'form' => $form->createView(),
        ]);

        return new JsonResponse($html);
    }

    /**
     * @Route("/admin/function/categoryformaction/{id}", name="admin_function_categoryformaction")
     */
    public function categoryFormAction(Request $request, $id = 0) {
        $em = $this->getDoctrine()->getManager();
        $data = $request->request->get('category');

        $category = $id === 0 ? new Category() : $em->getRepository(Category::class)->find($id);

        $category->setName($data['name']);
        $category->setCreatedAt(new \DateTime('now'));
        if ($id !== 0 ) { $category->setModifiedAt(new \DateTime('now'));}

        $em->persist($category);
        $em->flush();

        $this->addFlash('success', 'Categorie actie succesvol!');
        $referer = $request->headers->get('referer');
        return new RedirectResponse($referer);
    }

    /**
     * @Route("/admin/function/deletecategory/{id}", name="admin_function_deletecategory")
     */
    public function deleteProduct(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $category = $em->getRepository(Category::class)->find($id);

        if ($category === null) {
            $this->addFlash('danger', 'Categorie niet gevonden!');
        } else {
            $em->remove($category);
            $em->flush();
            $this->addFlash('success', 'Categorie succesvol verwijderd!');
        }

        $referer = $request->headers->get('referer');
        return new RedirectResponse($referer);
    }
}
