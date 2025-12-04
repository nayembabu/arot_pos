







<!DOCTYPE html>
<html lang="bn">
    <head>
        <meta charset="utf-8">
        <title>আলুর ব্যবসা – গাড়ি অনুযায়ী পূর্ণাঙ্গ লাভ-লস রিপোর্ট</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body { font-family: 'SolaimanLipi', 'Kalpurush', Arial, sans-serif; background: #f5f5f5; }
            .panel-primary > .panel-heading { background: #00695c; border-color: #00695c; }
            .table th { background: #e8f5e9; font-weight: bold; }
            .profit { color: #1b5e20; font-weight: bold; }
            .loss   { color: #b71c1c; font-weight: bold; }
            .total-row { background: #fff3e0 !important; font-size: 18px; }
            .clickable { cursor: pointer; color: #00695c; }
            .modal-header { background: #00695c; color: white; }
            @media print {
                .no-print, .glyphicon-eye-open { display: none !important; }
                body { background: white; }
                .panel { box-shadow: none; border: 1px solid #000; }
            }
        </style>
    </head>
    <body>

    <div class="container" style="margin-top:20px;">
        <div class="panel panel-primary">
            <div class="panel-heading text-center">
                <h3 style="margin:0; font-size:28px;">আলুর ব্যবসা – গাড়ি অনুযায়ী পূর্ণাঙ্গ হিসাব</h3>
                <p style="margin:5px 0 0;">রিপোর্টের সময়: ০১ ডিসেম্বর ২০২৫ – ৩১ ডিসেম্বর ২০২৫ | প্রিন্ট: <span id="today"></span></p>
            </div>

            <div class="panel-body">
                <div class="row no-print" style="margin-bottom:15px;">
                    <div class="col-xs-12">
                        <button onclick="window.print()" class="btn btn-success btn-lg">
                            প্রিন্ট / PDF করুন
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="mainTable">
                        <thead>
                            <tr class="success">
                                <th>ক্রম</th>
                                <th>গাড়ির নম্বর</th>
                                <th>সাপ্লাইয়ার</th>
                                <th>আলুর জাত</th>
                                <th>মোট বস্তা</th>
                                <th>মোট ওজন (কেজি)</th>
                                <th>ক্রয় মূল্য</th>
                                <th>গাড়ি ভাড়া</th>
                                <th>লেবার + অন্যান্য</th>
                                <th>মোট খরচ</th>
                                <th>বিক্রয় মূল্য</th>
                                <th>লাভ/লস</th>
                                <th class="no-print">বিস্তারিত</th>
                            </tr>
                        </thead>
                        <tbody>

                            <!-- গাড়ি ১ -->
                            <tr data-id="1">
                                <td class="text-center">১</td>
                                <td>ঢাকা মেট্রো-গ-১১-২৩৪৫</td>
                                <td>রহিম সাপ্লাইয়ার, বগুড়া</td>
                                <td>ডায়মন্ড</td>
                                <td class="text-center">১০০</td>
                                <td class="text-right">৫,০০০</td>
                                <td class="text-right">২,২৫,০০০</td>
                                <td class="text-right">২৫,০০০</td>
                                <td class="text-right">৮,০০০</td>
                                <td class="text-right">২,৫৮,০০০</td>
                                <td class="text-right">৩,১৫,০০০</td>
                                <td class="text-right profit">+৫৭,০০০</td>
                                <td class="text-center no-print"><span class="glyphicon glyphicon-eye-open clickable" onclick="showDetails(1)"></span></td>
                            </tr>

                            <!-- গাড়ি ২ -->
                            <tr data-id="2">
                                <td class="text-center">২</td>
                                <td>ঢাকা মেট্রো-গ-১৫-৬৭৮৯</td>
                                <td>কাশেম এগ্রো, রংপুর</td>
                                <td>কার্ডিনাল</td>
                                <td class="text-center">৮৫</td>
                                <td class="text-right">৪,২৫০</td>
                                <td class="text-right">১,৭৮,৫০০</td>
                                <td class="text-right">২২,০০০</td>
                                <td class="text-right">৭,৫০০</td>
                                <td class="text-right">২,০৮,০০০</td>
                                <td class="text-right">২,৩৫,০০০</td>
                                <td class="text-right profit">+২৭,০০০</td>
                                <td class="text-center no-print"><span class="glyphicon glyphicon-eye-open clickable" onclick="showDetails(2)"></span></td>
                            </tr>

                            <!-- গাড়ি ৩ (লোকসান) -->
                            <tr data-id="3">
                                <td class="text-center">৩</td>
                                <td>চট্টগ্রাম-হ-১২-৩৪৫৬</td>
                                <td>জাহাঙ্গীর ট্রেডার্স</td>
                                <td>এস্টেরিক্স</td>
                                <td class="text-center">৭০</td>
                                <td class="text-right">৩,৫০০</td>
                                <td class="text-right">১,৬৪,৫০০</td>
                                <td class="text-right">৩০,০০০</td>
                                <td class="text-right">১০,০০০</td>
                                <td class="text-right">২,০৪,৫০০</td>
                                <td class="text-right">১,৮৫,০০০</td>
                                <td class="text-right loss">-১৯,৫০০</td>
                                <td class="text-center no-print"><span class="glyphicon glyphicon-eye-open clickable" onclick="showDetails(3)"></span></td>
                            </tr>

                            <!-- সর্বমোট -->
                            <tr class="total-row">
                                <td colspan="4" class="text-center"><strong>মোট</strong></td>
                                <td class="text-center"><strong>২৫৫ বস্তা</strong></td>
                                <td class="text-right"><strong>১২,৭৫০ কেজি</strong></td>
                                <td class="text-right"><strong>৫,৬৮,০০০</strong></td>
                                <td class="text-right"><strong>৭৭,০০০</strong></td>
                                <td class="text-right"><strong>২৫,৫০০</strong></td>
                                <td class="text-right"><strong>৬,৭০,৫০০</strong></td>
                                <td class="text-right"><strong>৭,৩৫,০০০</strong></td>
                                <td class="text-right" style="font-size:20px; color:#1b5e20;"><strong>মোট লাভ ৬৪,৫০০ টাকা</strong></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- বিস্তারিত বিক্রয় মডাল -->
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="modalTitle">বিস্তারিত বিক্রয় হিসাব</h4>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="info">
                                <tr>
                                    <th>তারিখ</th>
                                    <th>ক্রেতার নাম</th>
                                    <th>বস্তা</th>
                                    <th>ওজন (কেজি)</th>
                                    <th>প্রতি কেজি দর</th>
                                    <th>মোট টাকা</th>
                                    <th>পে-মেন্ট</th>
                                    <th>বাকি</th>
                                </tr>
                            </thead>
                            <tbody id="detailBody"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script>
        // আজকের তারিখ
        document.getElementById('today').innerText = new Date().toLocaleDateString('bn-BD');

        // প্রতিটি গাড়ির বিস্তারিত বিক্রয় ডাটা (আপনি ডাটাবেস থেকে নিবেন)
        const allSales = {
            1: [
                {date:"০১-১২-২০২৫", buyer:"আব্দুল্লাহ মার্কেট", bag:40, kg:2000, rate:63, total:126000, paid:100000, due:26000},
                {date:"০২-১২-২০২৫", buyer:"রহিম ষ্টোর", bag:35, kg:1750, rate:64, total:112000, paid:112000, due:0},
                {date:"০৩-১২-২০২৫", buyer:"কাওসার ট্রেডার্স", bag:25, kg:1250, rate:62, total:77500, paid:60000, due:17500}
            ],
            2: [
                {date:"০২-১২-২০২৫", buyer:"মা বাবার দোয়া ষ্টোর", bag:50, kg:2500, rate:56, total:140000, paid:140000, due:0},
                {date:"০৩-১২-২০২৫", buyer:"জামালপুর হোলসেল", bag:35, kg:1750, rate:54, total:94500, paid:80000, due:14500}
            ],
            3: [
                {date:"০১-১২-২০২৫", buyer:"নিউ মার্কেট ব্যবসায়ী", bag:40, kg:2000, rate:50, total:100000, paid:85000, due:15000},
                {date:"০৩-১২-২০২৫", buyer:"সদর ঘাট হোলসেল", bag:30, kg:1500, rate:57, total:85500, paid:85500, due:0}
            ]
        };

        function showDetails(id) {
            const data = allSales[id];
            const row = document.querySelector(`tr[data-id="${id}"]`);
            const vehicle = row.cells[1].textContent;
            const variety = row.cells[3].textContent;

            document.getElementById('modalTitle').innerHTML = 
                `<strong>${vehicle}</strong> → ${variety} আলু → বিস্তারিত বিক্রয় হিসাব`;

            const tbody = document.getElementById('detailBody');
            tbody.innerHTML = '';

            data.forEach(s => {
                tbody.innerHTML += `
                    <tr>
                        <td>${s.date}</td>
                        <td>${s.buyer}</td>
                        <td class="text-center">${s.bag}</td>
                        <td class="text-right">${s.kg}</td>
                        <td class="text-right">${s.rate}</td>
                        <td class="text-right">${s.total.toLocaleString()}</td>
                        <td class="text-right">${s.paid.toLocaleString()}</td>
                        <td class="text-right" style="color:#d50000;">${s.due.toLocaleString()}</td>
                    </tr>`;
            });
            $('#detailModal').modal('show');
        }
    </script>
</body>
</html>






<!DOCTYPE html>
<html>
   <head>
      <base href="<?php echo $base_url; ?>">
      <!-- TABLES CSS CODE -->
      <?php include"comman/code_css_form.php"; ?>
      <style>
        .big,.highlight{font-weight:700}body{background:#f8f9fa;font-family:Kalpurush,SolaimanLipi,Arial,sans-serif}.big{font-size:34px;margin:10px 0}.due{color:#e67e22}.total{color:#3498db}.panel{box-shadow:0 4px 20px rgba(0,0,0,.1);border-radius:10px;margin-bottom:15px}canvas{max-height:320px}.chart-container{position:relative;height:320px}.container{padding-top:30px}.highlight{font-size:18px}.profit{color:green}.loss{color:red}@media print{.no-print{display:none}}.inline-form .form-control { height: 40px; } .input-group { display: flex; }.select2-container .select2-selection--single{height:40px!important;font-size:18px!important;padding:6px 12pximportant}.select2-container--default .select2-selection--single .select2-selection__rendered{line-height:28px!important;font-size:18px!important;color:#333}.select2-container--default .select2-selection--single .select2-selection__arrow{height:38px!important}.select2-results__option{font-size:17px!important;padding:8px 12px!important}
      </style>

<!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

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

        <div class="container">

            <section class="" >

                <div class="">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 ">

                            <div class="form-inline inline-form " role="form">

                                <div class="form-group form-group-lg col-md-4 col-4 ">
                                    <select class="form-control select2 supplier_selecting_id ">
                                        <option value="">মহাজন সিলেক্ট করুন </option>
                                        <?php foreach ($all_suppliers as $info) { ?>
                                            <option value="<?= $info->id; ?>"><?= $info->supplier_name; ?> --- <?= $info->address; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group form-group-lg col-md-4 col-4 ">
                                    <div class="input-group " >
                                        <input type="text" class="form-control get_type_start_date datepicker " placeholder="" readonly value="<?= date('d-m-Y'); ?>" />
                                        <span class="input-group-addon" style="border-radius: 0;">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group form-group-lg col-md-4 col-4 ">
                                    <div class="input-group " >
                                        <input type="text" class="form-control get_type_end_date datepicker " placeholder="" readonly value="<?= date('d-m-Y'); ?>" />
                                        <span class="input-group-addon" style="border-radius: 0;">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group form-group-lg col-md-4 col-4 ">
                                    <div class="btn btn-lg btn-primary search_btn_s">
                                        <span class="glyphicon glyphicon-search"></span> খুঁজুন
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </section>

            <div class="row assign_supplier_reports" style="margin-top: 20px;"></div>

        </div>

    </div>
    <!-- /.content -->




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
<script src="<?php echo $theme_link; ?>js/incomes.js"></script>
<script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>

<script>
    $(document).on('click', '.search_btn_s', function () {

        let type_date_start = $('.get_type_start_date').val();
        let type_date_end = $('.get_type_end_date').val();

        let sup_id = $('.supplier_selecting_id option:selected').val();
        if (sup_id == '' || type_date_start == '' || type_date_end == '') {
            toastr["warning"]("সাপ্লাইয়ার এবং তারিখ সিলেক্ট করুন। ");
        }else {
            $.ajax({
                type: "post",
                url: "suppliers/get_data_date_to_date_report",
                data: {
                    supp_id: sup_id,
                    type_date_start: type_date_start,
                    type_date_end: type_date_end
                },
                dataType: "json",
                success: function (res) {
                    $('.assign_supplier_reports').html(res.data);
                }
            });
        }
    });
</script>




</body>
</html>

