@extends('layouts.admin')

@section('title')
  Penyetelan Toko
@endsection

@section('content')
<!-- Section Content -->
<div
  class="section-content section-dashboard-home"
  data-aos="fade-up"
>
  <div class="container-fluid">
    <div class="dashboard-heading">
        <h2 class="dashboard-title">Produk</h2>
        <p class="dashboard-subtitle">
            Sunting "{{ $item->name }}" Produk
        </p>
    </div>
    <div class="dashboard-content">
      <div class="row">
        <div class="col-12">
          @if ($errors->any())
              <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif
          <form action="{{ route('product.update', $item->id_product) }}" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Nama Produk</label>
                      <input type="text" class="form-control" name="name" value="{{ $item->name }}" required />
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Pemilik Produk</label>
                      <select name="users_id" class="form-control">
                        <option value="{{ $item->users_id }}">{{ $item->user->name }}</option>
                        <option value="" disabled>----------------</option>
                        @foreach ($users as $user)
                          <option value="{{ $user->id_user }}">{{ $user->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Harga</label>
                      <input type="number" class="form-control" name="price" value="{{ $item->price }}" required />
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Stok</label>
                      <input type="number" class="form-control" name="stock" value="{{ $item->stock }}" required />
                    </div>
                  </div>
                </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Deskripsi</label>
                      <textarea name="description" id="editor">{!! $item->description !!}</textarea>
                    </div>
                  </div>
                <div class="row">
                  <div class="col text-right">
                    <button
                      type="submit"
                      class="btn btn-success px-5"
                    >
                      Simpan
                    </button>
                  </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection


@push('addon-script')
  <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
  <script>
    CKEDITOR.replace('editor');
  </script>
@endpush