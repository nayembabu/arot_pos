<!DOCTYPE html>
<html>

<head>
<base href="<?php echo base_url(); ?>" target="">
<!-- TABLES CSS CODE -->
<?php include"comman/code_css_form.php"; ?>
  <style>
    .custom-btn {
        background: linear-gradient(45deg, #ff7eb3, #ff758c);
        border: none;
        color: white;
        padding: 20px 50px;
        font-size: 22px;
        font-weight: bold;
        border-radius: 50px;
        transition: 0.3s;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        margin: 10px 0 10px 0; 
    }
    .custom-btn:hover {
        background: linear-gradient(45deg, #ff758c, #ff7eb3);
        transform: scale(1.1);
        box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.3);
    }
    .search-btn {
        background: #007bff;
        color: white;
        border: none;
        padding: 12px 25px;
        font-size: 18px;
        border-radius: 30px;
        transition: 0.3s;
    }
    .search-btn:hover {
        background: #0056b3;
        transform: scale(1.1);
    }

    .summary-box {
        padding: 20px;
        border-radius: 8px;
        margin: 10px 0;
        color: #fff;
    }
    .bg-total { background-color: #337ab7; }  /* Blue */
    .bg-paid { background-color: #5cb85c; }   /* Green */
    .bg-due  { background-color: #d9534f; }   /* Red */
    .summary-title {
        font-size: 18px;
    }
    .summary-amount {
        font-size: 24px;
        font-weight: bold;
    }
  </style>
<!-- </copy> -->  
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

 <?php include"sidebar.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- **********************MODALS***************** -->
    <?php include"modals/modal_amanot.php"; ?>
    <!-- **********************MODALS END***************** -->

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> 
        <?= $page_title; ?>
        <small>History</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      </ol>
    </section>
 
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- ********** ALERT MESSAGE START******* -->
            <?php include"comman/code_flashdata.php"; ?>
            <!-- ********** ALERT MESSAGE END******* -->
            <!-- right column -->
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="box box-info ">
                    
                    <!-- /.box-header -->
                    <div class="box-body">
                        <!-- /.box-body -->
                        <div class="box-footer">

                            <div class="col-md-4 text-center" style="margin-top: 10px; " >
                                <div class="input-group input-group-lg">
                                    <label for="name">আমানত ব্যাক্তি:</label>
                                    <select class="form-control form-control-lg id_select_person_infos selects_person_info select2 " id="name"  >
                                        <option value="">Select</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 text-center" style="margin-top: 10px; " >
                                <div class="input-group input-group-lg">
                                    <label for="stdate">শুরু তারিখ:</label>
                                    <input type="text" class="form-control form-control-lg datepicker select_start_date " id="stdate" placeholder="শুরু তারিখ" value="<?= date('d-m-Y'); ?>">
                                </div>
                            </div>
                            <div class="col-md-4 text-center" style="margin-top: 10px; " >
                                <div class="input-group input-group-lg">
                                    <label for="enddate">শেষ তারিখ:</label>
                                    <input type="text" class="form-control form-control-lg datepicker select_end_datess " id="enddate" placeholder="শেষ তারিখ" value="<?= date('d-m-Y'); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="btn custom-btn btn-lg search_this_amanot_historysss_btns ">
                                <span class="glyphicon glyphicon-search" style="top: 5px; " ></span> খুজুন 
                            </div>
                        </div>
                    </div>
                    <!-- /.box-footer -->
                </div>
                <!-- /.box -->

            </div>
            <!--/.col (right) -->
                    
            <div class="container">
                            

                <div class="row summary_datas_box_set ">

                </div>



                <div class="table-container table-responsive  ">
                    <h2 class="text-center">জমা খরচের তালিকা</h2>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th> 
                                <th>তারিখ</th>
                                <th>সময়</th>
                                <th>মারফত</th>
                                <th>জমা</th>
                                <th>খরচ</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="amanot_history_date_to_date_details " ></tbody>
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

<script src="<?php echo $theme_link; ?>js/payment.js"></script>

<script>
  $(function(){
    $("#accordion").accordion();
  });
</script>

<!-- Make sidebar menu hughlighter/selector -->
<script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
</body>
</html>
