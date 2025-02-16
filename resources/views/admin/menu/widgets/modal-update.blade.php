<div class="modal fade" id="modal-update" tabindex="-1" aria-labelledby="updateMenu" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateMenu">Edit Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="form-update" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label class="mb-2">Foto<span class="text-danger">*</span></label>
                                <img id="img-show" src="#" alt="Preview Gambar"
                                    style="display:none; margin-top:10px; max-width:30%;" class="mb-3">
                                <input type="file" class="form-control mb-3" name="image" id="image-edit"
                                    accept="image/png, image/jpeg, image/jpg" onchange="previewImageEdit(event)">
                                @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label>Nama Produk <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name-edit" class="form-control"
                                    placeholder="Masukkan nama barang">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Input Kategori -->
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="category_id">Kategori<span class="text-danger">*</span></label>
                                <select name="category_id" id="category-edit" class="form-control" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label>Harga <span class="text-danger">*</span></label>
                                <input type="number" name="price" id="price-edit" class="form-control"
                                    placeholder="Masukkan harga barang">
                                @error('price')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Ganti Status dengan Stok -->
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label>Stok Produk <span class="text-danger">*</span></label>
                                <input type="number" name="stock" id="stock-edit" class="form-control"
                                    placeholder="Masukkan jumlah stok barang">
                                @error('stock')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group mb-3" style="position: relative;">
                                <label>Deskripsi <span class="text-danger">*</span></label>
                                <textarea name="description" class="form-control" id="description-edit" rows="3" placeholder="Masukkan deskripsi barang"></textarea>
                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger"
                        data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-rounded btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
