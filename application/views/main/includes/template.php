<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE HTML>
<html>
<?php $this->load->view("main/includes/header"); ?>

<body>
	<div id="layout" class="layout">
		<?php $this->load->view($content); ?>
	</div>
</body>

</html>