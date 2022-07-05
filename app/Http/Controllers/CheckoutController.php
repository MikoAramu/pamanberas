<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Cart;
use App\Models\Transaction;
use App\Models\TransactionDetail;

use Exception;
 
use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Notification;

class CheckoutController extends Controller
{
    public function process(Request $request)
    {
        // TODO: Save users data
        $user = Auth::user();
        $user->update($request->except('total_price'));

        // Proses checkout
        $code = 'PRODUCT-' . mt_rand(0000,9999);
        $carts = Cart::with(['product','user'])
                    ->where('users_id', Auth::user()->id_user)
                    ->get();

         // Hitung total price
         $totalPrice = 0;
         foreach ($carts as $cart) {
             $totalPrice += $cart->quantity * $cart->product->price;
         }

        $transaction = Transaction::insertGetId([
            'users_id' => Auth::user()->id_user,
            'delivering_price' => 0,
            'total_price' => $totalPrice,
            'transaction_status' => 'PROCESS',
            'code' => $code,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        //transaction detail
        foreach ($carts as $cart) {

            TransactionDetail::create([
                'transactions_id' => $transaction,
                'products_id' => $cart->product->id_product,
                'price' => $cart->product->price,
                'delivering_status' => 'PENDING',
                'code' => $code,
                'quantity' => $cart->quantity,
            ]);
        }
        // Delete cart data
        Cart::where('users_id', Auth::user()->id_user)
            ->delete();

        // Konfigurasi midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        // Buat array untuk dikirim ke midtrans
        $midtrans = [
            'transaction_details' => [
                'order_id' => $code,
                'gross_amount' => (int) $totalPrice,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
            'enabled_payments' => [
                'gopay', 'bank_transfer'
            ],

            'vt_web' => []
        ];

        try {
            // Ambil halaman payment midtrans
            $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;

            // Redirect ke halaman midtrans
            return redirect($paymentUrl);
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getStatusMidtrans($orderId) {
        $auth = "Basic U0ItTWlkLXNlcnZlci1EajRCbDBnYk5uaHNDNVd2UnB4d1NVM2o6";
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.sandbox.midtrans.com/v2/" . $orderId . "/status",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_POSTFIELDS =>"\n\n",
        CURLOPT_HTTPHEADER => array(
            "Accept: application/json",
            "Content-Type: application/json",
            "Authorization: " . $auth,
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);
    }

    public function callback($request)
    {
        $transaction = $request->transaction_status;
        $fraud = $request->fraud_status;

        // Storage::put('file.txt', $transaction);
        if ($transaction == 'capture') {
            if ($fraud == 'challenge') {
              // TODO Set payment status in merchant's database to 'challenge'
              
              Transaction::where('code',$request->order_id)->update([
                'status_pay' => 'FAILED',
                'transaction_status' => 'PENDING'
            ]);
            
              
            }else if ($fraud == 'accept') {
              // TODO Set payment status in merchant's database to 'success'
              
              Transaction::where('code',$request->order_id)->update([
                'status_pay' => 'SUCCESS',
                'transaction_status' => 'PROCCESS'
            ]);
            
              
            }
        }else if ($transaction == 'cancel') {
            if ($fraud == 'challenge') {
              // TODO Set payment status in merchant's database to 'failure'
              Transaction::where('code',$request->order_id)->update([
                'status_pay' => 'FAILED',
                'transaction_status' => 'PENDING'
            ]);
            
              
            }else if ($fraud == 'accept') {
              // TODO Set payment status in merchant's database to 'failure'

              Transaction::where('code',$request->order_id)->update([
                'status_pay' => 'CANCEL',
                'transaction_status' => 'PENDING'
            ]);
            
            }
        }else if ($transaction == 'deny') {
            // TODO Set payment status in merchant's database to 'failure' 

            Transaction::where('code',$request->order_id)->update([
                'status_pay' => 'FAILED',
                'transaction_status' => 'PENDING'
            ]);
            
              
        }else if($transaction == 'pending') {
                Transaction::where('code',$request->order_id)->update([
                    'status_pay' => 'PENDING',
                    'transaction_status' => 'PENDING'
                ]);
            
        }else if($transaction == 'expire') {
            
            Transaction::where('code',$request->order_id)->update([
                'status_pay' => 'EXPIRED',
                'transaction_status' => 'PENDING'
            ]);
            
        }else if($transaction == 'accept') {
            
            Transaction::where('code',$request->order_id)->update([
                'status_pay' => 'SUCCESS',
                'transaction_status' => 'PROCESS'
            ]);
            
        }else if($transaction == 'settlement') {
            Transaction::where('code',$request->order_id)->update([
                'status_pay' => 'SUCCESS',
                'transaction_status' => 'PROCESS'
            ]);
            
        }
    }
}    