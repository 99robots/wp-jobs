// JavaScript Document
jQuery(document).ready(function($){
	$("#form1").submit(function(){
		$('#wpjobs_loading').show();
		$('#wpjobs_submit').attr('disabled', true);
		data = $("#form1").serialize()+'&do=update_wpjobs_options&action=update_wpjobs_options&wpjobs_nonce='+wpjobs_vars.wpjobs_nonce;
		
		$.post(ajaxurl, data, function (response) {
			//alert(response);
			$('#wpjobs_output_div').html(response).fadeIn().delay(1000).fadeOut();
			$('#wpjobs_loading').hide();
			$('#wpjobs_submit').attr('disabled', false);
		});

		return false;
	});
});