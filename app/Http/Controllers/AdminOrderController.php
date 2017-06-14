<?php

namespace App\Http\Controllers;

use App\Repositories\OrderRepository;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    /**
     * Instance OrderRepository.
     *
     * @var OrderRepository
     */
    protected $orderRepository;


    public function __construct(OrderRepository $orderRepository)
    {
        $this->middleware(['auth','role:admin']);

        $this->orderRepository = $orderRepository;
    }

    /**
     * Action for page "Manage orders"
     */
    public function actionIndex()
    {
        //Get information about orders
        $ordersList = $this->orderRepository->getOrdersList();

        return view('admin_order.index', [
            'ordersList' => $ordersList
        ]);
    }
}
