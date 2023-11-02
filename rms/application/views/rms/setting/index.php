<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pengaturan Aplikasi</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Pengaturan</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Pengaturan</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form id="form_setting" class="form-horizontal" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id">
                                <div class="row">
                                    <div class="col-md-3">
                                        <h4>Pengaturan Biaya Adm</h4>
                                        <hr>
                                        <div class="form-group">
                                            <label for="nama_rekening">Biaya Admin Replas</label>
                                            <input type="text" class="form-control number" id="biaya_admin" name="biaya_admin" placeholder="Input jumlah transaksi">
                                        </div>
                                        <div class="form-group">
                                            <label for="nama_rekening">Biaya PPH SKB %</label>
                                            <input type="text" class="form-control " id="pph_skb" name="pph_skb" placeholder="Input jumlah transaksi">
                                        </div>
                                        <div class="form-group">
                                            <label for="nama_rekening">Biaya PPH NPWP %</label>
                                            <input type="text" class="form-control" id="pph_npwp" name="pph_npwp" placeholder="Input jumlah transaksi">
                                        </div>
                                        <div class="form-group">
                                            <label for="nama_rekening">Biaya PPH KTP %</label>
                                            <input type="text" class="form-control" id="pph_ktp" name="pph_ktp" placeholder="Input jumlah transaksi">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <h4>Pengaturan Oli Mesin Truk</h4>
                                        <hr>
                                        <div class="form-group">
                                            <label for="nama_rekening">Max Ganti Oli Mesin Euro 3</label>
                                            <input type="text" class="form-control number" id="max_oli_mesin_euro3" name="max_oli_mesin_euro3" placeholder="Input jumlah transaksi">
                                        </div>
                                        <div class="form-group">
                                            <label for="nama_rekening">Max Ganti Oli Mesin Euro 4</label>
                                            <input type="text" class="form-control number" id="max_oli_mesin_euro4" name="max_oli_mesin_euro4" placeholder="Input jumlah transaksi">
                                        </div>
                                        <div class="form-group">
                                            <label for="nama_rekening">Max Ganti Oli Mesin Isuzu Diesel</label>
                                            <input type="text" class="form-control number" id="max_oli_mesin_isuzu" name="max_oli_mesin_isuzu" placeholder="Input jumlah transaksi">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <h4>Pengaturan Oli Gardan Truk</h4>
                                        <hr>
                                        <div class="form-group">
                                            <label for="nama_rekening">Max Ganti Oli Gardan Euro 3</label>
                                            <input type="text" class="form-control number" id="max_oli_gardan_euro3" name="max_oli_gardan_euro3" placeholder="Input jumlah transaksi">
                                        </div>
                                        <div class="form-group">
                                            <label for="nama_rekening">Max Ganti Oli Gardan Euro 4</label>
                                            <input type="text" class="form-control number" id="max_oli_gardan_euro4" name="max_oli_gardan_euro4" placeholder="Input jumlah transaksi">
                                        </div>
                                        <div class="form-group">
                                            <label for="nama_rekening">Max Ganti Oli Gardan Isuzu Diesel</label>
                                            <input type="text" class="form-control number" id="max_oli_gardan_isuzu" name="max_oli_gardan_isuzu" placeholder="Input jumlah transaksi">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <h4>Pengaturan Oli Transmisi Truk</h4>
                                        <hr>
                                        <div class="form-group">
                                            <label for="nama_rekening">Max Ganti Oli Transmisi Euro 3</label>
                                            <input type="text" class="form-control number" id="max_oli_transmisi_euro3" name="max_oli_transmisi_euro3" placeholder="Input jumlah transaksi">
                                        </div>
                                        <div class="form-group">
                                            <label for="nama_rekening">Max Ganti Oli Transmisi Euro 4</label>
                                            <input type="text" class="form-control number" id="max_oli_transmisi_euro4" name="max_oli_transmisi_euro4" placeholder="Input jumlah transaksi">
                                        </div>
                                        <div class="form-group">
                                            <label for="nama_rekening">Max Ganti Oli Transmisi Isuzu Diesel</label>
                                            <input type="text" class="form-control number" id="max_oli_transmisi_isuzu" name="max_oli_transmisi_isuzu" placeholder="Input jumlah transaksi">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="col-md-offset-2">
                                    <button type="submit" class="btn btn-primary btn-cons" style="margin-left: 5px;"><i class="fa fa-check"></i> Submit</button>
                                    <div class="loading" style="display: none;">
                                        <img src="<?php echo base_url(); ?>assets/rms/dist/img/ajax-loader.gif" />
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
</div>






<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript">
    $('#form_setting').on('submit', function(event) {
        event.preventDefault();
        var formData = new FormData($('#form_setting')[0]);
        $('.loading').show();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>rms/update_setting/',
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                $('#form_setting')[0].reset();
                $('.loading').hide();
                if (data.status = "true") {
                    Swal.fire({
                        icon: 'success',
                        title: "Success!",
                        text: "Setting has been saved.",
                        type: "success"
                    }).then((result) => {
                        location.reload();
                    });
                } else {
                    alert("failed!");
                }
            }
        });
    });



    $(document).ready(function() {
        $.ajax({
            url: "<?php echo base_url(); ?>rms/get_setting",
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                for (var i = 0; i < data.length; i++) {
                    $('[name="id"]').val(data[i].id);
                    $('[name="biaya_admin"]').val($.number(data[i].biaya_admin).replace(/\,/g, '.'));
                    $('[name="pph_skb"]').val(data[i].pph_skb);
                    $('[name="pph_npwp"]').val(data[i].pph_npwp);
                    $('[name="pph_ktp"]').val(data[i].pph_ktp);
                    $('[name="max_oli_mesin_euro3"]').val($.number(data[i].max_oli_mesin_euro3).replace(/\,/g, '.'));
                    $('[name="max_oli_mesin_euro4"]').val($.number(data[i].max_oli_mesin_euro4).replace(/\,/g, '.'));
                    $('[name="max_oli_mesin_isuzu"]').val($.number(data[i].max_oli_mesin_isuzu).replace(/\,/g, '.'));
                    $('[name="max_oli_gardan_euro3"]').val($.number(data[i].max_oli_gardan_euro3).replace(/\,/g, '.'));
                    $('[name="max_oli_gardan_euro4"]').val($.number(data[i].max_oli_gardan_euro4).replace(/\,/g, '.'));
                    $('[name="max_oli_gardan_isuzu"]').val($.number(data[i].max_oli_gardan_isuzu).replace(/\,/g, '.'));
                    $('[name="max_oli_transmisi_euro3"]').val($.number(data[i].max_oli_transmisi_euro3).replace(/\,/g, '.'));
                    $('[name="max_oli_transmisi_euro4"]').val($.number(data[i].max_oli_transmisi_euro4).replace(/\,/g, '.'));
                    $('[name="max_oli_transmisi_isuzu"]').val($.number(data[i].max_oli_transmisi_isuzu).replace(/\,/g, '.'));

                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    });


</script>