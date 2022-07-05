@extends('layouts.app')

@section('title')
    Halaman Keranjang Toko
@endsection

@section('content')
    <!-- Page Content -->
    <div class="page-content page-cart">
      <section
        class="store-breadcrumbs"
        data-aos="fade-down"
        data-aos-delay="100"
      >
        <div class="container">
          <div class="row">
            <div class="col-12">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                  <li class="breadcrumb-item active" aria-current="page">
                    Keranjang
                  </li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
      </section>
      <section class="store-cart">
        <div class="container">
          <div class="row" data-aos="fade-up" data-aos-delay="100">
            <div class="col-12 table-responsive">
              <table
                class="table table-borderless table-cart"
                aria-describedby="Cart"
              >
                <thead>
                  <tr>
                    <th scope="col">Gambar</th>
                    <th scope="col">Nama Produk</th>
                    <th scope="col">Jumlah Barang</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Menu</th>
                  </tr>
                </thead>
                <tbody>
                  @php $totalPrice = 0 @endphp
                  @foreach ($carts as $index => $cart)
                  <tr>
                      <td style="width: 25%;">
                          @if ($cart->product->galleries)
                              <img src="{{ Storage::url($cart->product->galleries->first()->photos) }}" alt="" class="cart-image">
                          @endif
                      </td>
                      <td style="width: 25%;">
                          <div class="product-title items">{{ $cart->product->name }}</div>
                      </td>
                      <td style="width: 25%;">
                        <form action="#">
                            <div class="quantity">
                                <button type="button" data-quantity="minus" data-field="quantity{{  $index }}" data-stock="{{ $cart->product->stock }}" data-productId="{{ $cart->id_cart }}" data-productPrice="{{ $cart->product->price }}">-</i></button>
                                <input type="number" data-formQuantity="quantity" name="quantity{{  $index }}" id="quantity{{  $index }}" value="{{  $cart->quantity }}"  data-stock="{{ $cart->product->stock }}" data-productId="{{ $cart->id_cart }}" data-productPrice="{{ $cart->product->price }}"/>
                                <button type="button" data-quantity="plus" data-field="quantity{{  $index }}" data-stock="{{ $cart->product->stock }}" data-productId="{{ $cart->id_cart }}" data-productPrice="{{ $cart->product->price }}">+</i></button>
                            </div>
                        </form>
                    </td>
                      <td style="width: 25%;">
                          {{-- <div class="product-title">Rp {{ number_format($cart->product->price ) }}</div> --}}
                          <div class="product-title" id="productPrice{{ $index }}" >{{ $cart->product->price }}</div>
                      </td>
                      <td style="width: 25%;">
                          <form action="{{ route('cart-delete', $cart->id_cart) }}" method="POST">
                              @method('DELETE')
                              @csrf
                              <button class="btn btn-remove-cart" type="submit">
                                Hapus
                              </button>
                          </form>
                      </td>
                  </tr> 
                  @php $totalPrice += $cart->product->price @endphp                                          
                 @endforeach
              </tbody>
              </table>
            </div>
          </div>
          <div class="row" data-aos="fade-up" data-aos-delay="150">
            <div class="col-12">
              <hr />
            </div>
            <div class="row" data-aos="fade-up" data-aos-delay="150">
              <form action="{{ route('checkout') }}" enctype="multipart/form-data" method="POST">
                @csrf
              <div class="card-body">
                <div class="card shadow mb-4">
                  <div class="col-12">
                    <h2 class="mb-4">Detail Pengantaran</h2>
                        <input type="hidden" name="total_price" value="{{ $totalPrice }}">
                          <div class="row mb-2" data-aos="fade-up" data-aos-delay="200">
                          <div class="col-md-6">
                              <div class="form-group">
                                <label for="address_one">Alamat</label>
                                <input 
                                type="text" 
                                class="form-control" 
                                id="address_one" 
                                name="address_one"
                                readonly="" 
                                value="{{ $user->address_one }}">
                              </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="address_two">Kota/Kabupaten</label>
                              <input 
                              type="text" 
                              class="form-control" 
                              id="address_two" 
                              name="address_two"
                              readonly="" 
                              value="{{ $user->address_two }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="zip_code">Kode Pos</label>
                            <input 
                            type="text" 
                            class="form-control" 
                            id="zip_code" 
                            name="zip_code"
                            readonly=""  
                            value="{{ $user->zip_code }}">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="phone_number">Nomor Telepon</label>
                            <input 
                            type="number" 
                            class="form-control" 
                            id="phone_number" 
                            name="phone_number"
                            readonly="" 
                            value="{{ $user->phone_number }}">
                          </div>
                        </div>
                    </div>
                    </div>
                    </div>
                    <div class="row" data-aos="fade-up" data-aos-delay="150">
                      <div class="col-12">
                      <hr />
                      </div>
                            <div class="col-12">
                              <h2 class="mb-1">Informasi Pembayaran</h2>
                            </div>
                          </div>
                        <div class="row" data-aos="fade-up" data-aos-delay="200">
                          <div class="col-4 col-md-2">
                            <div class="product-title text-success" id="totalBiaya">Rp.{{ number_format($totalPrice)  }}</div>
                            <div class="product-subtitle">Total</div>
                          </div>
                          <div class="col-8 col-md-3">
                            <button 
                            type="submit"  
                            class="btn btn-success mt-4 px-4 btn-block"style="border-radius:20px">
                              Bayar Sekarang
                            </button>
                          </div>
                        </div>
                      </form>
                    </div>
                </section>
             </div>
