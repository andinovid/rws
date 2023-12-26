<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="robots" content="noindex,nofollow">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Rajawali Management System</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/rms/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/rms/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/rms/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/rms/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/rms/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/rms/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->

  <link rel="stylesheet" href="<?php echo base_url() ?>assets/rms/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/rms/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://nightly.datatables.net/fixedcolumns/css/fixedColumns.dataTables.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/rms/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/rms/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

  <link rel="stylesheet" href="<?php echo base_url() ?>assets/rms/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/rms/dist/css/custom.css?key=<?php echo time(); ?>">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/rms/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/rms/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/rms/plugins/summernote/summernote-bs4.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img src="<?php echo base_url() ?>assets/rms/dist/img/loading.gif" alt="AdminLTELogo" height="100" width="100">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">

        <li class="nav-item">
          <a class="nav-link" href="javascript:window.location.reload(true);" role="button">
            <img src="<?php echo base_url() ?>assets/rms/dist/img/reload.png" width="20" style="margin-top: -3px;" />
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url(); ?>rms/logout" role="button">
            <i class="fas fa-power-off"></i>
            Logout
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <?php $this->load->view("rms/includes/menu"); ?>
    <?php $this->load->view($content); ?>

    <footer class="main-footer">
      <strong>Copyright &copy; 2023-2024 CV Rajawali Sampit</strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.0
      </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="<?php echo base_url() ?>assets/rms/plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="<?php echo base_url() ?>assets/rms/plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="<?php echo base_url() ?>assets/rms/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="<?php echo base_url() ?>assets/rms/plugins/select2/js/select2.full.min.js"></script>
  <script src="<?php echo base_url() ?>assets/rms/plugins/chart.js/Chart.min.js"></script>
  <!-- Sparkline -->
  <script src="<?php echo base_url() ?>assets/rms/plugins/sparklines/sparkline.js"></script>
  <!-- JQVMap -->
  <script src="<?php echo base_url() ?>assets/rms/plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="<?php echo base_url() ?>assets/rms/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="<?php echo base_url() ?>assets/rms/plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="<?php echo base_url() ?>assets/rms/plugins/moment/moment.min.js"></script>
  <script src="<?php echo base_url() ?>assets/rms/plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="<?php echo base_url() ?>assets/rms/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="<?php echo base_url() ?>assets/rms/plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="<?php echo base_url() ?>assets/rms/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <script src="<?php echo base_url() ?>assets/rms/plugins/moment/moment.min.js"></script>
  <script src="<?php echo base_url() ?>assets/rms/plugins/inputmask/jquery.inputmask.min.js"></script>
  <script src="<?php echo base_url() ?>assets/rms/plugins/mask/dist/jquery.mask.min.js"></script>
  <script src="<?php echo base_url() ?>assets/rms/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo base_url() ?>assets/rms/plugins/sweetalert2/sweetalert2.min.js"></script>
  <script src="<?php echo base_url() ?>assets/rms/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="https://nightly.datatables.net/fixedcolumns/js/dataTables.fixedColumns.min.js"></script>
  <script src="<?php echo base_url() ?>assets/rms/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?php echo base_url() ?>assets/rms/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?php echo base_url() ?>assets/rms/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="<?php echo base_url() ?>assets/rms/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="<?php echo base_url() ?>assets/rms/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="<?php echo base_url() ?>assets/rms/plugins/jszip/jszip.min.js"></script>
  <script src="<?php echo base_url() ?>assets/rms/plugins/pdfmake/pdfmake.min.js"></script>
  <script src="<?php echo base_url() ?>assets/rms/plugins/pdfmake/vfs_fonts.js"></script>
  <script src="<?php echo base_url() ?>assets/rms/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="<?php echo base_url() ?>assets/rms/plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="<?php echo base_url() ?>assets/rms/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

  <script src="<?php echo base_url() ?>assets/rms/plugins/jquery-number-master/jquery.number.min.js"></script>
  <script src="<?php echo base_url() ?>assets/rms/dist/js/adminlte.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="<?php echo base_url() ?>assets/rms/dist/js/demo.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->

  <script>
    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
      $('#reportrange input').val(start.format('Y-MM-DD') + ' - ' + end.format('Y-MM-DD'));
    }

    $('#reportrange').daterangepicker({
      startDate: start,
      endDate: end,
      ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      }
    }, cb);

    function reset() {
      $('#date-filter').val('');
      $('#pilihan').val('0');
      $('#jenis').val('0');
    }


    $(function() {

      $('.number').mask('000.000.000.000', {
        reverse: true
      });
      $('.datemask').inputmask('dd/mm/yyyy', {
        'placeholder': 'dd/mm/yyyy'
      })
      $('.select2').select2()
      $('.reservationdate').datetimepicker({
        format: 'Y-M-DD'
      })

      $(".data-table-generate").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": true,
        "ordering": false,
        "buttons": false,
        "paging": false,
      })

      $(".data-table-default").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": true,
        "ordering": false,
        "pageLength": 50,
        "buttons": false,
      })

      $(".data-table").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "ordering": false,
        "pageLength": 20,
        "buttons": [{
            extend: 'pdfHtml5',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'excelHtml5',
            exportOptions: {
              columns: ':visible'
            }
          },
          "colvis"
        ]
      }).buttons().container().appendTo('#DataTables_Table_0_wrapper .col-md-6:eq(0)');
      $('[data-toggle="tooltip"]').tooltip()


      $(".data-table-fixed").DataTable({
        fixedColumns: {
          left: 1,
          right: 1
        },

        "responsive": true,
        "scrollCollapse": true,
        "scrollX": true,
        "responsive": false,
        "lengthChange": false,
        "autoWidth": false,
        "ordering": false,
        "pageLength": 20,
        "buttons": [{
            extend: 'pdfHtml5',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'excelHtml5',
            exportOptions: {
              columns: ':visible'
            }
          },
          "colvis"
        ]
      })

      $(".data-table-fixed2").DataTable({
        fixedColumns: {
          left: 2,
          right: 1
        },

        "responsive": true,
        "scrollCollapse": true,
        "scrollX": true,
        "responsive": false,
        "lengthChange": false,
        "autoWidth": false,
        "ordering": false,
        "pageLength": 20,
        "buttons": [{
            extend: 'pdfHtml5',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'excelHtml5',
            exportOptions: {
              columns: ':visible'
            }
          },
          "colvis"
        ]
      })
      var $container = $(".fixed-table");
      var $scroller = $(".dataTables_scrollBody");;

      bindDragScroll($container, $scroller);
    })

    function validate(id) {
      var thisId = document.getElementById(id);
      // console.log("inside validate "+thisId);
      var remChars = thisId.value.replace(/[^0-9\.]/g, ''); // this is to remove alphabates and special characters
      thisId.value = remChars.replace(/\./g, ''); // this is to remove "DOT"
    }

    function bindDragScroll($container, $scroller) {

      var $window = $(window);

      var x = 0;
      var y = 0;

      var x2 = 0;
      var y2 = 0;
      var t = 0;

      $container.on("mousedown", down);
      $container.on("click", preventDefault);
      $scroller.on("mousewheel", horizontalMouseWheel); // prevent macbook trigger prev/next page while scrolling

      function down(evt) {
        //alert("down");
        if (evt.button === 0) {

          t = Date.now();
          x = x2 = evt.pageX;
          y = y2 = evt.pageY;

          $container.addClass("down");
          $window.on("mousemove", move);
          $window.on("mouseup", up);

          evt.preventDefault();

        }

      }

      function move(evt) {
        // alert("move");
        if ($container.hasClass("down")) {

          var _x = evt.pageX;
          var _y = evt.pageY;
          var deltaX = _x - x;
          var deltaY = _y - y;

          $scroller[0].scrollLeft -= deltaX;

          x = _x;
          y = _y;

        }

      }

      function up(evt) {

        $window.off("mousemove", move);
        $window.off("mouseup", up);

        var deltaT = Date.now() - t;
        var deltaX = evt.pageX - x2;
        var deltaY = evt.pageY - y2;
        if (deltaT <= 300) {
          $scroller.stop().animate({
            scrollTop: "-=" + deltaY * 3,
            scrollLeft: "-=" + deltaX * 3
          }, 500, function(x, t, b, c, d) {
            // easeOutCirc function from http://gsgd.co.uk/sandbox/jquery/easing/
            return c * Math.sqrt(1 - (t = t / d - 1) * t) + b;
          });
        }

        t = 0;

        $container.removeClass("down");

      }

      function preventDefault(evt) {
        if (x2 !== evt.pageX || y2 !== evt.pageY) {
          evt.preventDefault();
          return false;
        }
      }

      function horizontalMouseWheel(evt) {
        evt = evt.originalEvent;
        var x = $scroller.scrollLeft();
        var max = $scroller[0].scrollWidth - $scroller[0].offsetWidth;
        var dir = (evt.deltaX || evt.wheelDeltaX);
        var stop = dir > 0 ? x >= max : x <= 0;
        if (stop && dir) {
          evt.preventDefault();
        }
      }

    }
  </script>
</body>

</html>