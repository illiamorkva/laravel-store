<?php

namespace App\Repositories;

use App\Models\Order;

class OrderRepository
{
    /**
     * Returns an array of orders for the list on the site
     * @return array <p>Array with orders</p>
     */
    public function getOrdersList()
    {
        $ordersList = Order::orderBy('id', 'desc')
            ->get(['id', 'user_name', 'user_phone', 'date', 'status']);

        return $ordersList;
    }

    /**
     * Returns text explanation of status order :<br/>
     * <i>1 - New order, 2 - In processing, 3 - Delivered, 4 - Closed</i>
     * @param integer $status <p>Status</p>
     * @return string <p>Text explanation</p>
     */
    public static function getStatusText($status)
    {
        switch ($status) {
            case '1':
                return 'Новый заказ';
                break;
            case '2':
                return 'В обработке';
                break;
            case '3':
                return 'Доставляется';
                break;
            case '4':
                return 'Закрыт';
                break;
        }
    }

    /**
     * Returns order with specified id
     * @param integer $id <p>Id order</p>
     * @return array <p>Object of information about the order</p>
     */
    public function getOrderById($id)
    {
        return Order::findOrFail($id);
    }
}