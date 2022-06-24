@extends('layouts.v_template')

@section('content')

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <form id="formPenyesuaian">
            <div class="card">
                <div class="card-header d-flex  justify-content-between">
                    <h4>edit kasir tgl {{ $tgl }} segment {{ $segment }}</h4>
                    <div class="table-tools d-flex justify-content-around ">
                        <img class="preloading" src="{{ asset('img/svg_animated/loading.svg') }}" alt="" width="50" >
                        <input type="text" class="form-control card-form-header mr-3" value="{{ $edit_data_kasir[0]->bayar }}"
                            placeholder="Masukkan pembayaran ..." id="pembayaran" onkeypress='validate(event)'>
                        <button type="button" class="btn btn-primary add-record float-right" data-toggle="modal" id="addUserBtn"
                            data-target="#modalLayanan"><i class="fas fa-plus"></i></button>
                    </div>
                </div>
                <div class="card-body ">
                    <div class="text-center">
                        <img class="preloading" src="{{ asset('img/svg_animated/loading.svg') }}" alt="" width="150" >
                    </div>
                    <div hidden>
                            <table id="sample_table">
                            <tr id="">
                            <td><span class="sn"></span>.</td>
                            <td class="td_barcode" style="padding-left: 9px;padding-right:9px;">
                                <select  name="kode_barang[]" class="form-control selectBarang">

                                </select>
                                </td>
                            <td style="padding-left: 9px;padding-right:9px;" class="harga">--</td>
                            <td style="padding-left: 9px;padding-right:9px; max-width:70px">
                                <input onkeypress='validate(event)' name="qty[]" type="text" class="form-control qty" style="padding: 10px">
                            </td>
                            <td class="satuan">satuan</td>
                            <td>%disc</td>
                            <td style="padding-left: 9px;padding-right:9px; max-width:70px">
                                <input value="0" onkeypress='validate(event)' name="rpdisc[]" type="text" class="form-control rpdisc" style="padding: 10px">
                            </td>
                            <td class="jumlah">--</td>
                            <td ><a class="btn btn-xs delete-record" data-id="0"><i class="fas fa-trash"></i></a></td>
                            </tr>
                        </table>
                     </div>
                     <?php $total = 0; ?>
                    <table class="table table-bordered " id="tbl_posts">
                        <thead>
                            <input type="hidden" name="tgl" value="{{ $tgl }}">
                            <input type="hidden" name="jam_penjualan" value="{{ $jam_penjualan }}">
                            <input type="hidden" name="segment" value="{{ $segment }}">
                          <tr>
                            <th>#</th>
                            <th style="width:514px; max-width:300px">Barcode / nama barang</th>
                            <th>Harga</th>
                            <th style="max-width:70px">QTY</th>
                            <th>Satuan</th>
                            <th>%Disc</th>
                            <th>RpDisc</th>
                            <th>Jumlah</th>
                            <th style="width:40px">Action</th>
                          </tr>
                        </thead>
                        <tbody id="tbl_posts_body">
                            @foreach ($edit_data_kasir as $row)
                            <?php $total+=($row->harga_jual * $row->qty - $row->rpdisc) ?>
                                <tr id="rec-{{ $loop->iteration }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="td_barcode" style="padding-left: 9px;padding-right:9px;">
                                        <select readonly  name="kode_barang[]" class="form-control selectBarang">
                                            <option value="{{ $row->kode_barang .",". $row->harga_jual_1 .",". $row->harga_jual_2.",". $row->harga_jual_3.",". $row->harga_jual_4.",". $row->harga_jual_5 . "," . $row->kode_satuan . "," . "lama" }}">{{ $row->barang->nama_barang }}</option>
                                        </select>
                                    </td>
                                    <td style="padding-left: 9px;padding-right:9px;" class="harga">
                                        <select readonly  name="harga_jual[]" class="form-control selectBarang">
                                            <option>{{ $row->harga_jual }}</option>
                                        </select>
                                    </td>
                                    <td style="padding-left: 9px;padding-right:9px; max-width:70px">
                                        <input readonly value="{{ $row->qty }}" onkeypress='validate(event)' name="qty[]" type="text" class="form-control qty" style="padding: 10px">
                                    </td>
                                    <td class="satuan">{{ $row->barang->satuan != null ? $row->barang->satuan->nama_satuan : $row->barang->kode_satuan }}</td>
                                    <td>%disc</td>
                                    <td style="padding-left: 9px;padding-right:9px; max-width:70px">
                                        <input readonly value="{{ $row->rpdisc }}" onkeypress='validate(event)' name="rpdisc[]" type="text" class="form-control rpdisc" style="padding: 10px">
                                    </td>
                                    <td class="jumlah">{{ number_format($row->harga_jual * $row->qty) }}</td>
                                    <td ><a class="btn btn-xs delete-record" data-id="{{ $loop->iteration }}"><i class="fas fa-trash"></i></a></td>
                                </tr>
                            @endforeach
                            {{-- <tr class="tb-info">
                                <td class="text-center" colspan="9">Klik tombol tambah untuk melakukan Penjualan</td>
                            </tr> --}}
                        </tbody>
                      </table>
                </div>
                <div class="card-footer">
                    <h3 class="float-left pembayaran text-success" style="margin-right:100px"> Bayar :  {{ number_format($edit_data_kasir[0]->bayar) }} </h3>
                    <h3 class="float-left total" style="margin-right:100px"> Total : {{ number_format($total) }} </h3>
                    <h3 class="float-left kembalian text-warning"> Kembalian:  {{ number_format($edit_data_kasir[0]->bayar - $total) }}</h3>
                    <input type="hidden" name="pembayaran" id="inputPembayaran">
                    <button type="submit" class="btn btn-primary float-right btn-simpan">Simpan</button>
                </div>
            </div>
        </form>
        </div>
    </div>
