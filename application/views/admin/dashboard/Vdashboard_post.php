<html>
<script type="text/javascript">
  total_post = "<?php echo $stt_post+1;?>";
</script>
<?php foreach ($dashboard->result() as $dsh): ?>
  <div class="box box-widget">
    <div class='box-header with-border'>
      <div class='user-block'>
        <img class='img-circle' src="<?php echo base_url('assets/dist/img/avatar.png') ?>" alt='user image'>
        <span class='username'><a href="javascript:avoid();">Admin</a></span>
        <a onclick="delpost('<?php echo $dsh->id_dashboard;?>')" href="javascript:avoid()" title="Delete" class="pull-right fa fa-close"></a>
        <span class='description'><?php echo waktu_lalu2($dsh->cdate); ?></span>
      </div><!-- /.user-block -->
    </div>
    <div class='box-body'>
      <p><?php echo $dsh->isi; ?></p>
      <ul class="mailbox-attachments clearfix">
        <?php if (filepost($dsh->id_dashboard) == "0"): ?>
          <?php else: ?>
            <?php foreach (filepost($dsh->id_dashboard) as $file): ?>
              <?php echo $file; ?>
            <?php endforeach; ?>
        <?php endif; ?>
      </ul>
    </div>
    <div class="box-footer">
    </div>
  </div>
<?php endforeach; ?>
<?php $total = $dashboard->num_rows(); ?>
<?php if ($total == 0): ?>
  <script type="text/javascript">
    $("#loadmore").hide();
  </script>
  <?php else: ?>
    <script type="text/javascript">
      $("#loadmore").show();
    </script>
<?php endif; ?>
</html>
