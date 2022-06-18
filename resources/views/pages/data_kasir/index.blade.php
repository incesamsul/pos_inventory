@extends('layouts.v_template')

@section('content')
<section class="section">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="left d-flex flex-row ">
                        <h4 class="text-nowrap">Data kasir per </h4>
                        <input type="date" value="{{ $tgl }}" id="input-filter-tgl" class="form-control">
                        <button class="btn btn-primary mx-2 filter-tgl"><i class="fas fa-sync"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table-data">
                        <thead>
                            <tr>
                                {{-- <th>#</th> --}}
                                <th>Segment</th>
                                <th>tgl penjualan</th>
                                <th>total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data_kasir as $row)
                                <tr>
                                    {{-- <td>{{ $loop->iteration }}</td> --}}
                                    <td>{{ $row->segment }}</td>
                                    <td>{{ $row->tgl_penjualan }}</td>
                                    <td> Rp. {{ number_format($row->total) }}</td>
                                    <td>
                                        <a class="btn btn-primary" href="{{ URL::to('/kasir/data_kasir/detail/' . $row->tgl_penjualan. '/' . $row->segment) }}">Lihat detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('script')
<script>
    $(document).ready(function() {


        $('.filter-tgl').on('click',function(){
            document.location.href = '/kasir/data_kasir/' + $('#input-filter-tgl').val();
        })

        $('#formPenyesuaian').on('submit',function(e){
            e.preventDefault();
            console.log($(this).serialize())
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                , url: '/kasir/save_penjualan_barang'
                , method: 'post'
                , data: $(this).serialize()
                // , dataType: 'json'
                , success: function(data) {
                    console.log(data);
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
                    $('.btn-simpan').prop('disabled', true)
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
                , url: '/kasir/get_all_barang'
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
                        let satuan = data[i].satuan !== null ? data[i].satuan.nama_satuan : data[i].kode_satuan;
                        option += '<option value="' + data[i].kode_barang + "," + data[i].harga_jual_1 + "," + satuan  + '">' + data[i].nama_barang + " " + data[i].barcode +'</option>';
                    }
                    element.find('.selectBarang').select2();
                    element.find('.selectBarang').html(option);
                    element.find('.selectBarang').on('change',function(){
                        element.find('.harga').html(addCommas($(this).val().split(",")[1]))
                        element.find('.satuan').html($(this).val().split(",")[2])
                        element.find('.jumlah').html(addCommas(parseInt(element.find('.qty').val()) * parseInt($(this).val().split(",")[1])));
                        console.log($('.jumlah'));
                        let total = 0;
                        $('.jumlah').each(function(){
                            total += parseInt($(this).text(), 10) || 0;
                        })
                        $('.total').html(total)
                    });
                    element.find('.qty').on('keyup',function(){
                        let total = 0;
                        $('.jumlah').each(function(){
                            total += parseFloat($(this).text(), 10) || 0;
                            $('.total').html("TOTAL : " +total)
                        })
                        element.find('.jumlah').html(addCommas(parseInt(element.find('.selectBarang').val().split(",")[1]) * parseInt($(this).val())));
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


    $('#liDataKasir').addClass('active');

</script>
@endsection
