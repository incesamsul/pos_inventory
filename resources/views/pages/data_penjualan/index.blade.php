@extends('layouts.v_template')

@section('content')
<section class="section">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="left d-flex flex-row ">
                        <h4 class="text-nowrap">Data penjualan per </h4>
                        <input type="date" value="{{ $tgl }}" id="input-filter-tgl" class="form-control">
                        <button class="btn btn-primary mx-2 filter-tgl"><i class="fas fa-sync"></i></button>
                    </div>
                    <a href="{{ URL::to('/kasir/cetak_data_penjualan/' . $tgl) }}" target="_blank" class="btn btn-primary mt-3">
                        <i class="fas fa-print"></i> Cetak
                    </a>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama / Kode barang</th>
                                <th>Jam penjualan</th>
                                <th>Qty</th>
                                <th>Harga barang</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $totalPenjualan = 0;
                                ?>
                            @foreach ($data_penjualan as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $row->barang->nama_barang }}</td>
                                    <td>{{ $row->jam_penjualan }}</td>
                                    <td>{{ $row->qty }}</td>
                                    <td>{{ "Rp. ".  number_format($row->harga_jual) }}</td>
                                    <td>{{ "Rp. " . number_format($row->jumlah) }}</td>
                                    <?php $totalPenjualan += $row->jumlah ?>
                                </tr>
                            @endforeach
                                <tr>
                                    <th class="text-center" colspan="5">TOTAL</th>
                                    <th>{{ 'Rp. '. number_format($totalPenjualan) }}</th>
                                </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="text-nowrap">Data retur  </h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama / Kode barang</th>
                                <th>Qty</th>
                                <th>Jam retur</th>
                                <th>Harga barang</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $totalRetur = 0;
                                ?>
                            @foreach ($retur as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $row->barang->nama_barang }}</td>
                                    <td>{{ $row->qty }}</td>
                                    <td>{{ $row->jam_retur }}</td>
                                    <td>{{ "Rp. ".  number_format($row->barang->harga_jual_1) }}</td>
                                    <td>{{ "Rp. " . number_format($row->jumlah) }}</td>
                                    <?php $totalRetur += $row->jumlah ?>
                                </tr>
                            @endforeach
                                <tr>
                                    <th class="text-center" colspan="5">TOTAL</th>
                                    <th>{{ 'Rp. '. number_format($totalRetur) }}</th>
                                </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="text-nowrap">Rekap data penjualan per {{ $tgl }}  </h4>
                </div>
                <div class="card-body">
                    <h4> Rp. {{ number_format($totalPenjualan - $totalRetur) }} TTOTAL TUNAI</h4>
                </div>
            </div>
        </div>
    </div>
</section>



<div id="printSection">
    {{-- <table class="table table-bordered"> --}}
        <table cellspacing='0' cellpadding='0' style="width:100%; color:black; font-size:85px !important; font-family:'Bahnschrift SemiBold SemiConden';  border-collapse: collapse;" border='0'>
        {{-- <thead>
            <tr>
                <th>#</th>
                <th>Nama / Kode barang</th>
                <th>Qty</th>
                <th>Harga Jual</th>
                <th>Jumlah</th>
            </tr>
        </thead> --}}
        <tbody>
            <tr>
                <td colspan="3" class="text-center">
                    <span class="text-center">TOKO SMART</span><br>
                    <span class="text-center">JL. TERMINAL BARU - MAPPASAILE</span><br>
                    <span class="text-center">PANGKAJENE - PANGKEP</span><br>
                    <span class="text-center">{{ date('d/m/Y H:s') }}</span><br>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="text-align:center;">========================</td>
            </tr>
            <tr>
                <td colspan="3" style="border-bottom: 1px dashed black"></td>
            </tr>
            @foreach ($data_penjualan as $row)

            @endforeach

            <tr>
                <td colspan = '2'><div style='text-align:left; color:black'>Total penjualan : </div></td><td style='text-align:left; font-size:90px; color:black'>  {{ number_format($totalPenjualan) }}</td>
            </tr>
            <tr>
                <td colspan = '2'><div style='text-align:left; color:black'>Total Retur : </div></td><td style='text-align:left; font-size:90px; color:black'>  {{ number_format($totalRetur) }}</td>
            </tr>
            <tr>
                <td colspan = '2'><div style='text-align:left; color:black'>Total Tunai : </div></td><td style='text-align:left; font-size:90px; color:black'>  {{ number_format($totalPenjualan - $totalRetur) }}</td>
            </tr>
            <tr>
                <td colspan="3" style="text-align:center;">========================</td>
            </tr>
            <tr>
                <td colspan = '2'><div style='text-align:left; color:black'>Dibuat Oleh,  </div></td><td style='text-align:left; font-size:90px; color:black'>  Mengetahui</td>
            </tr>
            <tr>
                <td><br></td>
                <td><br></td>
            </tr>
            <tr>
                <td><br></td>
                <td><br></td>
            </tr>
            <tr>
                <td colspan = '2'><div style='text-align:center; color:black'>(...........)  </div></td><td style='text-align:center; font-size:90px; color:black'>  (...........)</td>
            </tr>
        </tbody>
    </table>
</div>

@endsection
@section('script')
<script>
    $(document).ready(function() {


        $('.filter-tgl').on('click',function(){
            document.location.href = '/kasir/data_penjualan/' + $('#input-filter-tgl').val();
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


    $('#liDataPenjualan').addClass('active');

</script>
@endsection
