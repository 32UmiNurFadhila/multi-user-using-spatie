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
                            <!-- Repeater Item Template -->
                            <div data-repeater-item class="row mb-3 align-items-end repeater-item" id="item-0">
                                <div class="col-md-8">
                                    <label for="menu" class="mb-2">Produk</label>
                                    <select class="form-control" name="repeater-group[0][menu_id]" onchange="checkStock(0)">
                                        <option value="">Pilih Produk</option>
                                        @foreach ($menus as $menu)
                                            <option value="{{ $menu->id }}" data-stock="{{ $menu->stock }}">{{ $menu->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('repeater-group.*.menu_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="quantity" class="mb-2">Jumlah</label>
                                    <input type="number" name="repeater-group[0][quantity]" class="form-control" min="1" value="1" id="quantity-0" oninput="checkStock(0)"/>
                                    @error('repeater-group.*.quantity')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <div id="stock-warning-0" class="text-danger d-none">Jumlah melebihi stok yang tersedia!</div>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-sm btn-danger remove-item d-none rounded-3 p-2">
                                        <i class="ti ti-circle-x fs-5"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="add-item" class="btn btn-info waves-effect waves-light">
                            <div class="d-flex align-items-center">
                            tambah produk lain
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
                    <button type="submit" class="btn btn-rounded btn-primary" id="submit-order">Buat pesanan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Fungsi untuk mengecek apakah jumlah yang dimasukkan melebihi stok
    function checkStock(index) {
        let quantityInput = document.querySelector(`input[name="repeater-group[${index}][quantity]"]`);
        let productSelect = document.querySelector(`select[name="repeater-group[${index}][menu_id]"]`);
        let stockWarning = document.getElementById(`stock-warning-${index}`);
        let stock = productSelect.options[productSelect.selectedIndex].getAttribute('data-stock');
        
        // Jika jumlah lebih besar dari stok, tampilkan peringatan
        if (quantityInput.value > stock) {
            stockWarning.classList.remove('d-none');
            document.getElementById('submit-order').disabled = true; // Disable submit button
        } else {
            stockWarning.classList.add('d-none');
            document.getElementById('submit-order').disabled = false; // Enable submit button
        }
    }
</script>
