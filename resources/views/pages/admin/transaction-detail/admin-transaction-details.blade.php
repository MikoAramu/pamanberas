
@extends('layouts.admin')

@section('title')
    Paman Beras  
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
                        <div class="card">
                            <div class="card-body">

                                {{-- Products List --}}
                                <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Foto</th>
                                        <th>Nama Produk</th>
                                        <th>Harga</th>
                                        <th>Jumlah Barang</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transactionDetail as $index => $TD) 
                                    <tr>
                                            <td>{{ ++$index }}</td>
                                            <td>
                                                @if ($TD->product->galleries)
                                                <img src="{{ Storage::url($TD->product->galleries->first()->photos) }}" 
                                                alt=""
                                                height="100"
                                                width="100"
                                                >
                                                @endif
                                            </td>
                                            <td>{{ $TD->product->name }}</td>
                                            <td>@rupiah($TD->product->price)</td>
                                            <td>{{ $TD->quantity }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="row">
                                <div class="col-12 col-md-12">
                                    <div class="row">
                                        <div class="col-12 col-md-4">
                                            <div class="product-title">Nama Pelanggan</div>
                                                <div class="product-subtitle">{{ $transactions->user->name }}</div>
                                            </div>
                                        <div class="col-12 col-md-4">
                                            <div class="product-title">Nomor Telepon</div>
                                                <div class="product-subtitle">{{ $transactions->user->phone_number}}</div>
                                            </div>
                                        <div class="col-12 col-md-4">
                                            <div class="product-title">Tanggal Transaksi</div>
                                                <div class="product-subtitle">{{ $transactions->created_at }}</div>
                                            </div>
                                        <div class="col-12 col-md-4">
                                            <div class="product-title">Status Pembayaran</div>
                                                <div class="product-subtitle text-danger">{{ $transactions->status_pay}}</div>
                                            </div>
                                        <div class="col-12 col-md-4">
                                            <div class="product-title">Total Pembayaran</div>
                                                <div class="product-subtitle">@rupiah($transactions->total_price)</div> 
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <form action="{{ route('transaction.update', $transactions->id_transaction) }}" method="POST">
                            @method('PUT')
                            @csrf
                                <div class="row">
                                    <div class="col-12 mt-4">
                                             
                                    <div class="col-12 mt-4">
                                        <h5>Informasi Pengantaran</h5>
                                    </div>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">Alamat</div>
                                                    <div class="product-subtitle">{{ $transactions->user->address_one }}</div>
                                                </div>
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">Kota/Kabupaten</div>
                                                    <div class="product-subtitle">{{ $transactions->user->address_two }}</div>
                                                </div>
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">Kode Pos</div>
                                                <div class="product-subtitle">{{ $transactions->user->zip_code }}</div>
                                            </div>
                                        </div> 
                                    </div>

                                        <div class="col-12 col-md-3">
                                                <div class="product-title">Status Pengantaran</div>
                                                <select name="transaction_status" class="form-control" v-model="status">
                                                    <option value="PENDING" {{ $transactions->transaction_status == 'PENDING' ? 'selected' : '' }}>PENDING</option>
                                                    <option value="PROCESS" {{ $transactions->transaction_status == 'PROSES' ? 'selected' : '' }}>PROSES</option>
                                                    <option value="DELIVERING" {{ $transactions->transaction_status == 'SEDANG DIANTAR' ? 'selected' : '' }}>SEDANG DIANTAR</option>
                                                    <option value="SUCCESS" {{ $transactions->transaction_status == 'SUKSES' ? 'selected' : '' }}>SUKSES</option>
                                                </select>
                                        </div>
                                        </div>
                                    </div>
                                <div class="row mt-4">
                                    <div class="col-12 text-right">
                                        <button 
                                        type="submit" 
                                        class="btn btn-success btn-lg mt-4"
                                        > 
                                        Simpan
                                        </button>
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
            status: 'DELIVERING'
          },
      });sai
    </script> 
@endpush 