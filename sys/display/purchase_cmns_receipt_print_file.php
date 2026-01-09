<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>বিল রিপোর্ট</title>
    <style>
        body {
            font-family: 'SolaimanLipi', sans-serif;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        .invoice-container {
            width: 58mm;
            padding: 10px;
            background: #fff;
            font-size: 14px;
            border: 1px solid #000;
            border-radius: 5px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        }
        .header {
            font-size: 16px;
            font-weight: bold;
            text-decoration: underline;
        }
        .info {
            font-size: 12px;
            margin: 5px 0;
        }
        .customer-info {
            text-align: right;
        }
        .separator {
            border-top: 1px dashed black;
            margin: 5px 0;
        }
        .total-box {
            font-size: 14px;
            font-weight: bold;
            margin-top: 5px;
            background: #f8f8f8;
            padding: 5px;
            border-radius: 3px;
        }
        .net-income {
            font-size: 16px;
            font-weight: bold;
            color: #2ecc71;
            margin-top: 5px;
            background: #ecf9ec;
            padding: 5px;
            border-radius: 3px;
        }
        .due-amount {
            font-size: 20px;
            font-weight: bold;
            color: #e74c3c;
            margin-top: 5px;
            background: #fdecea;
            padding: 5px;
            border-radius: 3px;
        }

        @media print {
            .invoice-container {
                margin-bottom: 30mm; /* খালি অংশ */
            }
        }

    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="header"><?= $company_info->company_name;?></div>
        <div class="info"><?= $company_info->address;?></div>
        <div class="info">মোবাইল: <?= BanglaConverter::en2bn($company_info->mobile);?></div>
        <div class="separator"></div>
        <div class="info">
            <b>ক্রয়ের তারিখঃ <?= BanglaConverter::en2bn(date('d-m-Y', strtotime($cmns_info->pur_date_timsssss)));?></b>
            <br>
            তারিখঃ <?= BanglaConverter::en2bn(date('d-m-Y', strtotime($cmns_info->date_of_commission_save)));?>
        </div>
        <div class="customer-info">
            <div class="info"><strong>মহাজন:</strong> <?= $cmns_info->supplier_name;?></div>
            <div class="info"> <?= $cmns_info->address;?></div>
            <div class="info">মোবাইল: <?= BanglaConverter::en2bn($cmns_info->mobile);?></div>
        </div>
        <div class="separator"></div>

            <?php foreach ($cmns_sales_items_info as $item) { 
                $ttl_item_amount[]=$item->ttl_sales_amount_sssssss; ?>

                <div class="info" >
                    <span class="">
                        <?= BanglaConverter::en2bn(numfmt_format(numfmt_create('en_IN', NumberFormatter::DECIMAL), $item->ttl_salessss_bostaass)); ?>
                    </span>||
                    <span class="">
                        <?= BanglaConverter::en2bn(numfmt_format(numfmt_create('en_IN', NumberFormatter::DECIMAL), $item->ttl_weight_bostassssssss)); ?>
                    </span>× 
                    <span class="">
                        ৳<?= BanglaConverter::en2bn(numfmt_format(numfmt_create('en_IN', NumberFormatter::DECIMAL), $item->saling_pricesssssss)); ?>
                    </span> = 
                    <span class="">
                        মোট ৳ <?= BanglaConverter::en2bn(numfmt_format(numfmt_create('en_IN', NumberFormatter::DECIMAL), $item->ttl_sales_amount_sssssss)); ?> 
                    </span>
                </div>

            <?php } ?>




        <div class="separator"></div>
        <div class="info"><strong>মোট বিক্রয়:  <?= BanglaConverter::en2bn(numfmt_format(numfmt_create('en_IN', NumberFormatter::DECIMAL), array_sum($ttl_item_amount))); ?></strong></div>

        <div class="info"><strong>ট্রান্সপোর্ট ভাড়া:</strong> <?= BanglaConverter::en2bn(numfmt_format(numfmt_create('en_IN', NumberFormatter::DECIMAL), (float)$cmns_info->ttl_trans_vara_purchasesss_cost + (float)$cmns_info->transport_vara_ogrim_costs + (float)$cmns_info->trans_commission_purrr_cost)); ?> টাকা</div>

        <?php if (!empty($cmns_info->arot_comsn_profit_cost)) { ?>
            <div  class="info" >
                <strong>আড়ৎ কমিশন</strong> <?= BanglaConverter::en2bn(numfmt_format(numfmt_create('en_IN', NumberFormatter::DECIMAL), $cmns_info->arot_comsn_profit_cost)); ?> টাকা 
            </div>
        <?php } ?>
        
        <?php if (!empty($cmns_info->ghar_kuliss_ss_cost)) { ?>
            <div  class="info" >
                <strong>আমদানী </strong> <?= BanglaConverter::en2bn(numfmt_format(numfmt_create('en_IN', NumberFormatter::DECIMAL), $cmns_info->ghar_kuliss_ss_cost)); ?> টাকা 
            </div>
        <?php } ?>
        
        <?php if (!empty($cmns_info->tahurI_pur_s_cost)) { ?>
            <div  class="info" >
                <strong>তহুরী খরচ </strong> <?= BanglaConverter::en2bn(numfmt_format(numfmt_create('en_IN', NumberFormatter::DECIMAL), $cmns_info->tahurI_pur_s_cost)); ?> টাকা 
            </div>
        <?php } ?>
        
        <?php if (!empty($cmns_info->godhi_vara_com_costss)) { ?>
            <div  class="info" >
                <strong>গদী ভাড়া </strong> <?= BanglaConverter::en2bn(numfmt_format(numfmt_create('en_IN', NumberFormatter::DECIMAL), $cmns_info->godhi_vara_com_costss)); ?> টাকা 
            </div>
        <?php } ?>
        
        <?php if (!empty($cmns_info->khali_bosta_costssssss)) { ?>
            <div  class="info" >
                <strong>খালী বস্তা খরচ </strong> <?= BanglaConverter::en2bn(numfmt_format(numfmt_create('en_IN', NumberFormatter::DECIMAL), $cmns_info->khali_bosta_costssssss)); ?> টাকা 
            </div>
        <?php } ?>
        
        <?php if (!empty($cmns_info->other_coms_cost_ss)) { ?>
            <div  class="info" >
                <strong>অন্যান্য খরচ  </strong> <?= BanglaConverter::en2bn(numfmt_format(numfmt_create('en_IN', NumberFormatter::DECIMAL), $cmns_info->other_coms_cost_ss)); ?> টাকা 
            </div>
        <?php } ?>
        
        <?php if (!empty($cmns_info->ttl_cost_of_this_trans)) { ?>
            <div  class="info" >
                <strong>মোট খরচ   <?= BanglaConverter::en2bn(numfmt_format(numfmt_create('en_IN', NumberFormatter::DECIMAL), $cmns_info->ttl_cost_of_this_trans)); ?> টাকা </strong>
            </div>
        <?php } ?>

        <div class="separator"></div>
        <div class="net-income">নিট আয়: <?= BanglaConverter::en2bn(numfmt_format(numfmt_create('en_IN', NumberFormatter::DECIMAL), (float)$cmns_info->ttl_sales_amnt_takassss - (float)$cmns_info->ttl_cost_of_this_trans)); ?> টাকা</div>
        <div class="separator"></div>
        <div class="info"><strong>সাবেক বকেয়া:</strong> <?= BanglaConverter::en2bn(numfmt_format(numfmt_create('en_IN', NumberFormatter::DECIMAL), $cmns_info->supp_sabek_amntss)); ?> টাকা</div>
        <div class="due-amount">বকেয়া: <?= BanglaConverter::en2bn(numfmt_format(numfmt_create('en_IN', NumberFormatter::DECIMAL), $cmns_info->supp_ekhon_amnts_s)); ?> টাকা</div>
    </div>
</body>
</html>

