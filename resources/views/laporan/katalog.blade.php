<!DOCTYPE html>
<html lang="en">

@include('laporan.head')

<body>
    {{-- <img src="{{ asset('uogp.png') }}" alt="" srcset="" class="img float-left"> --}}
    {{-- <img src="{{ public_path('uogp.png') }}" class="float-left img" alt="" srcset=""> --}}
    <div class="text-center">
        <h2 class="mt-1">UNIVERSITAS OTTOW GEISSLER PAPUA</h2>
        <h4 class="mt-1">Jln. Perkutut Kotaraja 99225 Jayapura - Papua Tlp.(0967)581562 Fax(0967)581133
        </h4>
        <h2 class="mt-1 text-capitalize">Laporan Perpustakaan Katalog {{ $jenis ? "$jenis" : '' }}
            {{ $tahun ? "Tahun $tahun" : '' }}
        </h2>
    </div>
    <hr class="garis_surat mt-2">
    <hr>
    <table class="mt-2 table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Class</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Penerbit</th>
                @if (!$tahun)
                    <th>Tahun</th>
                @endif
                @if (!$jenis)
                    <th>Jenis</th>
                @endif
                <th>Stok</th>
            </tr>

        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->class_sub->nm_sub }} - {{ $item->class_sub->class_umum->nm_sub }}</td>
                    <td>{{ $item->judul }}</td>
                    <td>{{ $item->penulis }}</td>
                    <td>{{ $item->penerbit }}</td>
                    @if (!$tahun)
                        <td>{{ $item->tahun }}</td>
                    @endif
                    @if (!$jenis)
                        <td class="text-capitalize">{{ $item->jenis }}</td>
                    @endif
                    <td>{{ $item->stok }}</td>
                </tr>
            @endforeach
        </tbody>

    </table>
    {{-- table --}}
</body>

</html>
