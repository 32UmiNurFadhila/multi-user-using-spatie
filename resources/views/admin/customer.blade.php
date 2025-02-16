@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-body">
      <h5 class="card-title fw-bold mb-4">Daftar Pelanggan</h5>

      <table class="table caption-top">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Nama Pelanggan</th>
            <th scope="col">Email</th>
            <th scope="col">Bergabung pada</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($customers as $customer)
          <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $customer->name }}</td>
            <td>{{ $customer->email }}</td>
            <td>{{ Carbon\Carbon::parse($customer->created_at)->translatedFormat('d F Y') }}</td>
          </tr>
          @empty
              
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection