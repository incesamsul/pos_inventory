@extends('layouts.v_template')

@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex  justify-content-between">
                    <h4>Pembelian</h4>
                    <div class="table-tools d-flex justify-content-around ">
                        <input type="text" class="form-control card-form-header mr-3"
                            placeholder="Cari Data Pengguna ..." id="searchbox">
                        <button type="button" class="btn btn-primary float-right" data-toggle="modal" id="addUserBtn"
                            data-target="#modalLayanan"><i class="fas fa-plus"></i></button>
                    </div>
                </div>
                <div class="card-body ">
                    <table class="table table-striped table-hover table-user table-action-hover" id="table-data">
                        <thead>
                            <tr>
                                <td>Kode barang</td>
                                <td>Nama barang</td>
                                <td>barcode</td>
                                <td>Kode satuan </td>
                                <td>Stok minimal </td>
                                <td>Modal </td>
                                <td>Harga jual </td>
                                <td>Stok akhir </td>
                                <td>Hpp </td>
                            </tr>
                        </thead>
                        <tbody>
                            @include('pages.stok_dibawah_minimum.stok_dibawah_minimum')
                        </tbody>
                    </table>
                    <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
                    <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="id" />
                    <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('script')
<script>
    $(document).ready(function() {

      





    });

    $('#liStokDibawahMin').addClass('active');
    $('#liDataBarang').addClass('active');

</script>
@endsection
