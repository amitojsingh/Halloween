jQuery("body").on("change","#wplc_environment", function() {
  var selection = jQuery(this).val();
  jQuery("#wplc_iterations").attr('readonly', selection>0);
  jQuery("#wplc_delay_between_loops").attr('readonly', selection>0);
       
  if (selection === '1') {
      /* Shared hosting - low level plan */
      jQuery("#wplc_iterations").val(20);
      jQuery("#wplc_delay_between_loops").val(1000);
  }
  else if (selection === '2') {
      /* Shared hosting - normal plan */
      jQuery("#wplc_iterations").val(55);
      jQuery("#wplc_delay_between_loops").val(500);
  }
  else if (selection === '3') {
      /* VPS */
      jQuery("#wplc_iterations").val(60);
      jQuery("#wplc_delay_between_loops").val(400);
  }
  else if (selection === '4') {
      /* Dedicated server */
      jQuery("#wplc_iterations").val(200);
      jQuery("#wplc_delay_between_loops").val(250);
  }
})


jQuery(document).ready(function($) {
	$("#wplc_new_server_token_btn").on("click",function(){
		$(this).addClass("disabled");
		var extText = $(this).text();
		$(this).text("Generating...");
		var data = {
			'action' : 'wplc_generate_new_node_token',
			'nonce': $("#wplc_new_server_token_nonce").val()      
		};

		jQuery.post(ajax_object.ajax_url, data, function(response) {
			$("#wplc_node_token_input").val(response);
			$("#wplc_new_server_token_btn").removeClass("disabled");
			$("#wplc_new_server_token_btn").text(extText);
		});
	});

	$("#wplc_new_secret_token_btn").on("click",function(){
		$(this).addClass("disabled");
		var extText = $(this).text();
		$(this).text("Generating...");
		var data = {
			'action' : 'wplc_new_secret_key',
			'nonce': $("#wplc_new_secret_token_nonce").val()      
		};

		jQuery.post(ajax_object.ajax_url, data, function(response) {
			$("#wplc_secret_token_input").val(response);
			$("#wplc_new_secret_token_btn").removeClass("disabled");
			$("#wplc_new_secret_token_btn").text(extText);
		});
	});
	
	
});