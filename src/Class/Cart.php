<?php

namespace App\Class;

use App\Entity\Product;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart
{
    private $session;
    private $entity;
    public function __construct(EntityManagerInterface $entity,  RequestStack $requestStack)
    {

        $this->entity = $entity;
        $this->session = $requestStack;
    }
    public function add($id)
    {
        $cart = $this->session->getSession()->get('cart', []);

        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }
        $this->session->getSession()->set('cart', $cart);
    }

    public function get()
    {
        return $this->session->getSession()->get('cart');
    }

    public function getFull()
    {
        $cartComplete = [];
        if ($this->get()) {
            foreach ($this->get() as $id => $quantity) {
                $product_object = $this->entity->getRepository(Product::class)->findOneById($id);
                if (!$product_object) {
                    $this->delete($id);
                    continue;
                }
                $cartComplete[] = [
                    'product' => $product_object,
                    'quantity' => $quantity
                ];
            }
        }
        return $cartComplete;
    }

    public function remove()
    {
        return $this->session->getSession()->remove('cart');
    }
    public function delete($id)
    {
        $cart = $this->session->getSession()->get('cart', []);
        unset($cart[$id]);
        return  $this->session->getSession()->set('cart', $cart);
    }
    public function decrease($id)
    {

        $cart = $this->session->getSession()->get('cart', []);

        if ($cart[$id] > 1) {
            $cart[$id]--;
        } else {
            unset($cart[$id]);
        };

        return  $this->session->getSession()->set('cart', $cart);
    }
}