@endsection

@push('addon-script')
    <script src="/vendor/vue/vue.js"></script>
    <script src="https://unpkg.com/vue-toasted"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
      jQuery(document).ready(function() {
        let totalBiayaValue = 0;
        const jumlahItems = document.querySelectorAll(".items");
        const totalBiaya = document.getElementById('totalBiaya')
        let productPriceShow;
        let totalHarga = 0;
    
        for(i = 0; i < jumlahItems.length; i++){
                        const firstQuantity = document.getElementById('quantity' + i).value
                        let hargaProduk = document.getElementById('productPrice' + i).innerHTML
                        productPriceShow = document.getElementById('productPrice' + i)
                        const firstHargaProduk = hargaProduk * firstQuantity
                        totalHarga += firstHargaProduk;
                        
                        productPriceShow.innerText = 'Rp. ' + parseFloat(hargaProduk, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString()
                        totalBiaya.innerText = 'Rp. ' + parseFloat(totalHarga, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString()
                        totalBiayaValue = totalHarga
                    }
    
        let currenValueInput = 0;
        $("[data-formQuantity='quantity' ] ").on('focusin', function(e) {
            currenValueInput = parseInt($(this).val());
        });
        
        $("[data-formQuantity='quantity' ] ").change(function(e) {
          // ini bisa dipanggil
            let quantity = 0
            let stockBerubah = 0
            const angka = parseInt($(this).val())
            const stock = $(this).attr('data-stock');
            const hargaProduk = $(this).attr('data-productPrice');
            
            if (angka > stock){
                quantity = stock
                $(this).val(stock)
                $('input[name=quantity]').val(quantity);
            } else {
                quantity = angka
                $('input[name=quantity]').val(quantity);
            }
            // Update Produk Price
            if (currenValueInput < quantity) {
                updateHarga = hargaProduk * (quantity - currenValueInput)
                totalHarga += updateHarga;
            } else {
                updateHarga = hargaProduk * (currenValueInput - quantity)
                totalHarga -= updateHarga;
            }
            subTotal.innerText = 'Rp. ' + parseFloat(totalHarga, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString()
            totalBiaya.innerText = 'Rp. ' + parseFloat(totalHarga, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString()
            totalBiayaValue = totalHarga
    
            // Update quantity 
            let productId = $(this).attr('data-productId');
            let CSRFToken = '{{ csrf_token() }}'
            $.ajax({
                url: `cart/${productId}`,
                type: 'post',
                data: {
                    _token: CSRFToken,
                    quantity: quantity
                },
            });
        });
    
        // This button will increment the value
        $("[data-quantity='plus' ] ").click(function(e) {
            const hargaProduk = $(this).attr('data-productPrice');
            let quantity;
            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            fieldName = $(this).attr('data-field');
            // Get stock
            stock = $(this).attr('data-stock');
            // Get its current value
            var currentVal = parseInt($('input[name=' + fieldName + ']').val());
            // If is not undefined
            if (!isNaN(currentVal)) {
                // Increment
                quantity = currentVal + 1;
                if (quantity > stock) {
                    quantity = stock
                }
                $('input[name=' + fieldName + ']').val(quantity);
            } else {
                // Otherwise put a 0 there
                quantity = 0;
                $('input[name=' + fieldName + ']').val(quantity);
            }
            // Update Produk Price
            updateHarga = hargaProduk * (quantity - currentVal )
            totalHarga += updateHarga;
            totalBiaya.innerText = 'Rp. ' + parseFloat(totalHarga, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString()
            totalBiayaValue = totalHarga
    
            // Update quantity 
            let productId = $(this).attr('data-productId');
            let CSRFToken = '{{ csrf_token() }}'
            $.ajax({
                url: `cart/${productId}`,
                type: 'post',
                data: {
                    _token: CSRFToken,
                    quantity: quantity
                },
            });
        });
        // This button will decrement the value till 0
        $("[data-quantity='minus' ] ").click(function(e) {
            const hargaProduk = $(this).attr('data-productPrice');
            let quantity;
            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            fieldName = $(this).attr('data-field');
            // Get its current value
            var currentVal = parseInt($('input[name=' + fieldName + ']').val());
            // If it isn't undefined or its greater than 0
            if (!isNaN(currentVal) && currentVal > 0) {
                // Decrement one
                quantity = currentVal - 1;
                $('input[name=' + fieldName + ']').val(quantity);
            } else {
                // Otherwise put a 0 there
                quantity = 0;
                $('input[name=' + fieldName + ']').val(quantity);
            }
            updateHarga = hargaProduk * (currentVal - quantity)
            totalHarga -= updateHarga;
            totalBiaya.innerText = 'Rp. ' + parseFloat(totalHarga, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString()
            totalBiayaValue = totalHarga
    
            // Update quantity 
            let productId = $(this).attr('data-productId');
            let CSRFToken = '{{ csrf_token() }}'
            $.ajax({
                url: `cart/${productId}`,
                type: 'post',
                data: {
                    _token: CSRFToken,
                    quantity: quantity
                },
            });
        });
      });
    </script>
@endpush