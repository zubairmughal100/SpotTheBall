<script>
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('signup-needs-validation');
    
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();

          //Dropdown list have issue with bootstrap default validation
          var dobDay = $.trim($("#dobDay").val());
          var dobMonth = $.trim($("#dobMonth").val());
          var dobYear = $.trim($("#dobYear").val());

          if((dobDay === '' || dobDay === 'null') && dobDay < 1){
            console.log('Value: ' + dobDay + " failed");
          }else{
            console.log('Value: ' + dobDay + " passed");
          }

          //Change form height
          $('#formErroModal').modal('show');
          
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>



<script>
$(document).ready(function(){
  $('#drivingLicenseOrPassportFile').change(function() {
    $(this).next('label').text($(this).val());
  })

  $('#utilityBillFile').change(function() {
    $(this).next('label').text($(this).val());
  })

  $('#bankStatementFile').change(function() {
    $(this).next('label').text($(this).val());
  })
});
</script>