@extends('layouts.dashboard')

@section('title')
    Detail Transaksi Dasbor Toko
@endsection

@section('content')
<div class="section-content section-dashboard-home" data-aos="fade-up">
    <div class="container-fluid">
        <div class="dashboard-heading">
            <h2 class="dashboard-title">#{{ $transactions->code }}</h2>
                <p class="dashboard-subtitle">
                Transaksi / Detail
                </p>
                </div>
                <div class="dashboard-content" id="transactionDetails">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-list mt-3">
                                <div class="card-body p-md-5">
                                    <div class="col-12 col-md-12">
                                        <div class="row">
                                <!-- Image Mobile Version -->
                                <div class="col-12 d-lg-none mb-3 mt-3">
                                    <img src="{{ asset('images/drawable-mdpi/product-details-dashboard.png') }}" alt="">
                                </div>
                                <!-- End -->
                                <div class="col-12 col-md-3">
                                    <div class="product-title">ID Transaksi</div>
                                    <div class="product-subtitle">#{{ $transactions->transaction->code }}</div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="product-title">Nama Produk</div>
                                    <div class="product-subtitle">{{ $transactions->product->name }}</div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="product-title">Total Pembayaran</div>
                                    <div class="product-subtitle">Rp {{ number_format($transactions->transaction->total_price) }}</div>
                                </div>
                                <div class="col-12 col-md-3">
                                    <div class="product-title">Nama Pelanggan</div>
                                    <div class="product-subtitle">{{ $transactions->transaction->user->name }}</div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="product-title">Tanggal Transaksi</div>
                                    <div class="product-subtitle">{{ $transactions->created_at }}</div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="product-title">Jumlah Barang</div>
                                    <div class="product-subtitle">{{ $transactions->quantity }} pcs</div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="product-title">Status Pembayaran</div>
                                    <div class="product-subtitle {{ $transactions->transaction->status_pay == 'SUCCESS' ? 'text-success' : 'text-danger' }}">{{ $transactions->transaction->status_pay }}</div>
                                </div>
                            </div>
                                </div>
                                <form action="{{ route('dashboard-transaction-update', $transactions->id_transaction_detail) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                    <div class="col-12 mt-4 mb-3">
                                        <h5>Informasi Pengantaran</h5>
                                    </div>
                                    <div class="col-7">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">Alamat</div>
                                                <div class="product-subtitle">{{ $transactions->transaction->user->address_one }}</div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">Kota/Kabupaten</div>
                                                <div class="product-subtitle">{{ $transactions->transaction->user->address_two }}</div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">Kode Pos</div>
                                                <div class="product-subtitle">{{ $transactions->transaction->user->zip_code }}</div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">Nomor Telepon</div>
                                                <div class="product-subtitle">{{ $transactions->transaction->user->phone_number }}</div>
                                            </div>
                                            <div class="col-12 col-md-3">
                                                <div class="product-title">Status Pengantaran</div>
                                                <div class="product-subtitle {{ $transactions->transaction->transaction_status == 'SUCCESS' ? 'text-success' : ($transactions->transaction->transaction_status == 'DELIVERING' ? 'text-warning': ($transactions->transaction->transaction_status == 'PROCESS' ? 'text-warning' : 'text-danger'))  }}">{{ $transactions->transaction->transaction_status }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Image Desktop Version -->
                                    <div class="col-12 col-md-5 d-none d-lg-flex">
                                        <img src="{{ Storage::url($transactions->product->galleries->first()->photos ?? '') }}" class="w-100 ">
                                    </div>
                                    <!-- End -->
                                </div>
                                <div class="row">
                                    <div class="col-12 mt-3 ">
                                        <a href="{{ route('dashboard-transactions') }}" class="btn btn-success px-5">Back</a>
                                    </div>
                                </div>
                                </form>
                                    </div>
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
@push('addon-script')
  <script src="/vendor/vue/vue.js"></script>
    <script>
      var transactionDetails = new Vue ({
        el: '#transactionDetails',
          data: {
            delivering_status: '{{ $transactions->transaction_status }}',
          },
      });sai
    </script> 
@endpush 