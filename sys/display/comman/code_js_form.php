<!-- Bootstrap 3.3.6 -->
<script src="<?php echo $theme_link; ?>bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App --> 
<script>
  var AdminLTEOptions = {
    /*https://adminlte.io/themes/AdminLTE/documentation/index.html*/
    sidebarExpandOnHover: true,
    navbarMenuHeight: "200px", //The height of the inner menu
    animationSpeed: 250,
  };
</script> 
<script src="<?php echo $theme_link; ?>dist/js/app.js"></script>
<!-- FastClick -->
<script src="<?php echo $theme_link; ?>plugins/fastclick/fastclick.js"></script>
<!-- Select2 -->
<script src="<?php echo $theme_link; ?>plugins/select2/select2.full.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo $theme_link; ?>dist/js/demo.js"></script>
<!--Toastr notification -->
<script src="<?php echo $theme_link; ?>toastr/toastr.js"></script>
<script src="<?php echo $theme_link; ?>toastr/toastr_custom.js"></script>
<!-- bootstrap datepicker -->
<script src="<?php echo $theme_link; ?>plugins/daterangepicker/moment.min.js"></script>
<script src="<?php echo $theme_link; ?>plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="<?php echo $theme_link; ?>plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Sweet alert -->
<script src="<?php echo $theme_link; ?>plugins/sweetalert2/dist/sweetalert2.all.min.js"></script>
<!-- Shortcut Keys -->
<script src="<?php echo $theme_link; ?>plugins/shortcuts/shortcuts.js"></script>
<!-- Custom JS -->
<script src="<?php echo $theme_link; ?>js/special_char_check.js"></script>
<script src="<?php echo $theme_link; ?>js/custom.js"></script>
<!-- Autocomplete -->      
<script src="<?php echo $theme_link; ?>plugins/autocomplete/autocomplete.js"></script>
<!-- Pace Loader -->
<script src="<?php echo $theme_link; ?>plugins/pace/pace.min.js"></script>

<!-- iCheck -->
<script src="<?php echo $theme_link; ?>plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({ 
      checkboxClass: 'icheckbox_square-orange',
      /*uncheckedClass: 'bg-white',*/
      radioClass: 'iradio_square-orange',
      increaseArea: '10%' // optional
    });
  });
  

  $(function($) { // this script needs to be loaded on every page where an ajax POST may happen
    $.ajaxSetup({ 
      data: {
        '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' 
      }  
    }); 
  });
    
    
    
  //Select-2
    $(".select2").select2({}); 
 
  //Date picker
  $(document).on('focus', '.datepicker', function () {
    $(this).datepicker({
      autoclose: true,
      format: 'dd-mm-yyyy',
      todayHighlight: true
    }); 
  });

  function uniq_id_gen() {
    $.ajax({
      type: "get",
      url: "company/gen_uniq_id",
      data: "",
      success: function (r) {
        $('.php_uniq_id_check').val(r);
      }
    });
  }

  function unbindAll(selector) {
    $(selector).off();
  }


  // Number Convert English to bangla
  var finalEnlishToBanglaNumber={'0':'০','1':'১','2':'২','3':'৩','4':'৪','5':'৫','6':'৬','7':'৭','8':'৮','9':'৯'}; 
  const formatter = new Intl.NumberFormat('en-IN');
  String.prototype.getDigitBanglaFromEnglish = function() {
      var retStr = this;
      for (var x in finalEnlishToBanglaNumber) {
          retStr = retStr.replace(new RegExp(x, 'g'), finalEnlishToBanglaNumber[x]);
      }
      return retStr;
  };

  


</script>
<!-- DATE RANGE PICKER -->
<script>
  $(function () {
    //Date range as a button
    $('.daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('.daterange-btn span').html(start.format('<?php echo strtoupper($VIEW_DATE) ;?>') + ' - ' + end.format('<?php echo strtoupper($VIEW_DATE);?>'))
      }
    );
  });


    function get_start_date(input_id){
        return $('#'+input_id).data('daterangepicker').startDate.format('<?php echo strtoupper($VIEW_DATE) ;?>');
    }
    function get_end_date(input_id){
        return $('#'+input_id).data('daterangepicker').endDate.format('<?php echo strtoupper($VIEW_DATE) ;?>');
    }


    // Pop-Over 
  $(document).ready(function(){
      $('[data-toggle="popover"]').popover();   
  });


// page-loader
$(document).ajaxStart(function() { Pace.restart(); }); 

// alert-dismiss
$(document).ready(function () { setTimeout(function() {$( ".alert-dismissable" ).fadeOut( 1000, function() {});}, 10000); });


</script>
<script type="text/javascript">
  function round_off(input=0){
    <?php if(is_enabled_round_off()){ ?>
      return Math.round(input);
    <?php }else{?>
      return input;
    <?php }?>
  }
</script>
<script>
  function tax_disabled(){
    <?php if(is_tax_disabled()){ ?>
      return true;
    <?php }else{?>
      return false;
    <?php }?>
  }
</script>