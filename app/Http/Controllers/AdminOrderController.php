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

    /**
     * Action for page "Update order"
     */
    public function actionUpdate(Request $request, $id)
    {
        // Get data about current order
        $order = $this->orderRepository->getOrderById($id);

        if ($request->isMethod('post')) {

            $order->user_name = $request->input('userName');
            $order->user_phone = $request->input('userPhone');
            $order->user_comment = $request->input('userComment');
            $order->date = $request->input('date');
            $order->status = $request->input('status');
            $order->save();

            return redirect("/admin/order/view/$id");
        }
        return view('admin_order.update', [
            'order' => $order,
            'id' => $id
        ]);
    }
}
