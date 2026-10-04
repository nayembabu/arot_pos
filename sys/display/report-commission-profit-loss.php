<!DOCTYPE html>
<html>
<head>
   <base href="<?php echo base_url(); ?>" target="">
   <?php include"comman/code_css_form.php"; ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">

<div class="wrapper">

 <?php include"sidebar.php"; ?>

  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        <?=$page_title;?>
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active"><?=$page_title;?></li>
      </ol>
    </section>
    <br>

    <div class="center container">
      <div class="card">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-filter"></i> ফিল্টার</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-3">
                <label>থেকে তারিখ</label>
                <div class="input-group date">
                  <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                  <input type="text" class="form-control datepicker commission_start_dates" readonly value="<?= date('d-m-Y');?>">
                </div>
              </div>
              <div class="col-md-3">
                <label> পর্যন্ত তারিখ</label>
                <div class="input-group date">
                  <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                  <input type="text" class="form-control datepicker commission_ending_dates" readonly value="<?= date('d-m-Y');?>">
                </div>
              </div>
              <div class="col-md-3">
                <label> মহাজন</label>
                <select class="form-control select2 commission_supplier_selecting_id">
                  <option value="">-- সব মহাজন --</option>
                  <?php foreach ($suppliers as $info) { ?>
                  <option value="<?= $info->id; ?>"><?= $info->supplier_name; ?> --- <?= $info->address; ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-md-3">
                <label>&nbsp;</label>
                <button type="button" class="btn btn-success form-control commission_profit_loss_serching_btn"><i class="fa fa-search"></i> খোঁজা করুন</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6 col-sm-6">
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3 class="commission_total_lots">০</h3>
              <p>মোট লট</p>
            </div>
            <div class="icon"><i class="fa fa-cubes"></i></div>
          </div>
        </div>
        <div class="col-md-6 col-sm-6">
          <div class="small-box bg-red">
            <div class="inner">
              <h3 class="commission_total_price">৳ ০</h3>
              <p>মোট ক্রয় মূল্য</p>
            </div>
            <div class="icon"><i class="fa fa-money"></i></div>
          </div>
        </div>
        <div class="col-md-6 col-sm-6">
          <div class="small-box bg-green">
            <div class="inner">
              <h3 class="commission_total_sales">৳ ০</h3>
              <p>মোট বিক্রয়</p>
            </div>
            <div class="icon"><i class="fa fa-cart-plus"></i></div>
          </div>
        </div>
        <div class="col-md-6 col-sm-6">
          <div class="small-box bg-teal">
            <div class="inner">
              <h3 class="commission_net_amounts">৳ ০</h3>
              <p>মোট <span class="commission_net_status">লাভ/ক্ষতি</span></p>
            </div>
            <div class="icon"><i class="fa fa-balance-scale"></i></div>
          </div>
        </div>
      </div>

    </div>
  </div>

 <?php include"footer.php"; ?>
</div>

<?php include"comman/code_js_sound.php"; ?>
<?php include"comman/code_js_form.php"; ?>
<script src="<?php echo $theme_link; ?>js/report_commission_profit_loss.js"></script>
<script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>

</body>
</html>