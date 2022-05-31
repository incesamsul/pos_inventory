@extends('layouts.v_template')

@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <form id="formPenyesuaian">
            <div class="card">
                <div class="card-header d-flex  justify-content-between">
                    <h4>Penyesuaian Stok</h4>
                    <div class="table-tools d-flex justify-content-around ">
                        <input type="text" class="form-control card-form-header mr-3"
                            placeholder="Cari Data Pengguna ..." id="searchbox">
                        <button type="button" class="btn btn-primary add-record float-right" data-toggle="modal" id="addUserBtn"
                            data-target="#modalLayanan"><i class="fas fa-plus"></i></button>
                    </div>
                </div>
                <div class="card-body ">
                    <div hidden>
                            <table id="sample_table">
                            <tr id="">
                            <td><span class="sn"></span>.</td>
                            <td class="td_barcode">
                                <img class="preloading" src="{{ asset('img/svg_animated/loading.svg') }}" alt="" width="50" >
                                <select  name="kode_barang[]" class="form-control selectBarang">

                                </select>
                                </td>
                            <td class="stok-akhir">--</td>
                            <td>
                                <input  name="stok_penyesuaian[]" type="number" class="form-control stok-penyesuaian">
                            </td>
                            <td class="stok-setelah-penyesuaian">--</td>
                            <td><a class="btn btn-xs delete-record" data-id="0"><i class="fas fa-trash"></i></a></td>
                            </tr>
                        </table>
                     </div>
                    <table class="table table-bordered" id="tbl_posts">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th style="width:40%">Barcode / nama barang</th>
                            <th>Stok akhir</th>
                            <th>Penyesuaian stok</th>
                            <th>Stok setelah penyesuaian</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody id="tbl_posts_body">
                            <tr class="tb-info">
                                <td class="text-center" colspan="6">Klik tombol tambah untuk melakukan penyesuaian barang</td>
                            </tr>
                        </tbody>
                      </table>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary float-right btn-simpan">Simpan</button>
                </div>
            </div>
        </form>
        </div>
    </div>
</section>

@endsection
@section('script')
<script>
    $(document).ready(function() {

        $('#formPenyesuaian').on('submit',function(e){
            e.preventDefault();
            console.log($(this).serialize())
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                , url: '/admin/save_penyesuaian_barang'
                , method: 'post'
                , data: $(this).serialize()
                // , dataType: 'json'
                , success: function(data) {
                    if(data == 1){
                        Swal.fire('Berhasil', 'Data telah berhasil di sesuaikan', 'success').then((result) => {
                                    location.reload();
                                });
                    }
                }
                , error: function(err){
                    console.log(err);
                }
                , beforeSend: function(){
                    // $('.btn-simpan').prop('disabled', true)
                }
            })
        })

        document.onkeyup = function(e) {
        if (e.which == 187) {
                $('.add-record').click()
            } else if(event.ctrlKey && event.key == "Enter") {
                $('.btn-simpan').click();
                }
        };



        $('.add-record').on('click',function(){
            var content = $('#sample_table tr'),
            size = $('#tbl_posts >tbody >tr').length + 1,
            element = null,
            element = content.clone();
            element.attr('id', 'rec-'+size);
            element.find('.delete-record').attr('data-id', size);
            element.appendTo('#tbl_posts_body');
            element.find('.sn').html(size);
            $('.tb-info').hide();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                , url: '/admin/get_all_barang'
                , method: 'post'
                , dataType: 'json'
                , beforeSend: function(){
                    element.find('.selectBarang').hide();
                }
                , complete: function(){
                    element.find('.selectBarang').show();
                    element.find('.preloading').hide();
                }
                , success: function(data) {
                    let option = "";
                    option += '<option value="">-- pilih barang --</option>';
                    for (i in data) {
                        option += '<option value="' + data[i].kode_barang + "," + data[i].stok_akhir + '">' + data[i].nama_barang + " " + data[i].barcode +'</option>';
                    }
                    element.find('.selectBarang').select2();
                    element.find('.selectBarang').html(option);
                    element.find('.selectBarang').on('change',function(){
                        element.find('.stok-akhir').html($(this).val().split(",")[1])
                        element.find('.stok-setelah-penyesuaian').html(parseInt(element.find('.stok-penyesuaian').val()) + parseInt($(this).val().split(",")[1]));
                    });
                    element.find('.stok-penyesuaian').on('keyup',function(){
                        element.find('.stok-setelah-penyesuaian').html(parseInt(element.find('.selectBarang').val().split(",")[1]) + parseInt($(this).val()));
                    })

                }
                , error: function(err){
                    console.log(err);
                }
            })
        })

        $(document).delegate('a.delete-record', 'click', function(e) {
            e.preventDefault();
            var didConfirm = confirm("Are you sure You want to delete");
            if (didConfirm == true) {
            var id = $(this).attr('data-id');
            var targetDiv = $(this).attr('targetDiv');
            $('#rec-' + id).remove();
            if($('#tbl_posts_body').find('tr').length < 2){
                $('.tb-info').show();
            }

            //regnerate index number on table
            $('#tbl_posts_body tr').each(function(index) {
            // alert(index);

            $(this).find('span.sn').html(index+1);
            });
            return true;
        } else {
            return false;
        }
        });

    });



    $('#liPenyesuaianStok').addClass('active');
    $('#liDataBarang').addClass('active');

</script>
@endsection
