<script>
	$(document).ready(function(){
		//Payment methods
	    $("#paymentMethod").change(function(){
	        var paymentMethod = $(this).val();
	        switch(paymentMethod) {
	            case 'Stripe':
	                //Hide PayPal
	                $(".paypal").addClass( "d-none" )
	                //Hide Bitcoin
	                $(".bitcoin").addClass( "d-none" )
	                //Show Stripe
	                $(".stripe").removeClass( "d-none" )
	                break;
	            case 'PayPal':
	                //Hide Stripe
	                $(".stripe").addClass( "d-none" )
	                //Hide Bitcoin
	                $(".bitcoin").addClass( "d-none" )
	                //Show PayPal
	                $(".paypal").removeClass( "d-none" )
	                break;
	            case 'Bitcoin':
	                //Hide Stripe
	                $(".stripe").addClass( "d-none" )
	                //Hide PayPal
	                $(".paypal").addClass( "d-none" )
	                //Show Bitcoin
	                $(".bitcoin").removeClass( "d-none" )
	                break;
	            default:
	                // code block
	        }
	    });



	    
	});
</script>