</section>

<div id="printSection">
    {{-- <table class="table table-bordered"> --}}
        <table cellspacing='0' cellpadding='0' style='width:100%; color:black; font-size:85px !important; font-family:calibri;  border-collapse: collapse;' border='0'>
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
            @foreach ($edit_data_kasir as $row)
                <tr>
                    {{-- <td>{{ $loop->iteration }}</td> --}}
                    <td colspan="3">{{ $row->barang->nama_barang }}</td>
                </tr>
                <tr>
                    <td class="text-right">{{ $row->qty }} x </td>
                    <td class="text-right">{{ "Rp. ".  number_format($row->harga_jual) }}</td>
                    <td class="text-right"> = {{ "Rp. " . number_format($row->jumlah) }}</td>
                </tr>
                </tr>
            @endforeach
            <tr>
                <td colspan="3" style="text-align:center;">========================</td>
            </tr>
            <tr>
                <td colspan = '2'><div style='text-align:right; color:black'>Total : </div></td><td style='text-align:right; font-size:90px; color:black'> Rp.  {{ number_format($edit_data_kasir->sum('jumlah')) }}</td>
            </tr>
            <tr>
                <td colspan = '2'><div style='text-align:right; color:black'>Bayar : </div></td><td style='text-align:right; font-size:90px; color:black'> Rp.  {{ number_format(count($edit_data_kasir) > 0 ? $edit_data_kasir[0]->bayar : 0) }}</td>
            </tr>
            <tr>
                <td colspan = '2'><div style='text-align:right; color:black'>Kembalian : </div></td><td style='text-align:right; font-size:90px; color:black'> Rp.  {{ number_format((count($edit_data_kasir) > 0 ? $edit_data_kasir[0]->bayar : 0) - $edit_data_kasir->sum('jumlah')) }}</td>
            </tr>
            <tr>
                <td colspan="3" style="text-align:center;">========================</td>
            </tr>
            <tr>
                <td colspan="3">Terima kasih atas kunjugannya</td>
            </tr>
        </tbody>
    </table>
</div>


