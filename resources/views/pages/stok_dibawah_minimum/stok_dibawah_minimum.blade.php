@foreach ($barang as $row)
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
</tr>
@endforeach

{{-- <tr class="no-hover">
    <td colspan="10" class="text-center">
        <br>
        {!! $barang->links('pagination::bootstrap-4') !!}
    </td>
</tr> --}}
