<?php

namespace App\Controller;

use App\Entity\Page;
use App\Form\PageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/admin", name="admin_page_")
 */
class PageController extends AbstractController {

    private $translator;

    public function __construct(TranslatorInterface $translator) {
        $this->translator = $translator;
    }

    /**
     * @Route("/page", name="index")
     */
    public function index() {

        $pages = $this->getDoctrine()->getRepository(Page::class)->findAll();

        return $this->render('admin/page/index.html.twig', [
            'title' => 'Pages',
            'pages' => $pages,
        ]);
    }

    /**
     * @Route("/page/form/{id}", name="form", defaults={"id" : 0})
     */
    public function form(Request $request, $id = null) {
        $em = $this->getDoctrine()->getManager();

        $page = $em->getRepository(Page::class)->find($id);

        if ($page === null) {
            $page = new Page();
            $page->setCreatedBy($this->getUser());
        }

        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $page->setModifiedBy($this->getUser());
            $page->setModifiedAt(new \DateTime('now'));
            $em->persist($page);
            $em->flush();

            $this->addFlash('success', $this->translator->trans('page_created_success'));
            return $this->redirectToRoute('admin_page_index');
        }

        return $this->render('admin/page/form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Pages form',
        ]);
    }
}
