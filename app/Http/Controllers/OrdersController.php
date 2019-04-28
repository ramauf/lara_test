<?php

namespace App\Http\Controllers;


use App\Order;
use App\Partner;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    private $orderStatusList = [
        0 => 'новый',
        10 => 'подтвержден',
        20 => 'завершен',
    ];

    public function pogoda(Request $request){
        $client = new Client();
        $result = $client->request('get', 'http://api.openweathermap.org/data/2.5/forecast?lat=53.2968804&lon=34.2312728&appid=df6c7d1d86eddbf41b64d5b504f9aa75');
        $data = json_decode($result->getBody()->getContents(), true);
        return view('main', [
            'temp' => $data['list'][0]['main']['temp'] - 273,
            'template' => 'pogoda_v_brianske'
        ]);
    }

    public function catalog(Request $request){
        $query = $data = [
            'overdue' => [],
            'current' => [],
            'new' => [],
            'complete' => []
        ];
        $query['overdue'] = Order::with('partners')->with('products')
            ->where('delivery_dt', '<', \DB::raw('NOW()'))
            ->where('status', '10')
            ->orderBy('delivery_dt', 'DESC')->limit(50)->get()->toArray();
        $query['current'] = Order::with('partners')->with('products')
            ->where('delivery_dt', '>', \DB::raw('NOW()'))
            ->where('delivery_dt', '<', \DB::raw('DATE_ADD(NOW(), INTERVAL 1 DAY)'))
            ->where('status', '10')
            ->orderBy('delivery_dt', 'ASC')->get()->toArray();
        $query['new'] = Order::with('partners')->with('products')
            ->where('delivery_dt', '>', \DB::raw('NOW()'))
            ->where('status', '0')
            ->orderBy('delivery_dt', 'ASC')->limit(50)->get()->toArray();
        $query['complete'] = Order::with('partners')->with('products')
            ->where('delivery_dt', '>', \DB::raw('DATE_ADD(NOW(), INTERVAL -1 DAY)'))//дата доставки в текущие сутки не совсем понятно
            ->where('delivery_dt', '<', \DB::raw('NOW()'))
            ->where('status', '20')
            ->orderBy('delivery_dt', 'DESC')->limit(50)->get()->toArray();
        foreach ($query as $type => $orders){
            foreach ($orders as $order){
                $items = [];
                $order['price'] = 0;
                foreach ($order['products'] as $product){
                    $order['price'] += $product['pivot']['price'] * $product['pivot']['quantity'];
                    $items[] = $product['name'];
                }
                $order['status'] = $this->orderStatusList[$order['status']];
                $order['items'] = implode(', ', $items);
                $data[$type][] = $order;
            }
        }
        return view('main', [
            'data' => $data,
            'template' => 'orders'
        ]);
    }

    public function view(Request $request, $id){
        $order = Order::query()->where('id', $id)->with('partners')->with('products')->firstOrFail()->toArray();
        $partners = Partner::all()->toArray();
        $order['price'] = 0;
        foreach ($order['products'] as $product){
            $items[] = $product['name'];
            $order['price'] += $product['pivot']['price'] * $product['pivot']['quantity'];
        }
        return view('main', [
            'order' => $order,
            'statusList' => $this->orderStatusList,
            'partners' => $partners,
            'template' => 'order'
        ]);
    }

    public function update(Request $request, $id){
        $order = Order::query()->where('id', $id)->with('partners')->with('products.vendors')->firstOrFail();
        $udated = $order->update([
            'client_email' => $request->post('client_email'),
            'partner_id' => $request->post('partner_id'),
            'status' => $request->post('status')
        ]);
        if (!$udated)
            return false;
        $order = $order->toArray();
        $items = [];
        $emails = [$order['client_email']];
        $emails[] = $order['partners']['email'];
        $price = 0;
        foreach ($order['products'] as $product){
            $price += $product['pivot']['price'] * $product['pivot']['quantity'];
            $items[] = $product['name'];
            $emails[] = $product['vendors']['email'];
        }



        if ($request->post('status') == 20){
            $subject = 'заказ №'.$id.' завершен';
            $message = 'состав заказа: '.implode(', ', $items).', стоимость заказа: '.$price;
            //mailAdapterFunction($emails, $subject, $message);//заглушка, т.к. у меня нет информации о ваших почтовых сервисах
        }
        return redirect('/orders/'.$id);
    }
}
