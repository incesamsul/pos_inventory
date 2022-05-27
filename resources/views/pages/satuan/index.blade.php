@extends('layouts.v_template')

@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex  justify-content-between">
                    <h4>Satuan</h4>
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
                                <td>Kode saatuan</td>
                                <td>Nama satuan</td>
                                <td>Jumlah pcs</td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($satuan as $row)
                            <tr>
                                <td>{{ $row->kode_satuan }}</td>
                                <td>{{ $row->nama_satuan }}</td>
                                <td>{{ $row->jumlah_pcs }}</td>
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
{{-- MODAL TAMBAH LAYANAN --}}
<div class="modal fade" id="modalLayanan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Tambah Lyayanan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            {{-- MODAL BODY UNTUK TAMBAH USER DAN EDIT USER --}}
            <div class="modal-body" id="main-body">
                {{-- @if (session('message'))
                {{ sweetAlert(session('message'), 'success') }}
                @endif --}}
                <form id="formLayanan" action="{{ URL::to('/admin/create_satuan') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="kode_satuan">Kode Satuan</label>
                        <input type="hidden" class="form-control" name="id" id="id">
                        <input type="text" class="form-control" name="kode_satuan" id="kode_satuan">
                    </div>
                    <div class="form-group">
                        <label for="nama_satuan">Nama satuan</label>
                        <input type="text" class="form-control" name="nama_satuan" id="nama_satuan">
                    </div>
                    <div class="form-group">
                        <label for="jumlah_pcs">Jumlah pcs</label>
                        <input type="text" class="form-control" name="jumlah_pcs" id="jumlah_pcs">
                    </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" id="modalBtn">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {


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

    $('#liSatuan').addClass('active');
    // $('#liManajemenPengguna').addClass('active');

</script>
@endsection
