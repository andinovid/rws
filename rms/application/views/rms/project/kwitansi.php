<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Kwitansi</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Kwitansi</li>
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
              <h3 class="card-title">Data Kwitansi</h3>
              <div class="card-tools mr-1">
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table class="table table-bordered table-striped data-table">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>No Kontrak</th>
                    <th>No DO</th>
                    <th>NO STO</th>
                    <th>Vendor</th>
                    <th>Jumlah Replas</th>
                    <th>Total</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 0;
                  foreach ($kwitansi as $row) :
                    $no++;
                  ?>
                    <tr>
                      <td><?php echo $no; ?></td>
                      <td><?php echo $row->no_kontrak; ?></td>
                      <td><?php echo $row->no_do; ?></td>
                      <td><?php echo $row->no_sto; ?></td>
                      <td><?php echo $row->vendor; ?></td>
                      <td><?php echo $row->total_replas; ?></td>
                      <td>Rp <?php echo number_format($row->grand_total, 0, "", "."); ?></td>

                      </td>
                      <td class="project-actions text-right">
                        <a class="btn btn-success btn-sm" href="<?php echo base_url(); ?>rms/print_kwitansi/<?php echo $row->id_project; ?>/<?php echo $row->id_vendor; ?>" data-toggle="tooltip" data-placement="top" title="Cetak Kwitansi">
                          <i class="fas fa-print">
                          </i>
                        </a>

                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th>No</th>
                    <th>No Kontrak</th>
                    <th>No DO</th>
                    <th>NO STO</th>
                    <th>Vendor</th>
                    <th>Jumlah Replas</th>
                    <th>Total</th>
                    <th></th>
                  </tr>
                </tfoot>
              </table>
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