@endsection
@section('script')
<script>
    $(document).ready(function() {

        // Pembayaran
        $('#pembayaran').on('keyup',function(){
            $('.pembayaran').html("BAYAR : " + addCommas($(this).val()));
            $('.kembalian').html("KEMBALIAN : " + addCommas($(this).val() - parseInt($('.total').text().split(" : ")[1].split(",").join("")))) ;
            $('#inputPembayaran').val($(this).val());
            if($(this).val() >= parseInt($('.total').text().split(" : ")[1].split(",").join(""))){
                $('.btn-simpan').prop('disabled',false);
            } else {
                // $('.btn-simpan').prop('disabled',true);
            }
        })

        // hide element at first load
        $('#pembayaran').hide();
        $('.add-record').hide();
        $('#tbl_posts').hide();
        $('.btn-simpan').hide();
        // $('.btn-simpan').prop('disabled',true);

        $('#formPenyesuaian').on('submit',function(e){
            e.preventDefault();
            console.log($(this).serialize())
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                , url: '/kasir/update_penjualan_barang'
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


        // SHORTCUT SETTING HERE

        document.onkeyup = function(e) {
            if (e.which == 187) { // tekan tombol plus
                $('.add-record').click()
            } else if(event.ctrlKey && event.key == "Enter") {
                $('.btn-simpan').click();
            } else if(event.ctrlKey && e.which == 46) { // ctrl + del
                $('#tbl_posts tr:last td:last').children().click();
            } else if(event.ctrlKey && e.which == 66) { // ctrl + b
                $('#pembayaran').focus();
            } else if(e.which == 44) { // tombol print screen
                $('.btn-print').click();
            } else if(event.ctrlKey && e.which == 77) { // ctrl + m
                window.open(window.location.href, '_blank');
            }
        };


        function requestAllData(){
            return $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                        , url: '/kasir/get_all_barang'
                        , method: 'post'
                        , dataType: 'json'
                        , beforeSend: function(){
                            // element.find('.selectBarang').hide();
                        }
                        , complete: function(){
                            $('#pembayaran').show();
                            $('.add-record').show();
                            $('#tbl_posts').show();
                            $('.btn-simpan').show();
                            $('.preloading').hide();
                        }
                        , success: function(data) {
                            // callback(data);
                        }
                        , error: function(err){
                            console.log(err);
                        }
                    });
        }


        $.when(requestAllData()).done(function(data){
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

                let option = "";
                option += '<option value="">-- pilih barang --</option>';
                for (i in data) {
                    let satuan = data[i].satuan !== null ? data[i].satuan.nama_satuan : data[i].kode_satuan;
                    option += '<option value="' + data[i].kode_barang + "," + data[i].harga_jual_1 + "," + data[i].harga_jual_2 + "," + data[i].harga_jual_3 + "," + data[i].harga_jual_4 + "," + data[i].harga_jual_5 + "," + satuan  + "," + "baru" + '">' + data[i].nama_barang + " " + data[i].barcode +'</option>';
                }
                element.find('.selectBarang').select2({
                    width: 'element'
                });


                element.find('.selectBarang').html(option);


                element.find('.selectBarang').on('change',function(){

                    let total = 0;
                    setTimeout(() => {
                        $('.jumlah').each(function(){
                            total += parseFloat($(this).text().split(",").join(""), 10) || 0;
                        })
                        $('.total').html("TOTAL : " + addCommas(total))
                    }, 500);

                    let hargaHTML = '<select class="form-control selectHarga harga_jual" name="harga_jual[]">';
                        hargaHTML += '<option>' + $(this).val().split(",")[1] + '</option>';
                        hargaHTML += '<option>' + $(this).val().split(",")[2] + '</option>';
                        hargaHTML += '<option>' + $(this).val().split(",")[3] + '</option>';
                        hargaHTML += '<option>' + $(this).val().split(",")[4] + '</option>';
                        hargaHTML += '<option>' + $(this).val().split(",")[5] + '</option>';
                        hargaHTML += '<option value="custom">Custom</option>'
                        hargaHTML += '</select>';
                        element.find('.harga').html(hargaHTML);

                        element.find('.harga_jual').on('change', function(){
                            if($(this).val() == 'custom'){
                                let customHTML = '<input type="text" class="form-control harga_jual" name="harga_jual[]">';
                                element.find('.harga').html(customHTML);
                                // $(this).parent().parent().parent().parent().parent().html('');
                                element.find('.harga_jual').on('keyup', function(){
                                    let total = 0;
                                    setTimeout(() => {
                                        $('.jumlah').each(function(){
                                            total += parseFloat($(this).text().split(",").join(""), 10) || 0;
                                        })
                                        $('.total').html("TOTAL : " + addCommas(total))
                                    }, 500);
                                    element.find('.jumlah').html(addCommas(parseInt(element.find('.qty').val()) * parseInt($(this).val()) - parseInt(element.find('.rpdisc').val())));
                                })
                            }
                            element.find('.jumlah').html(addCommas(parseInt(element.find('.qty').val()) * parseInt($(this).val() ) - parseInt(element.find('.rpdisc').val())));
                            let total = 0;
                            setTimeout(() => {
                                $('.jumlah').each(function(){
                                    total += parseFloat($(this).text().split(",").join(""), 10) || 0;
                                })
                                $('.total').html("TOTAL : " + addCommas(total))
                            }, 500);
                        })
                    // element.find('.harga').html(addCommas($(this).val().split(",")[1]))
                    element.find('.satuan').html($(this).val().split(",")[6])
                    element.find('.jumlah').html(addCommas(parseInt(element.find('.qty').val()) * parseInt($(this).val().split(",")[1]) - parseInt(element.find('.rpdisc').val()) ));

                });

                element.find('.qty').on('keyup',function(){
                    let total = 0;
                    setTimeout(() => {
                        $('.jumlah').each(function(){
                            total += parseFloat($(this).text().split(",").join(""), 10) || 0;
                        })
                        $('.total').html("TOTAL : " + addCommas(total))
                    }, 500);
                    element.find('.jumlah').html(addCommas(parseInt(element.find('.harga_jual').val()) * parseInt($(this).val()) - parseInt(element.find('.rpdisc').val()) ));
                })

                element.find('.rpdisc').on('keyup',function(){
                    let total = 0;
                    setTimeout(() => {
                        $('.jumlah').each(function(){
                            total += parseFloat($(this).text().split(",").join(""), 10) || 0;
                        })
                        $('.total').html("TOTAL : " + addCommas(total))
                    }, 500);
                    element.find('.jumlah').html(addCommas(parseInt(element.find('.harga_jual').val()) * parseInt(element.find('.qty').val()) - parseInt($(this).val())));
                })
            })


        });




        $(document).delegate('a.delete-record', 'click', function(e) {
            e.preventDefault();
            let total = 0;
            setTimeout(() => {
                $('.jumlah').each(function(){
                    total += parseFloat($(this).text().split(",").join(""), 10) || 0;
                })
                $('.total').html("TOTAL : " + addCommas(total))
            }, 500);
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


    $('#liPenjualan').addClass('active');

</script>
@endsection
