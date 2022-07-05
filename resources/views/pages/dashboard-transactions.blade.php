@extends('layouts.dashboard')

@section('title')
    Riwayat Transaksi Pembelian
@endsection

@section('content')
<div class="section-content section-dashboard-home" data-aos="fade-up">
    <div class="container-fluid">
        <div class="dashboard-heading">
            <h2 class="dashboard-title">Riwayat Transaksi</h2>
            <p class="dashboard-subtitle">
                Riwayat Pembelian dan Pembayaran Anda
            </p>
        </div>
        <div class="dashboard-content">
            <div class="row">
                <div class="col-12 mt-2">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Pembelian Produk</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            @foreach ($buyTransactions as $transaction)
                            <a href="{{ route('dashboard-transaction-details', $transaction->id_transaction_detail) }}" class="card card-list d-block">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <img src="{{ Storage::url($transaction->product->galleries->first()->photos ?? '') }}" class="w-75">
                                        </div>
                                        <div class="col-md-4">
                                            {{ $transaction->product->name ?? '' }}
                                        </div>
                                        <div class="col-md-2">
                                            {{ $transaction->transaction->user->name }}
                                        </div>
                                        <div class="col-md-2">
                                            {{ $transaction->created_at }}
                                        </div>
                                        <div class="col-md-2 {{ $transaction->transaction->transaction_status == 'SUCCESS' ? 'text-success' : ($transaction->transaction->transaction_status == 'SHIPPING' ? 'text-warning': ($transaction->transaction->transaction_status == 'PROCESS' ? 'text-warning' : 'text-danger'))  }}">
                                            {{ $transaction->transaction->transaction_status ?? '' }}
                                        </div>
                                        <div class="col-md-1 d-none d-md-block">
                                            <img src="/images/dashboard-arrow.svg" alt="" />
                                        </div>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection