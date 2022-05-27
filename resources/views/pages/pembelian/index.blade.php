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
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
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
                                            <a data-satuan='@json($row)' data-toggle="modal"
                                                data-target="#modalLayanan" class="dropdown-item edit" href="#"><i
                                                    class="fas fa-pen"> </i> Edit</a>
                                            <a data-kode_satuan="{{ $row->kode_satuan }}"
                                                class="dropdown-item hapus" href="#"><i class="fas fa-trash"> </i>
                                                Hapus</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
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

<!-- Modal -->
{{-- MODAL TAMBAH PENGGUNA --}}
<div class="modal fade" id="modalLayanan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{-- <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div> --}}


            {{-- MODAL BODY UNTUK TAMBAH USER DAN EDIT USER --}}
            <div class="modal-body" id="main-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <!-- MultiStep Form -->
    <div class="row justify-content-center mt-0">
        <div class="col-lg-12 text-center p-0 mt-3 mb-2">
            <div class="card shadow-none px-0 pt-4 pb-0 mt-3 mb-3">
                <h2><strong>Tambah data barang</strong></h2>
                <p>lengkapi data sebelum lanjutkan kehalaman berikutnya</p>
                <div class="row">
                    <div class="col-md-12 mx-0">
                        <form id="msform">
                            <!-- progressbar -->
                            <ul id="progressbar">
                                <li class="active" id="barang"><strong>Barang</strong></li>
                                <li id="stok"><strong>Stok</strong></li>
                                <li id="harga"><strong>Harga</strong></li>
                                <li id="confirm"><strong>Finish</strong></li>
                            </ul>
                            <!-- fieldsets -->
                            <fieldset>
                                <div class="form-card p-0 shadow-none">
                                    <h2 class="fs-title">Informasi Barang</h2>
                                    <div class="form-group">
                                        <label for="kode_barang">kode_barang</label>
                                        <input type="text" class="form-control" name="kode_barang" id="kode_barang" value="{{ bin2hex(random_bytes(5)) }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_barang">nama_barang</label>
                                        <input type="text" class="form-control" name="nama_barang" id="nama_barang">
                                    </div>
                                    <div class="form-group">
                                        <label for="barcode">barcode</label>
                                        <input type="text" class="form-control" name="barcode" id="barcode">
                                    </div>
                                </div>
                                <input type="button" name="next" class="next action-button" value="Lanjut"/>
                            </fieldset>
                            <fieldset>
                                <div class="form-card shadow-none p-0">
                                    <h2 class="fs-title">Informasi stok barang</h2>
                                    <div class="form-group">
                                        <label for="satuan">satuan</label>
                                        <select name="satuan" id="satuan" class="form-control select2">
                                            @foreach ($satuan as $row)
                                                <option value="{{ $row->kode_satuan }}">{{ $row->nama_satuan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="stok">Stok</label>
                                        <input type="text" class="form-control" name="stok" id="stok">
                                    </div>
                                    <div class="form-group">
                                        <label for="stok_minimal">Stok minimal</label>
                                        <input type="text" class="form-control" name="stok_minimal" id="stok_minimal">
                                    </div>
                                </div>
                                <input type="button" name="previous" class="previous action-button-previous" value="kembali"/>
                                <input type="button" name="next" class="next action-button" value="Lanjut"/>
                            </fieldset>
                            <fieldset>
                                <div class="form-card p-0 shadow-none">
                                    <h2 class="fs-title">Detail harga</h2>
                                    <div class="form-group">
                                        <label for="harga_jual_1">harga_jual_1</label>
                                        <input type="text" class="form-control" name="harga_jual_1" id="harga_jual_1">
                                    </div>
                                    <div class="form-group">
                                        <label for="harga_jual_2">harga_jual_2</label>
                                        <input type="text" class="form-control" name="harga_jual_2" id="harga_jual_2">
                                    </div>
                                    <div class="form-group">
                                        <label for="harga_jual_3">harga_jual_3</label>
                                        <input type="text" class="form-control" name="harga_jual_3" id="harga_jual_3">
                                    </div>
                                    <div class="form-group">
                                        <label for="harga_jual_4">harga_jual_4</label>
                                        <input type="text" class="form-control" name="harga_jual_4" id="harga_jual_4">
                                    </div>
                                    <div class="form-group">
                                        <label for="harga_jual_5">harga_jual_5</label>
                                        <input type="text" class="form-control" name="harga_jual_5" id="harga_jual_5">
                                    </div>
                                    <div class="form-group">
                                        <label for="harga_beli">harga_beli</label>
                                        <input type="text" class="form-control" name="harga_beli" id="harga_beli">
                                    </div>
                                    <div class="form-group">
                                        <label for="harga_pokok_penjualan">harga_pokok_penjualan</label>
                                        <input type="text" class="form-control" name="harga_pokok_penjualan" id="harga_pokok_penjualan">
                                    </div>
                                </div>
                                <input type="button" name="previous" class="previous action-button-previous" value="kembali"/>
                                <input type="button" name="make_payment" class="next action-button" value="Confirm" id="btn-confirm"/>
                            </fieldset>
                            <fieldset>
                                <div class="form-card shadow-none p-0">
                                    <h2 class="fs-title text-center">Success !</h2>
                                    <br><br>
                                    <div class="row justify-content-center">
                                        <div class="col-3">
                                            <img src="https://img.icons8.com/color/96/000000/ok--v2.png" class="fit-image">
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="row justify-content-center">
                                        <div class="col-7 text-center">
                                            <h5>Data telah berhasil disimpan !</h5>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>

            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" id="modalBtn">Tambah</button>
            </div> --}}
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {


        $('#btn-confirm').on('click',function(){
            let formData = $('#msform').serialize();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                , url: '/admin/create_pembelian'
                , method: 'post'
                // , dataType: 'json'
                , data: {
                    formData: formData
                }
                , success: function(data) {
                    console.log(data);
                    if (data == 1) {
                        Swal.fire('Berhasil', 'Data berhasil di tambah', 'success').then((result) => {
                            location.reload();
                        });
                    }
                }
                , error: function(err){
                    console.log(err);
                }
            })
        })




        // TOMBOL EDIT USER
        $('.table-user tbody').on('click', 'tr td a.edit', function() {
            let satuan = $(this).data('satuan');
            $('#kode_satuan').val(satuan.kode_satuan);
            $('#nama_satuan').val(satuan.nama_satuan);
            $('#jumlah_pcs').val(satuan.jumlah_pcs);
            $('#id').val(satuan.kode_satuan);
            $('#ModalLabel').html('Ubah Satuan');
            $('#modalBtn').html('Ubah');
            $('.modal-footer').show();
            $('#formLayanan').attr('action', '/admin/update_satuan');
        })

        // TOMBOL TAMBAH USER
        $('#addUserBtn').on('click', function() {
            $('#ModalLabel').html('Tambah Layanan');
            $('#modalBtn').html('Tambah');
            $('.modal-footer').show();
            $('#formLayanan').attr('action', '/admin/create_satuan');
        });


            // TOMBOL HAPUS USER
        $('.table-user tbody').on('click', 'tr td a.hapus', function() {
            let kodeSatuan = $(this).data('kode_satuan');
            Swal.fire({
                title: 'Apakah yakin?'
                , text: "Data tidak bisa kembali lagi!"
                , type: 'warning'
                , showCancelButton: true
                , confirmButtonColor: '#3085d6'
                , cancelButtonColor: '#d33'
                , confirmButtonText: 'Ya, Konfirmasi'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                        , url: '/admin/delete_satuan'
                        , method: 'post'
                        , dataType: 'json'
                        , data: {
                            kode_satuan: kodeSatuan
                        }
                        , success: function(data) {
                            if (data == 1) {
                                Swal.fire('Berhasil', 'Data telah terhapus', 'success').then((result) => {
                                    location.reload();
                                });
                            }
                        }
                        , error: function(err){
                            console.log(err);
                        }
                    })
                }
            })
        });





    });

    $('#liPembelian').addClass('active');
    $('#liDataBarang').addClass('active');

</script>
@endsection
