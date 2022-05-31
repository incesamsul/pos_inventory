@foreach ($pembelian as $row)
<tr>
    <td>{{ $row->kode_barang }}</td>
    <td>{{ $row->nama_barang }}</td>
    <td>{{ $row->barcode }}</td>
    <td>{{ $row->kode_satuan }}</td>
    <td>{{ $row->stok_minimal }}</td>
    <td>{{ $row->modal }}</td>
    <td>{{ $row->harga_jual_1 }}</td>
    <td>{{ $row->stok_akhir }}</td>
    <td>{{ $row->hpp }}</td>
    <td class="option">
        <div class="btn-group dropleft btn-option">
            <i type="button" class="dropdown-toggle" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-ellipsis-v"></i>
            </i>
            <div class="dropdown-menu">
                {{-- <a data-pengguna='@json($p)' data-toggle="modal"
                    data-target="#modalLayanan" class="dropdown-item kaitkan" href="#"><i
                        class="fas fa-link"> Kaitkan data</i></a> --}}
                <a data-barang='@json($row)' data-toggle="modal"
                    data-target="#modalLayanan" class="dropdown-item edit" href="#"><i
                        class="fas fa-pen"> </i> Edit</a>
                <a data-kode_barang="{{ $row->kode_barang }}"
                    class="dropdown-item hapus" href="#"><i class="fas fa-trash"> </i>
                    Hapus</a>
            </div>
        </div>
    </td>
</tr>
@endforeach

<tr class="no-hover">
    <td colspan="10" class="text-center">
        <br>
        {!! $pembelian->links('pagination::bootstrap-4') !!}
    </td>
</tr>
