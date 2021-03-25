<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;
use App\User;
use App\OrderStatus;
use Session;
use Mail;

class OrdersController extends Controller
{
    
	public function orders()
	{
		Session::put('page','orders');
		$orders = Order::with('orders_product')->orderBy('id','DESC')->get()->toArray();
		//dd($orders);
		return view('admin.orders.orders')->with(compact('orders'));
	}

	public function orderDetails($id)
	{
		$orderDetails = Order::with('orders_product')->where('id',$id)->orderBy('id','DESC')->first()->toArray();

		$orderStatus = OrderStatus::where('status',1)->get()->toArray();
		$userDetails = User::where('id', $orderDetails['user_id'])->first()->toArray();
		return view('admin.orders.order_details')->with(compact('orderDetails','userDetails','orderStatus'));
	}

	public function updateOrderStatus(Request $request)
	{
		if ($request->isMethod('post')) {
			$data = $request->all();

			//update order status
			Order::where('id', $data['order_id'])->update(['order_status'=>$data['order_status']]);
			Session::put('success','Order status has been updated successfully!');

			//send order status update Email
			$deliveryDetails = Order::select('email','name')->where('id', $data['order_id'])->first()->toArray();
			//dd($deliveryDetails);
			$orderDetails = Order::with('orders_product')->where('id', $data['order_id'])->first()->toArray();
                
                //send order email
                $email = $deliveryDetails['email'];
                $messageData = [
                    'email' => $email,
                    'name' => $deliveryDetails['name'],
                    'order_id' => $data['order_id'],
                    'order_status' => $data['order_status'],
                    'orderDetails' => $orderDetails
                ];

                Mail::send('emails.order_status', $messageData, function($message) use($email){
                    $message->to($email)->subject('Order Status Update - Mojar Shopping');
                });
			return redirect()->back();
		}
	}

}

