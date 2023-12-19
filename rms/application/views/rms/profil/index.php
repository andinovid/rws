<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Profil Saya</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Profil Saya</li>
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
                            <h3 class="card-title">Edit Profil</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form id="form_profil" class="form-horizontal" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="avatar-upload">
                                            <div class="avatar-edit">
                                                <form action="" method="post" id="form-image">
                                                    <input type='file' name="foto" id="imageUpload" accept=".png, .jpg, .jpeg" />
                                                    <label for="imageUpload"><i class="fa fa-camera"></i></label>
                                                </form>
                                            </div>
                                            <div class="avatar-preview">
                                                <img class="profile-user-img img-responsive img-circle" id="imagePreview" src="<?php echo base_url(); ?>assets/rms/documents/profil/<?php echo $profil->photo; ?>" alt="User profile picture">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="nama">Nama</label>
                                            <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $profil->id; ?>">
                                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $profil->name; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="text" class="form-control " id="email" name="email" value="<?php echo $profil->username; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Ganti Password</label>
                                            <input type="password" class="form-control " id="password" name="password">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-cons" style="margin-left: 5px;"><i class="fa fa-check"></i> Update</button>
                                            <div class="loading" style="display: none;">
                                                <img src="<?php echo base_url(); ?>assets/rms/dist/img/ajax-loader.gif" />
                                            </div>
                                        </div>
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
    $('#form_profil').on('submit', function(event) {
        event.preventDefault();
        var formData = new FormData($('#form_profil')[0]);
        $('.loading').show();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>rms/update_profil/',
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                $('#form_profil')[0].reset();
                $('.loading').hide();
                if (data.status = "true") {
                    Swal.fire({
                        icon: 'success',
                        title: "Berhasil!",
                        text: "Data berhasil disimpan.",
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

        $("#imageUpload").change(function(data) {

            var imageFile = data.target.files[0];
            var reader = new FileReader();
            reader.readAsDataURL(imageFile);

            reader.onload = function(evt) {
                $('#imagePreview').attr('src', evt.target.result);
                $('#imagePreview').hide();
                $('#imagePreview').fadeIn(650);
            }
        });
    });
</script>