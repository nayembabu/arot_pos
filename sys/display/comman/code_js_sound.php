<!-- Notification sound -->
<audio id="failed">
  <source src="<?php echo $theme_link; ?>sound/failed.mp3" type="audio/mpeg">
  <source src="<?php echo $theme_link; ?>sound/failed.ogg" type="audio/ogg">
</audio>
<audio id="success">
  <source src="<?php echo $theme_link; ?>sound/success.mp3" type="audio/mpeg">
  <source src="<?php echo $theme_link; ?>sound/success.ogg" type="audio/ogg">
</audio>
<audio id="buy">
  <source src="<?php echo $theme_link; ?>sound/buy.mp3" type="audio/mpeg">
  <source src="<?php echo $theme_link; ?>sound/buy.ogg" type="audio/ogg">
</audio>
<audio id="sell">
  <source src="<?php echo $theme_link; ?>sound/sell.mp3" type="audio/mpeg">
  <source src="<?php echo $theme_link; ?>sound/sell.ogg" type="audio/ogg">
</audio>
<script type="text/javascript">
  var failed_sound = document.getElementById("failed"); 
  var success_sound = document.getElementById("success"); 
  var buy_sound = document.getElementById("buy"); 
  var sell_sound = document.getElementById("sell"); 
</script>

<script type="text/javascript">
<?php if($this->session->flashdata('success')!=''){ ?>
      success_sound.play();
<?php } ?>
<?php if($this->session->flashdata('failed')!=''){ ?>
      failed_sound.play();
<?php } ?>
<?php if($this->session->flashdata('buy')!=''){ ?>
      buy_sound.play();
<?php } ?>
<?php if($this->session->flashdata('sell')!=''){ ?>
      sell_sound.play();
<?php } ?>
</script> 
<!-- Notification end --> 