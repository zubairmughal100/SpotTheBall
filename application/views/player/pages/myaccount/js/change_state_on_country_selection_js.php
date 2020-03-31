<script>
$(document).ready(function(){
    $("select.country").change(function(){
        var selectedCountry = $(".country option:selected").val();
        var directory = "/SpotTheBallUKClient/index.php";
        var domain_name = document.location.origin + "" + directory + "/account/getstates";
        $.ajax({
            type: "POST",
            url: domain_name,
            data: { country : selectedCountry }
        }).done(function(data){
            console.log(data);
            $("#state").html(data);
        });
    });


    //Currency conversion, must move to ajax, this is only for test purposes
    $("#moneyAmount").keyup(function(){
        var moneyAmount = $(this).val();
        var exchangeRate = 0.76;
        var exchangeAmount = moneyAmount * exchangeRate;
        $("#creditAmount").val(exchangeAmount.toFixed(2));
    });


    
});
</script>