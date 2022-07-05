<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardTransactionController extends Controller
{
    public function index()
    {
        $buyTransactions = TransactionDetail::with(['transaction.user','product.galleries'])
                                ->whereHas('transaction', function($transaction){
                                    $transaction->where('users_id', Auth::user()->id_user);
                                })->orderBy('id_transaction_detail','desc')->get();
        
        return view('pages.dashboard-transactions',[
            'buyTransactions' => $buyTransactions
        ]);
    }
    
    public function details(Request $request, $id)
    {
        $transactions = TransactionDetail::with(['transaction.user','product.galleries'])
                            ->where('id_transaction_detail', $id)->firstOrFail(); // dsini ya
        // dd($transactions);
        return view('pages.dashboard-transactions-details',[
            'transactions' => $transactions
        ]);
    }


    public function update(Request $request, $id)
    {
        $data = $request->all();

        $item = TransactionDetail::findOrFail($id);

        $item->update($data);

        return redirect()->route('dashboard-transactions-details', $id);
    }
}
