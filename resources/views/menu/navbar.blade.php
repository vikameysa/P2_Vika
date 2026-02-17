<div class="nk-sidebar">
    <div class="nk-nav-scroll">

        <ul class="metismenu" id="menu">

            <li class="nav-label">Dashboard</li>

            <li>
                <a href="{{ route('dashboard') }}">
                    <i class="icon-speedometer menu-icon"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            <li class="nav-label">Apps</li>

            <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="icon-note menu-icon"></i><span class="nav-text">User</span>
                </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('Dokter.dokter') }}" class=" waves-effect">
                            <span>Data Dokter</span>
                            </a>
                        </li>
                        <li><a href="{{ route('Farmasi.farmasi') }}" class=" waves-effect">
                            <span>Data Farmasi</span>
                            </a>
                        </li>
                    </ul>
            </li>

            <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="icon-note menu-icon"></i><span class="nav-text">Pelayanan</span>
                </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('Pasien.pasien') }}" class=" waves-effect">
                                <span>Data Pasien</span>
                            </a>
                        </li>
                        <li><a href="{{ route('Antrian.antrian') }}" class=" waves-effect">
                                <span>Data Antrian</span>
                            </a>
                        </li>
                        <li><a href="{{ route('Klinik.klinik') }}" class=" waves-effect">
                                <span>Ambil Obat</span>
                            </a>
                        </li>
                    </ul>
            </li>

             <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="icon-note menu-icon"></i><span class="nav-text">Data</span>
                </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('Poli.poli') }}" class=" waves-effect">
                                <span>Data Poli</span>
                            </a>
                        </li>
                        <li><a href="{{ route('Obat.obat') }}" class=" waves-effect">
                                <span>Data Obat</span>
                            </a>
                        </li>
                        <li><a href="{{ route('Rumah.rumah') }}" class=" waves-effect">
                                <span>Data Rumah Sakit</span>
                            </a>
                        </li>
                    </ul>
            </li>

            <li>
                <a href="{{ route('Riwayat.riwayat') }}">
                    <i class="icon-speedometer menu-icon"></i>
                    <span class="nav-text">Daftar Riwayat</span>
                </a>
            </li>
                      
        </ul>

    </div>
</div>
