<?php $lot_color = ['lot-red', 'lot-green']; 
//  'lot-purple', 'lot-orange', 'lot-teal', 'lot-blue'
?>

<?php 
   
   // echo "<pre>";
   // print_r ($items);
   // print_r ($pur_items);
   // echo "</pre>";
   
?>
<!DOCTYPE html>
<html>
<head>
    <base href="<?php echo $base_url; ?>">
    <?php include"comman/code_css_form.php"; ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #e0f7fa, #fce4ec);
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 15px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .product-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
            backdrop-filter: blur(8px);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.18);
        }

        .product-header {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 20px;
        }

        .product-img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #fff;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            flex-shrink: 0;
        }

        .product-info-block {
            flex: 1;
            min-width: 200px;
        }

        .product-title {
            font-size: 22px;
            font-weight: bold;
            margin: 0 0 6px 0;
            color: #2c3e50;
        }

        .product-info {
            font-size: 15px;
            color: #555;
            margin: 0;
            font-weight: 500;
        }

        /* Lot Row - Fully Responsive Grid */
        .lot-row {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 12px;
            margin-top: 10px;
        }

        .lot-card {
            padding: 14px 10px;
            border-radius: 14px;
            color: white;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
            min-height: 90px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .lot-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
        }

        .lot-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .lot-detail {
            font-size: 13px;
            line-height: 1.4;
            opacity: 0.95;
        }

        /* Gradient Classes */
        .lot-red    { background: linear-gradient(135deg, #ff6a00, #ee0979); }
        .lot-blue   { background: linear-gradient(135deg, #00c6ff, #0072ff); }
        .lot-green  { background: linear-gradient(135deg, #00b09b, #96c93d); }
        .lot-purple { background: linear-gradient(135deg, #7f00ff, #e100ff); }
        .lot-orange { background: linear-gradient(135deg, #f7971e, #ffd200); }
        .lot-teal   { background: linear-gradient(135deg, #43cea2, #185a9d); }
        .lot-pink   { background: linear-gradient(135deg, #ff5858, #f857a6); }
        .lot-cyan   { background: linear-gradient(135deg, #00d2ff, #3a7bd5); }

        /* Responsive Adjustments */
        @media (max-width: 991px) {
            .lot-row {
                grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .product-header {
                flex-direction: column;
                text-align: center;
            }
            .product-img {
                width: 80px;
                height: 80px;
            }
            .product-title {
                font-size: 20px;
            }
        }

        @media (max-width: 576px) {
            .container {
                padding: 10px;
            }
            .product-card {
                padding: 16px;
            }
            .lot-row {
                grid-template-columns: repeat(2, 1fr);
            }
            .lot-card {
                padding: 12px 8px;
                min-height: 80px;
            }
            .lot-title {
                font-size: 15px;
            }
            .lot-detail {
                font-size: 12px;
            }
        }

        @media (max-width: 400px) {
            .lot-row {
                grid-template-columns: 1fr 1fr;
            }
            .product-title {
                font-size: 19px;
            }
        }
    </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php include"sidebar.php"; ?>

        <div class="content-wrapper">
            <section class="content-header">
                <h1><?=$page_title;?><small></small></h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active"><?=$page_title;?></li>
                </ol>
            </section>

            <!-- Main Responsive Container -->
            <div class="container">
                <?php 
                $lot_color = ['lot-red','lot-blue','lot-green','lot-purple','lot-orange','lot-teal','lot-pink','lot-cyan'];
                $total_bags = 0;
                foreach ($items as $item):
                    $lots = array_filter($pur_items, fn($lot) => $lot->item_id == $item->id);
                    $total_bags = array_sum(array_column($lots, 'due_sells_bosta_ss'));
                ?>
                    <div class="product-card">
                        <div class="product-header">
                            <img src="<?= 'uploads/items/'.$item->item_image; ?>" 
                                alt="<?= $item->item_name; ?>" 
                                class="product-img"
                                onerror="this.src='uploads/items/no_image.png'">
                            <div class="product-info-block">
                                <p class="product-title"><?= htmlspecialchars($item->item_name); ?></p>
                                <p class="product-info">
                                    <strong><?= $total_bags ?></strong> <?= $item->unit_name ?> 
                                    | মোট <strong><?= count($lots) ?></strong> টি লট
                                </p>
                            </div>
                        </div>

                        <div class="lot-row">
                            <?php foreach ($pur_items as $lot): 
                                if ($item->id == $lot->item_id): ?>
                                    <div class="lot-card <?= $lot_color[array_rand($lot_color)]; ?>">
                                        <div class="lot-title"><?= htmlspecialchars($lot->ref_lot_no); ?></div>
                                        <div class="lot-detail">
                                            <?= $lot->due_sells_bosta_ss ?> <?= $lot->unit_name ?><br>
                                            <?= htmlspecialchars($lot->supplier_name); ?>
                                        </div>
                                    </div>
                                <?php endif; 
                            endforeach; ?>
                        </div>
                    </div>
                <?php 
                $total_bags = 0; endforeach; ?>
            </div>
        </div>
    



    


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



</body>
</html>



