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
                            Tambah Produk
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                @forelse ($menus as $menu)
                    <div class="col-md-3 col-sm-6 mb-3 gap-5">
                        <div class="card">
                            <img src="{{ asset('storage/' . $menu->image) }}" class="card-img-top" style="height: 150px; object-fit: cover;" alt="...">
                            <div class="card-body p-3">
                                <h5 class="card-title">{{ $menu->name }}</h5>
                                <h6 class="text-muted">Kategori: {{ $menu->category->name ?? 'Tidak Ada Kategori' }}</h6>
                                <h6 class="text-muted">Harga: Rp. {{ number_format($menu->price, 0, ',', '.') }}</h6>
                                <h6 class="text-muted">Stok: {{ $menu->stock }}</h6>
                                <p class="card-text">{{ Str::limit($menu->description, 50) }}</p>
                                <div class="d-flex align-items-center gap-2 mt-4">
                                    <button type="button" class="btn btn-sm btn-warning text-white rounded-3 btn-edit"
                                        style="background-color: #ffc107" data-id="{{ $menu->id }}"
                                        data-name="{{ $menu->name }}" data-price="{{ $menu->price }}"
                                        data-status="{{ $menu->status }}"
                                        data-image="{{ asset('storage/' . $menu->image) }}"
                                        data-description="{{ $menu->description }}">
                                        <span>
                                            <iconify-icon icon="tabler:edit" width="24" height="24"
                                                class="m-0 pd-0"></iconify-icon>
                                        </span>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger btn-delete rounded-3" data-id="{{ $menu->id }}">
                                        <iconify-icon icon="ic:round-delete" width="24" height="24"></iconify-icon>
                                    </button>
                                    @if ($menu->status == 'tersedia')
                                        <button type="button" class="p-2 btn btn-success rounded-3 px-3 btn-available" data-id="{{ $menu->id }}">
                                            Tersedia
                                        </button>
                                    @else
                                        <button type="button" class="p-2 btn btn-danger rounded-3 px-3 btn-unavailable" data-id="{{ $menu->id }}">
                                            Kosong
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                <div class="d-flex flex-column justify-content-center align-items-center">
                    <img src="{{ asset('assets/images/empty.png') }}" alt=""
                        width="200px">
                    <p class="fs-5 text-dark text-center mt-2">
                        Tidak ada data
                    </p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <x-paginate-component :paginator="$menus" />

    @include('admin.menu.widgets.modal-create')
    @include('admin.menu.widgets.modal-update')
    @include('admin.menu.widgets.modal-available')
    @include('admin.menu.widgets.modal-unavailable')
    <x-delete-modal-component />
@endsection
@section('script')
    <script>
        function previewImage(event) {
            var input = event.target;
            var reader = new FileReader();

            reader.onload = function() {
                var imgElement = document.getElementById('image-preview');
                imgElement.src = reader.result;
                imgElement.style.display = 'block';
            }

            reader.readAsDataURL(input.files[0]);
        }

        function previewImageEdit(event) {
            var reader = new FileReader();
            var fileInput = event.target;

            reader.onload = function() {
                $('#img-show').attr('src', reader.result).css('display', 'block');
            };

            var fileName = fileInput.files[0] ? fileInput.files[0].name : "Tidak ada file yang dipilih";
            $('#image-edit').attr('title', fileName);

            if (fileInput.files[0]) {
                reader.readAsDataURL(fileInput.files[0]);
            }
        }
    </script>
    <script>
        $('.btn-edit').click(function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var description = $(this).data('description');
            var image = $(this).data('image');
            var price = $(this).data('price');
            var status = $(this).data('status');

            $('#name-edit').val(name);
            $('#description-edit').val(description);
            $('#price-edit').val(price);
            $('#status-edit').val(status).trigger('change');
            $('#form-update').attr('action', `{{ route('admin.menu.update', '') }}/${id}`);

            // Menampilkan gambar dari database
            if (image) {
                $('#img-show').attr('src', image).css('display', 'block');
            } else {
                $('#img-show').hide();
                $('#image-edit').attr('title', 'Tidak ada file yang dipilih');
            }

            $('#modal-update').modal('show');
        });

        $('.btn-delete').on('click', function() {
            var id = $(this).data('id');
            $('#form-delete').attr('action', `{{ route('admin.menu.destroy', '') }}/${id}`);
            $('#modal-delete').modal('show');
        });

        $('.btn-unavailable').on('click', function() {
            var id = $(this).data('id');
            $('#form-available').attr('action', `{{ route('admin.menu.available', '') }}/${id}`);
            $('#modal-available').modal('show');
        });

        $('.btn-available').on('click', function() {
            var id = $(this).data('id');
            $('#form-unavailable').attr('action', `{{ route('admin.menu.unavailable', '') }}/${id}`);
            $('#modal-unavailable').modal('show');
        });
    </script>
@endsection
