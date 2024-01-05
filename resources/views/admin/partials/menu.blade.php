<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
<ul class="sidebar-nav" id="sidebar-nav">
    <li class="nav-item">
    <a class="nav-link collapsed" href="{{ route('akun-dashboard') }}">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
    </a>
    </li>
    <li class="nav-item">
    <a class="nav-link collapsed" href="{{ route('pengguna-aset') }}">
        <i class="bi bi-person-lines-fill"></i>
        <span>Pengguna Barang</span>
    </a>
    </li>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-receipt"></i><span>Peminjaman</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <li>
                <a href="{{ route('pinjam-ruangan') }}">
                    <i class="bi bi-circle"></i><span>Ruangan</span>
                </a>
            </li>
            <li>
                <a href="{{ route('pinjam-aset') }}">
                    <i class="bi bi-circle"></i><span>Barang</span>
                </a>
            </li>
        </ul>
    </li><!-- End Icons Nav -->

    <li class="nav-item">
    <a class="nav-link collapsed" href="{{ route('perawatan') }}">
        <i class="bi bi-card-checklist"></i>
        <span>Perawatan</span>
    </a>
    </li>


    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('pengajuan-laporan') }}">
            <i class="bi bi-journal"></i>
            <span>Laporan</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#icons-nav2" data-bs-toggle="collapse" href="#">
            <i class="bi bi-journal-check"></i><span>Validasi Pengelola</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="icons-nav2" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <li>
                <a href="{{ route('laporan') }}">
                    <i class="bi bi-circle"></i><span>Laporan Kerusakan Barang</span>
                </a>
            </li>
            <li>
                <a href="{{ route('pinjam-ruangan-validasi') }}">
                    <i class="bi bi-circle"></i><span>Peminjaman Ruangan</span>
                </a>
            </li>
            <li>
                <a href="{{ route('pinjam-aset-validasi') }}">
                    <i class="bi bi-circle"></i><span>Peminjaman Barang</span>
                </a>
            </li>
        </ul>
    </li><!-- End Icons Nav -->    
    
    <li class="nav-heading">Referensi</li>
    <li class="nav-item">
    <a class="nav-link collapsed" href="{{ route('gedung') }}">
        <i class="bi bi-bank"></i>
        <span>Gedung</span>
    </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('jenis-aset') }}">
            <i class="bi bi-archive"></i>
            <span>Jenis Barang</span>
        </a>
        </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('data-aset') }}">
            <i class="bi bi-box2"></i>
            <span>Data Barang</span>
        </a>
    </li>

    <li class="nav-item">
    <a class="nav-link collapsed" href="{{ route('ruangan') }}">
        <i class="bi bi-building"></i>
        <span>Ruangan</span>
    </a>
    </li>

    <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-people"></i><span>Akun</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
        <a href="{{ route('grup') }}">
            <i class="bi bi-circle"></i><span>Grup</span>
        </a>
        </li>
        <li>
        <a href="{{ route('pengguna') }}">
            <i class="bi bi-circle"></i><span>Pengguna</span>
        </a>
        </li>
    </ul>
    </li><!-- End Icons Nav -->

    <li class="nav-heading">Pages</li>

    <li class="nav-item">
    <a class="nav-link collapsed" href="{{ route('profil') }}">
        <i class="bi bi-person"></i>
        <span>Profile</span>
    </a>
    </li><!-- End Profile Page Nav -->

    <li class="nav-item">
    <a class="nav-link collapsed" href="pages-faq.html">
        <i class="bi bi-question-circle"></i>
        <span>F.A.Q</span>
    </a>
    </li>
</ul>

</aside><!-- End Sidebar-->