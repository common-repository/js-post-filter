jQuery(document).ready(function(){
		// alert('test');
	jQuery("#jsposttype").change(function() {
		//alert(this.value);
		jQuery.ajax({
			  type: "POST",
			  data : {
				action: "jsajaxpostfilter",
				posttype : this.value,
				  },
			  url: "wp-admin/admin-ajax.php",
			  beforeSend: function() {
				// $("#wait").show();  
				},
			  success: function(data){
			 //alert(data);
			//	$("#wait").hide();
			  jQuery('#filterresults').html(data);
			  }
		});
	});	
});
