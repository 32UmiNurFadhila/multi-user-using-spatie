@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Pesanan terbaru</h5>
                    <div class="table-responsive">
                        <table class="table text-nowrap align-middle mb-0">
                            <thead>
                                <tr class="border-2 border-bottom border-primary border-0">
                                    <th scope="col" class="ps-0">No</th>
                                    <th scope="col">Nama Pelanggan</th>
                                    <th scope="col">Email Pelanggan</th>
                                    <th scope="col" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                              @forelse ($pendingOrders as $pendingOrder)
                                  <tr>
                                      <th scope="row">{{ $loop->iteration }}</th>
                                      <td>{{ $pendingOrder->user->name }}</td>
                                      <td>{{ $pendingOrder->user->email }}</td>
                                      <td class="text-center">
                                          <a href="{{ route('pending.show', $pendingOrder) }}"
                                              class="btn btn-sm btn-primary">Konfirmasi</a>
                                      </td>
                                  </tr>
                              @empty
                                  <tr>
                                      <td colspan="6">
                                          <div class="d-flex flex-column justify-content-center align-items-center">
                                              <img src="{{ asset('assets/images/empty.png') }}" alt="" width="200px">
                                              <p class="fs-5 text-dark text-center mt-2">
                                                  Tidak ada data
                                              </p>
                                          </div>
                                      </td>
                                  </tr>
                              @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    <img src="../assets/images/backgrounds/product-tip.png" alt="image" class="img-fluid" width="205">
                    <h4 class="mt-7">Siap Melayani!</h4>
                    <p class="card-subtitle mt-2 mb-3">Halo Admin, silahkan kelola menu restoran dan konfirmasi pesanan
                        pelanggan serta rekap pembayaran dengan mudah</p>
                </div>
            </div>
        </div>
    @endsection
