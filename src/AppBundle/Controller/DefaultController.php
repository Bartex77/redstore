<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     *
     * @param Request $request
     *
     * @return Response $response
     */
    public function indexAction(Request $request)
    {
        $session = new Session();

        // could have fetched it from repo, but I find it a good habit to use DP in the controller instead
        $productDataProvider = $this->get('data_provider.product');
        $products = $productDataProvider->fetchProductsNamesByIds();

        $productsInCart = [];
        $productsIdsInCart = $session->get('products');
        foreach ($products as $id => $name) {
            if (isset($productsIdsInCart[$id])) {
                $productsInCart[$id] = $name;
            }
        }

        $addedToCart = [];
        // @todo move form to an external class to avoid fat controller
        // @todo turn form into a service
        $form = $this->createFormBuilder($addedToCart, []
        )->add('ProductsList', ChoiceType::class, array(
            'choices' => array_flip($products),
            'choices_as_values' => true,
            'expanded' => true,
            'multiple' => false,
            'label' => 'Available products:',
            'choice_attr' => function($productId) {
                $session = new Session();
                $products = $session->get('products');

                if (isset($products[$productId])) {
                    return ['disabled' => true];
                }

                return ['disabled' => false];
            },
        ))->add('addToCart', SubmitType::class, array('label' => 'Submit')
        )->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $session = $this->getRequest()->getSession();
            $addedProduct = $form->getData();
            $addedProduct = array_values(array_values($addedProduct));

            if ($addedProduct[0]) {
                $productsInCart = $session->get('products');
                // @todo validate if this product isn't already in the cart
                $productsInCart[$addedProduct[0]] = true;
                $session->set('products', $productsInCart);

                // could have done this via repo, but then again: no repo in controller
                // I used model because I like to keep DP read-only
                $cartLogModel = $this->get('model.cart_log');
                $cartLogModel->addLog($addedProduct[0]);
            }

            return $this->redirectToRoute('homepage');
        }

        return $this->render('AppBundle:Product:productsList.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'productsInCart' => $productsInCart,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/clearCart", name="clearCart")
     *
     * @param Request $request
     *
     * @return RedirectResponse $response
     */
    public function clearCartAction(Request $request)
    {
        $session = $this->getRequest()->getSession();
        $session->set('products', []);

        return $this->redirectToRoute('homepage');
    }
}
