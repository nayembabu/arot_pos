<!DOCTYPE html>
<html>

<head>
<base href="<?php echo base_url(); ?>" target="">
<!-- TABLES CSS CODE -->
<?php include"comman/code_css_form.php"; ?>
  <style>
      .profile-container {
          margin-top: 50px;
      }
      .profile-card {
          background: linear-gradient(135deg, #6e8efb, #a777e3);
          padding: 10px;
          border-radius: 15px;
          box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
          text-align: center;
          color: white;
      }
      .profile-img {
          width: 100px;
          height: 100px;
          border-radius: 50%;
          border: 5px solid white;
          margin-bottom: 5px;
      }
      .panel {
          padding: 5px;
          border-radius: 15px;
          box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
          background: white;
      }
      .panel-heading {
          background: #6e8efb !important;
          color: white !important;
          padding: 5px;
          border-radius: 15px 15px 0 0;
          font-size: 20px;
          text-align: center;
      }

      
      .container {
            max-width: 960px;
            margin-top: 10px;
        }
        h2 {
            text-align: center;
            font-size: 32px;
            color: #333;
            margin-bottom: 5px;
            font-weight: 600;
        }
        .nav-tabs {
            border: none;
            margin-bottom: 5px;
        }
        .nav-tabs > li > a {
            border: none;
            background-color: transparent;
            font-weight: 600;
            padding: 15px 25px;
            text-transform: uppercase;
            font-size: 16px;
            border-radius: 30px 30px 0 0;
            transition: all 0.3s ease-in-out;
        }
        .nav-tabs > li > a:hover {
            background-color: #007BFF;
            color: white;
            box-shadow: 0 4px 10px rgba(0, 123, 255, 0.3);
        }
        .nav-tabs > .active > a {
            background-color: #007BFF;
            color: white;
            box-shadow: 0 4px 10px rgba(0, 123, 255, 0.5);
        }
        .tab-content {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 0 0 30px 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 20px; 
        }
        .tab-pane h3 {
            color: #007BFF;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 20px;
        }
        .tab-pane p {
            font-size: 16px;
            line-height: 1.8;
            color: #666;
        }
        .tab-pane ul {
            margin-left: 20px;
            padding-left: 20px;
            list-style-type: none;
        }
        .tab-pane ul li {
            margin-bottom: 15px;
            font-size: 16px;
            line-height: 1.6;
        }
        .tab-pane ul li:before {
            content: "\2022"; 
            color: #007BFF;
            margin-right: 10px;
        }
        .tab-pane a {
            color: #007BFF;
            text-decoration: none;
            font-weight: 600;
        }
        .tab-pane a:hover {
            text-decoration: underline;
        }



        .custom-container {
            max-width: 700px;
            margin: 50px auto;
            padding: 30px;
            border-radius: 15px;
            background-color: #ffffff;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            position: relative;
            overflow: hidden;
        }
        .custom-container:hover {
            transform: scale(1.05);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.4);
        }
        .custom-title {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
            font-weight: bold;
            font-size: 26px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .custom-input, .custom-textarea {
            width: 100%;
            border-radius: 8px;
            border: 1px solid #ccc;
            padding: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #f9f9f9;
            outline: none;
        }
        .custom-input:focus, .custom-textarea:focus {
            border-color: #ff416c;
            box-shadow: 0 0 10px rgba(255, 65, 108, 0.6);
            background: #fff;
        }
        .custom-label {
            font-weight: bold;
            color: #444;
            display: block;
            margin-bottom: 8px;
        }
        .custom-btn {
            width: 100%;
            background: linear-gradient(to right, #ff416c, #ff4b2b);
            color: white;
            padding: 12px;
            font-size: 18px;
            border-radius: 8px;
            border: none;
            transition: all 0.3s;
            font-weight: bold;
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }
        .custom-group {
            margin-bottom: 20px;
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
        <small>Add/Update Records</small>
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

                            <div class="col-md-6 text-center" style="margin-top: 10px; " >
                                <div class="input-group input-group-lg">
                                    <select class="form-control form-control-lg selects_person_info select2 " >
                                        <option value="">Select</option>
                                    </select>
                                    <span  data-toggle="modal" data-target="#modal_payments_adding" class="input-group-addon" id="sizing-addon1" style="cursor: pointer; " >
                                        <i class="fa fa-user-plus"></i>
                                    </span>
                                </div>
                            </div>
                            


    <div class="container profile-container profile_infos_display"> </div>

    <div class="container set_details_tab_info "> </div>

                    <!-- 
                    <div class="row" style="margin-top: 5px;">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="panel panel-default">
                                <div class="panel-heading">আমানতের বিবরণ</div>
                                <div class="panel-body">
                                    <p><strong>সদস্য হয়েছেন:</strong> জানুয়ারি ২০২০</p>
                                    <p><strong>অর্ডারের সংখ্যা:</strong> ২৫</p>
                                    <p><strong>সর্বশেষ অর্ডার:</strong> ১০ মার্চ, ২০২৫</p>
                                    <p><strong>পছন্দের পেমেন্ট পদ্ধতি:</strong> ক্রেডিট কার্ড</p>
                                    <p><strong>বকেয়া:</strong> $১৫০</p>
                                </div>
                            </div>
                        </div>
                    </div>
                     -->


                        </div>
                    </div>
                    <!-- /.box-footer -->
                </div>
                <!-- /.box -->

                <!-- 
                <div  class="ui-widget-content">
                  <div id="accordion">
                    <h3 style="font-size: 25px; ">আমানতের টাকা গ্রহন </h3>
                    <div>

                      <div class="col-md-6 " style="margin-top: 10px; " >
                          <div class="input-group input-group-lg">
                              <span class="input-group-addon" >সময়</span>
                              <input type="text" class="form-control taking_timess " placeholder="টাইম" value="<?php echo date('h:m a') ; ?>" >
                          </div>
                      </div>

                      <div class="col-md-6 " style="margin-top: 10px; " >
                          <div class="input-group input-group-lg">
                              <span class="input-group-addon" >মারফত</span>
                              <input type="text" class="form-control taking_amount_marfots " placeholder="আমানতের মারফত" >
                          </div>
                      </div>

                      <div class="col-md-6 " style="margin-top: 10px; " >
                          <div class="input-group input-group-lg">
                              <span class="input-group-addon" >টাকার পরিমাণ</span>
                              <input type="text" class="form-control taking_amount_tk " inputmode="numeric" placeholder="টাকার পরিমাণ" >
                          </div>
                      </div>

                      <center>
                        <div class="col-md-12 col-sm-12 col-xs-12 " style="margin-top: 10px; " >
                            <div class="input-group input-group-lg">
                                <div class="btn btn-lg btn-primary taking_amnt_btn " style=" font-size: 30px; ">ক্যাশে যোগ করুন</div>
                            </div>
                        </div>
                      </center>

                    </div>
                    <h3 style="font-size: 25px; ">আমানতের টাকা প্রদান </h3>
                    <div>

                      <div class="col-md-6 " style="margin-top: 10px; " >
                          <div class="input-group input-group-lg">
                              <span class="input-group-addon" >সময়</span>
                              <input type="text" class="form-control cutting_timess " placeholder="টাইম" value="<?php echo date('h:m a') ; ?>"  >
                          </div>
                      </div>

                      <div class="col-md-6 " style="margin-top: 10px; " >
                          <div class="input-group input-group-lg">
                              <span class="input-group-addon" >মারফত</span>
                              <input type="text" class="form-control give_amount_marfot_cut " placeholder="আমানতের মারফত" >
                          </div>
                      </div>

                      <div class="col-md-6 " style="margin-top: 10px; " >
                          <div class="input-group input-group-lg">
                              <span class="input-group-addon" >টাকার পরিমাণ</span>
                              <input type="text" class="form-control amount_of_cutting " inputmode="numeric" placeholder="টাকার পরিমাণ" >
                          </div>
                      </div>

                      <center>
                        <div class="col-md-12 col-sm-12 col-xs-12 " style="margin-top: 10px; " >
                            <div class="input-group input-group-lg">
                                <div class="btn btn-lg btn-info give_amanot_amount_cutting " style=" font-size: 30px; ">ক্যাশ থেকে প্রদান</div>
                            </div>
                        </div>
                      </center>

                    </div>
                    <h3 style="font-size: 25px; ">আমানতের বিস্তারিত লিস্ট</h3>
                    <div>

                      <div class="col-md-6 " style="margin-top: 10px; " >
                          <div class="input-group input-group-lg">
                              <span class="input-group-addon" >শুরুর তারিখ</span>
                              <input type="text" class="form-control datepicker date_starts " placeholder="শুরুর তারিখ" value="<?php echo date('d-m-Y');?>" >
                          </div>
                      </div>

                      <div class="col-md-6 " style="margin-top: 10px; " >
                          <div class="input-group input-group-lg">
                              <span class="input-group-addon" >শেষ তারিখ</span>
                              <input type="text" class="form-control datepicker ending_datess " placeholder=" শেষ তারিখ পর্যন্ত " value="<?php echo date('d-m-Y');?>" >
                          </div>
                      </div>

                      <center>
                        <div class="col-md-12 col-sm-12 col-xs-12 " style="margin-top: 10px; " >
                            <div class="input-group input-group-lg">
                                <div class="btn btn-default data_searching_btn " style=" font-size: 30px; border: 2px solid black; ">বিস্তারিত দেখুন</div>
                            </div>
                        </div>
                      </center>

                      <div class="col-md-6 col-sm-12 col-xs-12 " style="margin: 20px 0 20px 0; " >
                        <table class="table table-bordered table-responsive table-striped"  style="border: 2px solid black;  " >
                          <thead>
                            <tr><th align="center" colspan="5">ক্যাশে জমার লিস্ট</th></tr>
                            <tr>
                              <th>#</th>
                              <th>তারিখ</th>
                              <th>সময়</th>
                              <th>মারফত</th>
                              <th>টাকার পরিমাণ</th>
                              <th>এ্যকশন</th>
                            </tr>
                          </thead>
                          <tbody class="adding_data"></tbody>
                        </table>
                      </div>
                      <div class="col-md-6 col-sm-12 col-xs-12 " style="margin: 20px 0 20px 0; " >
                        <table class="table table-bordered table-responsive table-striped"  style="border: 2px solid black;  " >
                          <thead>
                            <tr><th align="center" colspan="5">ক্যাশ থেকে তাকে প্রদানের লিস্ট</th></tr>
                            <tr>
                              <th>#</th>
                              <th>তারিখ</th>
                              <th>সময়</th>
                              <th>মারফত</th>
                              <th>টাকার পরিমাণ</th>
                              <th>এ্যকশন</th>
                            </tr>
                          </thead>
                          <tbody class="cutting_data"></tbody>
                        </table>
                      </div>

                    </div>
                  </div>
                </div>  -->


            </div>
            <!--/.col (right) -->
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
