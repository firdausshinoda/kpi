<script src="<?php echo base_url('assets/plugins/select2/select2.full.min.js');?>"></script>
<script src="<?php echo base_url('assets/dist/js/app.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/slimScroll/jquery.slimscroll.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/fastclick/fastclick.min.js'); ?>"></script>
<script type="text/javascript">
  function loading_page_start()
  {
    $("#loading").fadeIn("slow");
  }
  function loading_page_end()
  {
    $("#loading").fadeOut("slow");
  }
  function kosong()
  {
    $("#kosong").fadeIn("slow");
    setTimeout(
      function()
      {
        $("#kosong").fadeOut("slow");
      },2000);
  }
  function isNumberKey(evt){
      var charCode = (evt.which) ? evt.which : evt.keyCode
      return !(charCode > 31 && (charCode < 48 || charCode > 57));
  }
</script>

