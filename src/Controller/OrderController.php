<?php

namespace App\Controller;

use App\Entity\Order;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Faker;

class OrderController extends ApiController
{
    public function listOrders(Request $request): Response
    {

        $orders = $this->getDoctrine()->getRepository(Order::class)->findBy([
            'user' => $this->getUser()->getId()
        ]);

        return $this->json($orders);
    }



    public function listOrder(Request $request, $id): Response
    {
        $order= $this->getDoctrine()->getRepository(Order::class)->findOneBy([
            'user' => $this->getUser()->getId(),
            'orderCode' => $id
        ]);

        if (!$order) {
            throw $this->createNotFoundException(
                'No order found for code '.$id
            );
        }

        return $this->json($order);
    }

    public function createOrder(Request $request): Response
    {
        $faker = Faker\Factory::create();
        $orders = $this->getDoctrine()->getManager();
        $request = $this->transformJsonBody($request);
        $shipping_date = Carbon::now()->addMinutes(rand(0,5));
        $order_code = $faker->regexify('[A-Za-z0-9]{20}');
        $address = $request->get('address');
        $quantity = $request->get('quantity');
        $product_id = $request->get('product_id');

        if (empty($product_id) || empty($quantity) || empty($address)){
            return $this->respondValidationError("Invalid Address or Quantity or Product");
        }


        $order = new Order();
        $order->setUsers($this->getUser());
        $order->setShippingDate($shipping_date);
        $order->setOrderCode($order_code);
        $order->setAddress($address);
        $order->setQuantity($quantity);
        $order->setProductId($product_id);
        $orders->persist($order);
        $orders->flush();
        return $this->respondWithSuccess(sprintf('Order %s successfully created', $order->getOrderCode()));
    }


    public function updateOrder(Request $request,$id): Response
    {
        $order= $this->getDoctrine()->getRepository(Order::class)->findOneBy([
            'user' => $this->getUser()->getId(),
            'orderCode' => $id
        ]);

        if (!$order) {
            throw $this->createNotFoundException(
                'No order found for code '.$id
            );
        }
        if ($order->getShippingDate() < Carbon::now()){
            return $this->respondValidationError("Shipping date passed");
        }
        $orders = $this->getDoctrine()->getManager();
        $request = $this->transformJsonBody($request);
        $address = $request->get('address');
        $quantity = $request->get('quantity');
        $product_id = $request->get('product_id');

        if (empty($product_id) || empty($quantity) || empty($address)){
            return $this->respondValidationError("Invalid Address or Quantity or Product");
        }

        $order->setAddress($address);
        $order->setQuantity($quantity);
        $order->setProductId($product_id);
        $orders->persist($order);
        $orders->flush();
        return $this->respondWithSuccess(sprintf('Order %s successfully updated', $order->getOrderCode()));
    }

}