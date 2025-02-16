<div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="createMenu" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createMenu">Tambah Pesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('customer.order.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="order-repeater mb-3">
                        <div data-repeater-list="repeater-group" id="repeater-list">
                            <!-- Repeater Item Template (Item pertama tanpa tombol hapus) -->
                            <div data-repeater-item class="row mb-3 align-items-end repeater-item" id="item-0">
                                <div class="col-md-8">
                                    <label for="menu" class="mb-2">Menu</label>
                                    <select class="form-control" name="repeater-group[0][menu_id]">
                                        <option value="">Pilih Menu</option>
                                        @foreach ($menus as $menu)
                                            <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('repeater-group.*.menu_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="quantity" class="mb-2">Jumlah</label>
                                    <input type="number" name="repeater-group[0][quantity]" class="form-control" min="1" value="1"/>
                                    @error('repeater-group.*.quantity')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-1">
                                    <!-- Tombol hapus hanya akan ada pada item setelah pertama -->
                                    <button type="button" class="btn btn-sm btn-danger remove-item d-none rounded-3 p-2">
                                        <i class="ti ti-circle-x fs-5"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="add-item" class="btn btn-info waves-effect waves-light">
                            <div class="d-flex align-items-center">
                                Tambah menu lain
                                <i class="ti ti-circle-plus ms-1 fs-5"></i>
                            </div>
                        </button>

                        <div class="col-md-12 mt-3">
                            <div class="form-group mb-3" style="position: relative;">
                                <label>Catatan <span class="text-muted">(opsional)</span></label>
                                <textarea name="note" class="form-control" rows="3" placeholder="Masukkan catatan pesanan">{{ old('note') }}</textarea>
                                @error('note')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-rounded btn-primary">Buat pesanan</button>
                </div>
            </form>
        </div>
    </div>
</div>
