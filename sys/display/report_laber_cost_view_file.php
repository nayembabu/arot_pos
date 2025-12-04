<?php
    $pur_lebar_array = [];
    $sale_lebar_arr = [];
?>


<html>
<head>
   <base href="<?php echo base_url(); ?>" target="">
   <!-- TABLES CSS CODE -->
   <?php include"comman/code_css_form.php"; ?>
   <!-- </copy> -->  
   <style>
        body {
            background-color: #f9f9f9;
        }
        .report-heading {
            background-color: #007bff;
            color: white;
            padding: 15px 20px;
            border-radius: 5px;
            margin-top: 10px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .search-box {
            margin-top: 10px;
            background-color: #ffffff;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }        
        .total-box {
            margin-top: 10px;
            background-color: #28a745;
            color: white;
            text-align: center;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            font-size: 36px;
            font-weight: bold;
        }
    </style>
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
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active"><?=$page_title;?></li>
      </ol>
    </section>
    <br>
    <div class="center container"> 

    <div class="container">
        <!-- Report Heading -->
        <div class="report-heading">
            <h2 class="report_head_text " >আজকের লেবার খরচ</h2>
        </div>
        
        <!-- Search Box -->
        <div class="search-box text-center">
            <form class="form-inline">
                <div class="form-group">
                    <label for="date" class="control-label">তারিখ নির্বাচন করুন:</label>
                    <input type="text" style="text-align: center;" class="form-control datepicker searching_date_picks " value="<?= date('d-m-Y');?>" id="date" placeholder="তারিখ নির্বাচন করুন">
                </div>
                <button class="btn btn-primary submit_btn_laber_cost">
                    <i class="glyphicon glyphicon-search"></i> সার্চ
                </button>
            </form>
        </div>
        
        <!-- Total Box -->
        <div class="total-box">
            মোট: <span id="totalAmount">
                     <?php
                        foreach ($purchase_date_date as $pur_sng) { 
                            $pur_lebar_array[] = $pur_sng->ghar_kuli_cost_amnt_for_trans_with_cut;
                        }
                        foreach ($sales_date_date as $sale_sng) {
                            $sale_lebar_arr[] = $sale_sng->sales_lebar_cost_sss;
                        }
                        echo BanglaConverter::en2bn(numfmt_format_currency(numfmt_create( 'en_IN', NumberFormatter::CURRENCY ), array_sum($pur_lebar_array) + array_sum($sale_lebar_arr), "")); 
                    ?>
                  </span>
        </div>
    </div>




    <section class="content">
      <div class="row" >

         <div class="col-md-12">
            <div class="box box-primary">
               <div class="box-body table-responsive no-padding">
                  <div class="form-group col-md-4">
                     <label for="to_date">শুরু তারিখ</label>                  
                     <div class="col-sm-12">
                        <div class="input-group date">
                           <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                           </div>
                           <input type="text" class="form-control pull-right datepicker star_date_select "  id="pur_date" name="pur_date" readonly onkeyup="shift_cursor(event,'purchase_status')" value="<?= date('d-m-Y');?>">
                        </div>
                        <span id="pur_date_msg" style="display:none" class="text-danger"></span>
                     </div>
                  </div>
                  <div class="form-group col-md-4">
                     <label for="to_date">শেষ তারিখ</label>                  
                     <div class="col-sm-12">
                        <div class="input-group date">
                           <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                           </div>
                           <input type="text" class="form-control pull-right datepicker  end_select_date "  id="pur_date" name="pur_date" readonly onkeyup="shift_cursor(event,'purchase_status')" value="<?= date('d-m-Y');?>">
                        </div>
                        <span id="pur_date_msg" style="display:none" class="text-danger"></span>
                     </div>
                  </div>
                  <div class="form-group col-md-4">
                     <label for="to_date">সার্চ করুন</label>                  
                     <div class="col-sm-12">
                        <div class="input-group ">
                           <div class="btn btn-success income_expense_report_btns ">সার্চ করুন</div>
                        </div>
                        <span id="pur_date_msg" style="display:none" class="text-danger"></span>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         


         <div class="assign_ie_data">
            
         </div>
        
      </div>
      
    </section>
  
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
<!-- TABLE EXPORT CODE -->
<?php include"comman/code_js_export.php"; ?>

<script>

   $(document).on('click', '.submit_btn_cash_in_h', function () {
      let asd = $('.searching_date_picks').val();

      if ($('.searching_date_picks').val() == '') {
         
      }else {
         $.ajax({
            type: "post",
            url: "reports/get_cash_by_selected_dates",
            data: {
               dating: $('.searching_date_picks').val()
            },
            success: function (rnn) {
               
            }
         });
      }

   });

   $(document).on('click', '.income_expense_report_btns', function () {

      $.ajax({
         type: "post",
         url: "reports/get_income_expense_dat_to_date",
         data: {
            startDate:  $('.star_date_select').val(),
            endDate:    $('.end_select_date').val(),
         },
         success: function (r) {
            // Sum the price property of each object using reduce()
         let getpayTotalPayment = r.getpay.reduce((accumulator, current) => accumulator + parseFloat(current.payment), 0);
         let incomeTotal = r.income.reduce((accumulator, current) => accumulator + parseFloat(current.income_amount), 0);
         let expenseTotal = r.expense.reduce((accumulator, current) => accumulator + parseFloat(current.expense_amt), 0);
         let costpayTotalPay = r.costpay.reduce((accumulator, current) => accumulator + parseFloat(current.payment), 0);
            
            let income_list_data = '';
            let expense_list_datas = '';

            for (let n = 0; n < r.income.length; n++) { 
               income_list_data += 
                                 `<tr>
                                    <td>${r.income[n].income_for}</td>
                                    <td class="text-right text-bold ">${r.income[n].income_amount}</td>
                                 </tr>`;
            }

            for (let n = 0; n < r.expense.length; n++) { 
               expense_list_datas += 
                                 `<tr>
                                    <td>${r.expense[n].expense_for}</td>
                                    <td class="text-right text-bold ">${r.expense[n].expense_amt}</td>
                                 </tr>`;
            }


            $('.assign_ie_data').html(
                     `<div class="col-md-6">
                        <div class="box box-primary">
                           <div class="box-header" style="font-size: 22px;">
                              <center><b>জমার হিসাব</b></center>
                           </div>
                           <!-- /.box-header -->
                           <div class="box-body table-responsive no-padding">
                              <table class="table table-bordered table-hover " id="report-data" >

                                 <tr>
                                    <th>মোট ইনকাম</th>
                                    <th class="text-right text-bold ">${incomeTotal}</th>
                                 </tr>

                              </table>
                              <div style="font-size: 16px; margin: 5px; "><center><b>বিস্তারিত</b></center></div>
                              <table class="table table-bordered table-hover " id="report-data" style="" >
                                 ${income_list_data}
                              </table>
                           </div>
                           <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                     </div>
                     <div class="col-md-6">
                        <div class="box box-primary">
                           <div class="box-header" style="font-size: 22px;">
                              <center><b>খরচের হিসাব</b></center>
                           </div>
                           <!-- /.box-header -->
                           <div class="box-body table-responsive no-padding">
                              <table class="table table-bordered table-hover " id="report-data-4" >

                                 <tr>
                                    <th>মোট খরচ</th>
                                    <th class="text-right text-bold ">${expenseTotal}</th>
                                 </tr>

                              </table>
                              
                              <div style="font-size: 16px; margin: 5px; "><center><b>বিস্তারিত</b></center></div>
                              <table class="table table-bordered table-hover " id="report-data" style="" >
                                 ${expense_list_datas}
                              </table>

                           </div>
                           <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                     </div>`
                  );
         }
      });

   });


   console.log((123456.789.toLocaleString('en-IN')));


</script>


<!-- Make sidebar menu hughlighter/selector -->
<script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
    
    
</body>
</html>
