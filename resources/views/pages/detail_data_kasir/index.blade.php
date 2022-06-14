@extends('layouts.v_template')

@section('content')
<section class="section">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>detail kasir pada {{ $tgl }} segment {{ $segment }}</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama / Kode barang</th>
                                <th>Qty</th>
                                <th>Harga barang</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($detail_data_kasir as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $row->barang->nama_barang }}</td>
                                    <td>{{ $row->qty }}</td>
                                    <td>{{ "Rp. ".  number_format($row->barang->harga_jual_1) }}</td>
                                    <td>{{ "Rp. " . number_format($row->jumlah) }}</td>
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


    $('#liDataPenjualan').addClass('active');

</script>
@endsection
