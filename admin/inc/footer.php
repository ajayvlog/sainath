<div class="footer">
	<div class="footerleft">Trinity Solutions</div>
	<div class="footerright">&copy; <a href="www.trinitysolutions.in">www.trinitysolutions.in</a></div>
</div>


<script>
	<?php
	if ($_SESSION['company_id'] == '') {
	?>

		jQuery(document).ready(function() {
			jQuery('#myCompanyModal').modal('show');
		});
	<?php
	}
	?>

	function setcompany(selectcompany) {

		var selectcompany = document.getElementById('selectcompany').value;
		jQuery.ajax({
			type: 'POST',
			url: 'setcompany.php',
			data: 'selectcompany=' + selectcompany,
			dataType: 'html',
			success: function(data) {
				// alert(data);
				location = '<?php echo $pagename; ?>';
			}

		}); //ajax close

	}

	function changecompany() {
		jQuery('#myCompanyModal').modal('show');
	}
</script>