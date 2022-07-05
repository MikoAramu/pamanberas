@extends('layouts.app')

@section('title')
  Halaman Detail Produk
@endsection

@section('content')
<div class="page-content page-details">
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
                  <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                  <li class="breadcrumb-item active" aria-current="page">
                    Detail Produk
                  </li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
      </section>
      <section class="store-gallery ab-5" id="gallery">
        <div class="container">
          <div class="row">
            <div class="col-lg-8" data-aos="zoom-in">
              <transition name="slide-fade" mode="out-in">
                <img
                  :key="photos[activePhoto].id"
                  :src="photos[activePhoto].url"
                  class="w-100 main-image"
                  alt=""
                />
              </transition>
            </div>
            <div class="col-lg-2">
              <div class="row">
                <div
                  class="col-3 col-lg-12 mt-2 mt-lg-0"
                  v-for="(photo, index) in photos"
                  :key="photo.id"
                  data-aos="zoom-in"
                  data-aos-delay="100"
                >
                  <a href="#" @click="changeActive(index)">
                    <img
                      :src="photo.url"
                      class="w-100 thumbnail-image"
                      :class="{ active: index == activePhoto }"
                      alt=""
                    />
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <div class="store-details-container" data-aos="fade-up">
        <section class="store-heading">
          <div class="container">
            <div class="row">
              <div class="col-lg-8">
                <h1 style="margin-bottom: 15px;">{{ $product->name }}</h1>
                <div class="price">Rp {{ number_format($product->price) }} </div>
                <div class="items-center">
                  <span class="items-center">Stok : {{$product->stock }}</span>
                </div>
                {!! $product->description !!}
                <span class="quantity-title">Quantity: </span>
                <div class="product-quantity d-flex flex-wrap align-items-center">
                    <form action="#">
                        <div class="quantity d-flex mb-3">
                            <button type="button" data-quantity="minus" data-field="quantity">-</button>
                            <input type="number" id="quantity" value="1"/>
                            <button type="button" data-quantity="plus" data-field="quantity">+</button>
                        </div>
                    </form>
                </div>
                @auth
                <form action="{{ route('detail-add', $product->id_product) }}" method="POST" enctype="multipart/form-data">
                  <input type="hidden" name="quantity" value="1" />
                      @csrf
                      <button
                        type="submit"
                        class="btn btn-success px-4 text-white btn-block mb-3"
                      >
                        Tambah Ke Keranjang
                      </button>
                    </form>
                @else
                    <a
                      href="{{ route('login') }}"
                      class="btn btn-success px-4 text-white btn-block mb-3"
                    >
                      Masuk Untuk Tambah Ke Keranjang
                    </a>
                @endauth
              </div>
            </div>
          </div>
        </section>
        <section class="store-description">
          <div class="container">
            <div class="row">
              <div class="col-12 col-lg-8">
                {!! $product->description !!}
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
@endsection

@push('addon-script')
<script src="/vendor/vue/vue.js"></script>
    <script>
      var gallery = new Vue({
        el: "#gallery",
        mounted() {
          AOS.init();
        },
        data: {
          activePhoto: 0,
          photos: [
            @foreach($product->galleries as $gallery)
            {
              id: {{ $gallery->id_gallery }},
              url: "{{ Storage::url($gallery->photos) }}",
            },
            @endforeach
          ],
        },
        methods: {
          changeActive(id) {
            this.activePhoto = id;
          },
        },
      });
    </script>
    <script>
      const stock = '{{ $product->stock }}'
      jQuery(document).ready(function() {
          let quantity = 0;

          // This button will increment the value
          $('[data-quantity="plus"]').click(function(e) {
              // Stop acting like a button
              e.preventDefault();
              // Get the field name
              fieldName = $(this).attr('data-field');
              // Get its current value
              var currentVal = parseInt($('input[id=' + fieldName + ']').val());
              // If is not undefined
              if (!isNaN(currentVal)) {
                  // Increment
                  quantity = currentVal + 1;
                  if (quantity > stock){
                      quantity = stock
                  }
                  $('input[id=' + fieldName + ']').val(quantity);
                  $('input[name=' + fieldName + ']').val(quantity);
              } else {
                  // Otherwise put a 0 there
                  $('input[id=' + fieldName + ']').val(0);
                  $('input[name=' + fieldName + ']').val(0);
              }
          });
          // This button will decrement the value till 0
          $('[data-quantity="minus"]').click(function(e) {
              // Stop acting like a button
              e.preventDefault();
              // Get the field name
              fieldName = $(this).attr('data-field');
              // Get its current value
              var currentVal = parseInt($('input[id=' + fieldName + ']').val());
              // If it isn't undefined or its greater than 0
              if (!isNaN(currentVal) && currentVal > 0) {
                  // Decrement one
                  quantity = currentVal - 1;
                  $('input[id=' + fieldName + ']').val(quantity);
                  $('input[name=' + fieldName + ']').val(quantity);
              } else {
                  // Otherwise put a 0 there
                  $('input[id=' + fieldName + ']').val(0);
                  $('input[name=' + fieldName + ']').val(0);
              }
          });
      });

      $("#quantity").change(function() {
          const angka = parseInt($(this).val())
          
          if (angka > stock){
              $(this).val(stock)
              $('input[name=quantity]').val(stock);
          } else {
              $('input[name=quantity]').val(angka);
          }
      });
  </script>
@endpush