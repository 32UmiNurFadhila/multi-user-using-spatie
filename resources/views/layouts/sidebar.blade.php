<div>
    <div class="brand-logo d-flex align-items-center justify-content-between">
        <a href="" class="text-nowrap logo-img text-center pb-0 my-n5">
            <img src="{{ asset('assets/images/logos/grostor.png') }}" alt="" width="50%" />
        </a>
        <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-8"></i>
        </div>
    </div>
    <!-- Sidebar navigation-->
    <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
        <ul id="sidebarnav">
            @if (auth()->user()->hasRole('admin'))
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
                    <span class="hide-menu">Admin</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="/admin/dashboard" aria-expanded="false">
                        <span>
                            <iconify-icon icon="solar:home-smile-bold-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">Dasbor</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="/admin/menu" aria-expanded="false">
                        <span>
                            <iconify-icon icon="solar:bookmark-square-minimalistic-bold-duotone"
                                class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">Daftar Produk</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('admin.categories.index') }}" aria-expanded="false">
                        <span>
                            <iconify-icon icon="solar:bookmark-square-minimalistic-bold-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">Kategori</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="/admin/customer" aria-expanded="false">
                        <span>
                            <iconify-icon icon="solar:user-plus-rounded-bold-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">Daftar pelanggan</span>
                    </a>
                </li>
            @else
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
                    <span class="hide-menu">Pelanggan</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="/customer/menu" aria-expanded="false">
                        <span>
                            <iconify-icon icon="solar:bookmark-square-minimalistic-bold-duotone"
                                class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">Daftar menu</span>
                    </a>
                </li>
            @endif

            <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
                <span class="hide-menu">Pesanan</span>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link {{ request()->routeIs('admin.pending') || request()->routeIs('customer.pending') || request()->routeIs('customer.pending.show') ? 'active' : '' }}" href="{{ auth()->user()->hasRole('admin') ? '/admin/pending' : '/customer/pending' }}" aria-expanded="false">
                    <span>
                        <iconify-icon icon="uim:clock" width="24" height="24"></iconify-icon>
                    </span>
                    <span class="hide-menu">Menunggu konfirmasi</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link {{ request()->routeIs('admin.done') || request()->routeIs('customer.done') || request()->routeIs('customer.history.show') ? 'active' : '' }}" href="{{ auth()->user()->hasRole('admin') ? '/admin/history' : '/customer/history' }}" aria-expanded="false">
                    <span>
                        <iconify-icon icon="ix:success" width="24" height="24"></iconify-icon>
                    </span>
                    <span class="hide-menu">Selesai</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" aria-expanded="false" href="{{ route('admin.laporan.show')}}">
                    <span>
                        <iconify-icon icon="ix:success" width="24" height="24"></iconify-icon>
                    </span>
                    <span class="hide-menu">Laporan</span>
                </a>
            </li>
        </ul>
    </nav>
    <!-- End Sidebar navigation -->
</div>
