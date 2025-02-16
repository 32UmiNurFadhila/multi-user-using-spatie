@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title fw-bold mb-4">Edit Profile</h5>
        
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="name">Nama <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" id="name"
                        placeholder="Masukkan nominal pembayaran" value="{{ old('name', auth()->user()->name) }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="email">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" name="email" id="email"
                        placeholder="Masukkan nominal pembayaran" value="{{ old('email', auth()->user()->email) }}">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-rounded btn-primary">Ubah</button>
            </div>
        </form>
    </div>
</div>
@endsection