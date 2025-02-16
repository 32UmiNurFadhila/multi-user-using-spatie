@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-bold mb-4">Daftar Produk</h5>
            <div class="row mb-4">
                <div class="col-md-4 col-xl-3">
                    <form class="position-relative d-flex align-items-center gap-2">
                        <input type="text" class="form-control product-search" name="search"
                            value="{{ old('search', request('search')) }}" id="input-search" placeholder="Cari...">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </form>
                </div>

                <div class="col-md-8 col-xl-9 text-end d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
                    <div class="action-btn show-btn">
                        <a href="javascript:void(0)" id="btn-add-contact" class="btn btn-primary d-flex align-items-center"
                            data-bs-toggle="modal" data-bs-target="#modal-create">
                            Buat Pesanan
                        </a>
                    </div>
                </div>
            </div>
            @session('error')
                <p>{{ session('error') }}</p>
            @endsession
            <div class="row">
                @forelse ($allMenus as $menu)
                    <div class="col-md-3 col-sm-6 mb-3 gap-5">
                        <div class="card">
                            <span
                                class="badge bg-{{ $menu->status == 'tersedia' ? 'success' : 'danger' }} position-absolute top-0 end-0 mt-2 me-2">{{ ucfirst($menu->status) }}</span>
                            <img src="{{ asset('storage/' . $menu->image) }}" class="card-img-top"
                                style="height: 150px; object-fit: cover;" alt="{{ $menu->name }}">
                            <div class="card-body p-3">
                                <h5 class="card-title">{{ $menu->name }}</h5>
                                <p class="card-text">
                                    <strong>Kategori:</strong> {{ $menu->category->name }} <br>
                                    <strong>Harga:</strong> Rp. {{ number_format($menu->price, 0, ',', '.') }} <br>
                                    <strong>Stok:</strong> {{ $menu->stock }} pcs <br>
                                    <strong>Deskripsi:</strong> {{ $menu->description }}
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <img src="{{ asset('assets/images/empty.png') }}" alt="" width="200px">
                        <p class="fs-5 text-dark text-center mt-2">
                            Tidak ada data
                        </p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    @include('customer.menu.widgets.modal-create')
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const addButton = document.getElementById('add-item');
    const repeaterList = document.getElementById('repeater-list');
    const itemTemplate = repeaterList.querySelector('.repeater-item');
    let itemCount = 1; 

    addButton.addEventListener('click', function() {
        const newItem = itemTemplate.cloneNode(true);
        newItem.classList.remove('d-none'); 

        newItem.querySelector('select[name="repeater-group[0][menu_id]"]').setAttribute('name', `repeater-group[${itemCount}][menu_id]`);
        newItem.querySelector('input[name="repeater-group[0][quantity]"]').setAttribute('name', `repeater-group[${itemCount}][quantity]`);

        if (itemCount > 0) {
            const removeButton = newItem.querySelector('.remove-item');
            removeButton.classList.remove('d-none');
        }

        repeaterList.appendChild(newItem);
        itemCount++; 
    });

    repeaterList.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-item')) {
            e.target.closest('.repeater-item').remove();
            itemCount--;  
        }
    });
});
</script>
@endsection
