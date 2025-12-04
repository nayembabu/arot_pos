<!DOCTYPE html>
<html>

<head>
<base href="<?php echo base_url(); ?>" target="">
<!-- TABLES CSS CODE -->
<?php include"comman/code_css_form.php"; ?>
<style>
    .form-container {
        background: rgba(255, 255, 255, 0.95);
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        max-width: 600px;
        margin: auto;
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }
    .form-container:hover {
        transform: scale(1.05);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
    }
    .btn-primary {
        background: linear-gradient(135deg, #ff416c, #ff4b2b);
        border: none;
        font-weight: bold;
        padding: 15px;
        border-radius: 30px;
        font-size: 18px;
        transition: background 0.3s ease-in-out, transform 0.2s;
    }
    .btn-primary:hover {
        background: linear-gradient(135deg, #ff1e56, #ff4b2b);
        transform: scale(1.1);
    }
    h2 {
        text-align: center;
        margin-bottom: 25px;
        color: #ff416c;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1.5px;
    }
    label {
        font-weight: bold;
        color: #333;
        font-size: 16px;
    }
    .form-control {
        border-radius: 30px;
        border: 2px solid #ff416c;
        padding: 20px;
        font-size: 20px;
        height: 65px;
        transition: all 0.3s ease-in-out;
    }
    .form-control:focus {
        border-color: #ff1e56;
        box-shadow: 0 0 15px rgba(255, 65, 108, 0.5);
    }
    .table-container {
        margin-top: 50px;
        background: rgba(255, 255, 255, 0.95);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
    }
</style>
<!-- </copy> -->  
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

 <?php include"sidebar.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$page_title;?>
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?=$page_title;?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
      

      <div class="container">
        <div class="form-container">
            <h2>ব্যক্তিগত তথ্য ফর্ম</h2>
            <div>
                <div class="form-group">
                    <label for="name">ব্যক্তির নাম:</label>
                    <input type="text" class="form-control _new_person_namess " id="name" placeholder="আপনার নাম লিখুন">
                </div>
                <div class="form-group">
                    <label for="address">ব্যক্তির ঠিকানা:</label>
                    <input type="text" class="form-control _new_person_addresss " id="address" placeholder="আপনার ঠিকানা লিখুন">
                </div>
                <div class="form-group">
                    <label for="phone">ব্যক্তির ফোন নম্বর:</label>
                    <input type="text" class="form-control _new_person_phone_nos " id="phone" placeholder="আপনার ফোন নম্বর লিখুন">
                </div>
                <div class="form-group">
                    <label for="phone">WhatsApp নম্বর:</label>
                    <input type="text" class="form-control _new_person_wa_nos " id="phone" placeholder="WhatsApp নম্বর লিখুন">
                </div>
                <div class="form-group">
                    <label for="phone">Imo নম্বর:</label>
                    <input type="text" class="form-control _new_person_imoss_phone " id="phone" placeholder="IMO নম্বর লিখুন">
                </div>
                <div class="btn btn-primary btn-block addedd_new_amanot_person ">নতুন ব্যক্তি এড করুন</div>
            </div>
        </div>
        
        <div class="table-container">
            <h2 class="text-center">ব্যক্তিগত তথ্য তালিকা</h2>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>নাম</th>
                        <th>ঠিকানা</th>
                        <th>ফোন নম্বর</th>
                        <th>WhatsApp নম্বর</th>
                        <th>IMO নম্বর</th>
                        <th>অপশন</th>
                    </tr>
                </thead>
                <tbody class="amanot_full_infos_details " ></tbody>
            </table>
        </div>
      </div>

      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 <?php include"footer.php"; ?>


  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<!-- SOUND CODE -->
<?php include"comman/code_js_sound.php"; ?>
<!-- TABLES CODE -->
<?php include"comman/code_js_form.php"; ?>
<?php include"modals/amanot_edit_modals.php"; ?>

<script src="<?php echo $theme_link; ?>js/payment.js"></script>
<script>
  get_amanot_person_info_for_editting();
</script>
<!-- Make sidebar menu hughlighter/selector -->
<script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
</body>
</html>
