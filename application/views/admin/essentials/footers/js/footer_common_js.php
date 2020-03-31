  <?php
    defined('BASEPATH') OR exit("ooops, we are sorry. It's not you, it's us! Please use the back navigation button to go back.");

    ////////////////////////////////////////////////////////////////////////////////////////
    // LOAD ASSETS
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->helper( 'url' );
    $assets = base_url() . "assets/";
    $cssbase = base_url() . "assets/css/";
    $jsbase = base_url() . "assets/js/";

    $base = base_url() . index_page();
    ////////////////////////////////////////////////////////////////////////////////////////

?>
  <!-- Bootstrap core JavaScript-->
  <script src="<?php echo $jsbase; ?>admin/jquery.min.js"></script>
  <script src="<?php echo $jsbase; ?>admin/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?php echo $jsbase; ?>admin/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?php echo $jsbase; ?>admin/sb-admin-2.min.js"></script>

  <!-- Data Tables -->
  <script src="<?php echo $jsbase; ?>admin/jquery.dataTables.min.js"></script>
  <script src="<?php echo $jsbase; ?>admin/dataTables.bootstrap4.min.js"></script>

  <!-- Page level plugins -->
  <script src="<?php echo $jsbase; ?>admin/datatables-demo.js"></script>

  <!-- Page level custom scripts -->
  <script src="<?php echo $jsbase; ?>admin/chart/Chart.min.js"></script>
  
  


<script>
  // Example starter JavaScript for disabling form submissions if there are invalid fields
  $(document).ready(function() {
    $('#example').DataTable();
    $(document).on('click', '.edit_data', function(){  
           var Prize_id = $(this).attr("id");  
           $.ajax({  
                url:"<?php echo $base; ?>/admin/getDataRowPrize",  
                method:"POST",  
                data:{Prize_id:Prize_id},  
                dataType:"json",  
                success:function(data){
                 
                     $('#prize_name').val(data[0].prize_name);  
                     $('#prize_value').val(data[0].prize_value);  
                     $('#Stake_Row ').val(data[0].Stake_id );
                     
                          if (data[0].prize_type=='asset') {
                    
                    $("#Prize_type option[value='Asset']").attr("selected", "selected");
                
                }
                else {
                   
                    $("#Prize_type option[value='Money']").attr("selected", "selected");
          }
                  document.getElementById('Stake_Row').value = data[0].Stake_id;
                     
                     $('#id').val(data[0].id);  
                     
                     $('#add_data_Modal').modal('show');  
                }  
           });  
      });
} );
  (function() {
    'use strict';
    window.addEventListener('load', function() {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName('needs-validation');
      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');
        }, false);
      });
    }, false);
  })();
</script>