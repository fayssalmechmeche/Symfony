<?php

namespace App\Controller;

use App\Class\Cart;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    private $entity;
    private $requestStack;

    public function __construct(RequestStack $requestStack, EntityManagerInterface $entityManager)
    {
        $this->entity = $entityManager;
        $this->requestStack = $requestStack;
    }
    #[Route('/panier', name: 'app_cart')]
    public function index(Cart $cart): Response
    {
        return $this->render('cart/index.html.twig', [
            'cart' => $cart->getFull(),
        ]);
    }


    #[Route('/cart/add/{id}', name: 'app_add_to_cart')]
    public function add(Cart $cart, $id): Response
    {
        $cart->add($id);
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/remove/', name: 'app_remove_my_cart')]
    public function remove(Cart $cart): Response
    {
        $cart->remove();
        return $this->redirectToRoute('app_products');
    }

    #[Route('/cart/delete/{id}', name: 'app_delete_to_cart')]
    public function delete(Cart $cart, $id): Response
    {
        $cart->delete($id);
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/decrease/{id}', name: 'app_decrease_to_cart')]
    public function decrease(Cart $cart, $id): Response
    {
        $cart->decrease($id);
        return $this->redirectToRoute('app_cart');
    }
}
