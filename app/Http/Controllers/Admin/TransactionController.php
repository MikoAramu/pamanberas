<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Transaction::with(['user']);

            return Datatables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                        <div class="btn-group">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle mr-1 mb-1" 
                                    type="button" id="action' .  $item->id_transaction . '"
                                        data-toggle="dropdown" 
                                        aria-haspopup="true"
                                        aria-expanded="false">
                                        Aksi
                                </button>
                                <div class="dropdown-menu" aria-labelledby="action' .  $item->id_transaction . '">
                                    <a class="dropdown-item" href="' . route('transaction.edit', $item->id_transaction) . '">
                                        Sunting
                                    </a>
                                    <form action="' . route('transaction.destroy', $item->id_transaction) . '" method="POST">
                                        ' . method_field('delete') . csrf_field() . '
                                        <button type="submit" class="dropdown-item text-danger">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                    </div>';
                })
                ->rawColumns(['action'])
                ->make();
        }

        return view('pages.admin.transaction.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Transaction::with(['user'])->findOrFail($id);
        $transactionDetail = TransactionDetail::with(['product'])->where(['transactions_id' => $id])->get();

        return view('pages.admin.transaction-detail.admin-transaction-details',[
            'transactions'=> $item,
            'transactionDetail' => $transactionDetail
        ]);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        $item = Transaction::findOrFail($id);

        $item->update($data);

        if ($data['transaction_status'] == "DELIVERING"){
            $TransactonDetails = TransactionDetail::where(['transactions_id' => $id])->get();
            foreach($TransactonDetails as $TD){
                // Update stock
                $item = Product::findOrFail($TD->products_id);
                $item->update([
                    'stock' => $item->stock - $TD->quantity
                ]);
            }
        } else if ($data['transaction_status'] == "PENDING") {
            $TransactionDetails = TransactionDetail::where(['transactions_id' => $id])->get();

            foreach ($TransactionDetails as $TD) {
                $item = Product::findOrFail($TD->products_id);
                $item->update([
                'stock' => $item->stock + $TD->quantity
                ]);
            }
        }

        return redirect()->route('transaction.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Transaction::findorFail($id);
        $item->delete();

        return redirect()->route('transaction.index');
    }
}
