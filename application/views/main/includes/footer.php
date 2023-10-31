<!-- Footer -->
<div class="float-nav">
	<a href="<?php if ($this->sess) { ?>#<?php }else{ ?><?php echo base_url(); ?>login/<?php } ?>" class="menu-btn">
		<div class="menu-txt"><?php if ($this->sess) { ?> Form Survey <?php }else{ ?> Login/Registrasi <?php } ?></div>
	</a>
</div>
<?php if ($this->sess) { ?>
	<div class="main-nav">
		<ul>
			<li><a href="<?php echo base_url(); ?>formulir-penilaian-kebutuhan-cepat/">Formulir Penilaian Kebutuhan Cepat</a></li>
			<li><a href="<?php echo base_url(); ?>formulir-pencatatan-dan-pelaporan-di-fasilitas-pelayanan-kontrasepsi/">Formulir Pencatatan dan Pelaporan</a></li>
			<li><a href="<?php echo base_url(); ?>daftar-tilik-monitoring-di-fasilitas-pelayanan">Daftar Tilik Monitoring</a></li>
		</ul>
	</div>
<?php } ?>
<footer id="footer" class="footer text-center bgc-primary-dark">
	<div class="copy text-center text-white mt-0">
		© 2020 BKKBN. All rights reserved
	</div>
</footer>
</div>


<!-- Scripts -->

<script src="<?php echo base_url(); ?>assets/main/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/main/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/js/lightbox.min.js"></script>
<script src="<?php echo base_url(); ?>assets/main/js/smoothscroll.js"></script>
<script src="<?php echo base_url(); ?>assets/main/js/wow.min.js"></script>
<script src="<?php echo base_url(); ?>assets/main/js/jquery.magnific-popup.min.js"></script>
<script src="<?php echo base_url(); ?>assets/main/js/owl.carousel.min.js"></script>
<script src="<?php echo base_url(); ?>assets/main/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>assets/main/js/jquery.stellar.min.js"></script>
<script src="<?php echo base_url(); ?>assets/main/js/jquery.easypiechart.min.js"></script>
<script src="<?php echo base_url(); ?>assets/main/js/jquery.ajaxchimp.min.js"></script>
<script src="<?php echo base_url(); ?>assets/main/js/interface.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/jquery/jconfirm/jquery-confirm.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/jquery/sweetalert/sweetalert.min.js" type="text/javascript"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/i18n/jquery-ui-timepicker-addon-i18n.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/i18n/jquery-ui-timepicker-pt-BR.js"></script>

<script>
	(function(factory) {
		if (typeof define === "function" && define.amd) {

			// AMD. Register as an anonymous module.
			define(["../datepicker"], factory);
		} else {

			// Browser globals
			factory(jQuery.datepicker);
		}
	}(function(datepicker) {

		datepicker.regional.id = {
			closeText: "Tutup",
			prevText: "&#x3C;mundur",
			nextText: "maju&#x3E;",
			currentText: "hari ini",
			monthNames: ["Januari", "Februari", "Maret", "April", "Mei", "Juni",
				"Juli", "Agustus", "September", "Oktober", "Nopember", "Desember"
			],
			hourText: "Jam",
			minuteText: "Menit",
			timeText: "Waktu",
			monthNamesShort: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun",
				"Jul", "Agus", "Sep", "Okt", "Nop", "Des"
			],
			dayNames: ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"],
			dayNamesShort: ["Min", "Sen", "Sel", "Rab", "kam", "Jum", "Sab"],
			dayNamesMin: ["Mg", "Sn", "Sl", "Rb", "Km", "jm", "Sb"],
			weekHeader: "Mg",
			dateFormat: "dd/mm/yy",
			firstDay: 0,
			isRTL: false,
			showMonthAfterYear: false,
			yearSuffix: ''
		};
		datepicker.setDefaults(datepicker.regional.id);

		return datepicker.regional.id;

	}));

	var options = $.extend({},
		$.datepicker.regional.id, {
			dateFormat: "yy-mm-dd"
		}
	);


	$("#selectDateTime").datetimepicker(options).val();
	$(".selectDate").datepicker(options).val();
	$(".selectTime").timepicker(options).val();

	$('.float-nav').click(function() {
		$('.main-nav, .menu-btn').toggleClass('active');
	});
</script>