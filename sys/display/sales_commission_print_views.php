<!DOCTYPE html>
<html lang="en">
    <head>
        <base href="<?php echo base_url(); ?>" target="">
        <style>
            .solaimanlipi_font {
                font-family: SolaimanLipi;
            }
        </style>
                 
        <script type="text/javascript"> 
            document.open();
            document.write();
            window.focus();
            window.print();
        </script> 

    </head>
    <body style="margin: 0; padding: 0; ">

        <center>
            <div class="" style="">
                <p class="solaimanlipi_font" style="font-size: 18px; font-weight: bold; "><?= $company_info->company_name;?></p>
                <p class="solaimanlipi_font" style="margin-top: -20px;" ><?= $company_info->address;?></p>
                <p class="solaimanlipi_font" style="margin-top: -15px;" ><?= BanglaConverter::en2bn($company_info->mobile);?></p>
            </div>
            <div>
                <div class="solaimanlipi_font">তারিখঃ <?= BanglaConverter::en2bn(date('d-m-Y', strtotime($sale_com_info->cr_dating_setsss)));?></div>
            </div>
            <div class="" style="display: table; text-align: end; margin-left: 80px;   "> 
                <p class="solaimanlipi_font" style=""><?= $sale_com_info->customer_name;?></p> 
                <p class="solaimanlipi_font" style="margin-top: -20px;" ><?= $sale_com_info->address;?></p> 
                <p class="solaimanlipi_font" style="margin-top: -15px;" ><?= BanglaConverter::en2bn($sale_com_info->mobile);?></p> 
            </div>

            <p class="solaimanlipi_font" style="font-size: 18px; font-weight: bold; " >কমিশন হিসাব</p>
            <table border="3" cellspacing="0">
                <tr>
                    <td class="solaimanlipi_font">পন্যের বিবরন</td>
                    <td class="solaimanlipi_font" align="center">পরিমাণ</td>
                    <td class="solaimanlipi_font" align="right">টাকা</td>
                </tr>
                <?php 
                    $ttl_item_amount=[]; 
                    $sales_comsn_cost = 0;
                    $sales_tohuri_cost = 0;
                    $godi_cost_ssss = 0;
                    $ghar_kuli_cost_saaas = 0;
                    $khali_bosta_cost_setssss = 0;
                    $bacani_costssss_setss = 0;
                    $others_costa_setsssss = 0;

                    foreach ($sales_com_item_info as $item) {
                    $ttl_item_amount[]=$item->ttl_sales_sss_amounts_sss; ?>
                    <tr>
                        <td class="solaimanlipi_font" align="center">
                            <?= $item->ref_lot_no; ?><br>
                            <span style="font-size: 12px;">
                                (মোট <?= BanglaConverter::en2bn(round((float)$item->ttl_sales_weight_kgs_aaa, 2)); ?>কেজি)<br>
                                (রেট <?= BanglaConverter::en2bn(round((float)$item->saling_prices_sssss_per_kgsss, 2)); ?>/-)
                            </span>
                        </td>
                        <td class="solaimanlipi_font" align="center"><?= BanglaConverter::en2bn($item->ttl_sales_bosta_asaaaa); ?> <?= $item->unit_name; ?></td>
                        <td class="solaimanlipi_font" align="right"><?= BanglaConverter::en2bn(round($item->ttl_sales_sss_amounts_sss, 2)); ?>/-</td>
                    </tr>
                <?php } ?> 
                <tr>
                    <td class="solaimanlipi_font" align="right" colspan="3"><?= BanglaConverter::en2bn($in_ttl_sales_amnt = round((float)array_sum($ttl_item_amount)), 2); ?>/-</td>
                </tr>
                <tr>
                    <td class="solaimanlipi_font" align="center" colspan="2">সাবেক</td>
                    <td class="solaimanlipi_font" align="right" style="font-weight: bold;" ><?= BanglaConverter::en2bn((float)$sale_com_info->cust_previous_amount_addss); ?>/-</td>
                </tr>
                <tr>
                    <td class="solaimanlipi_font" align="right" colspan="2" style="font-size: 18px; " >সাবেক মোট</td>
                    <td class="solaimanlipi_font" align="right" style="font-weight: bold; font-size: 18px; " ><?= BanglaConverter::en2bn((float)array_sum($ttl_item_amount) + (float)$sale_com_info->cust_previous_amount_addss); ?>/-</td>
                </tr>

                <?php 
                    if (!empty($sale_com_info->sales_comsn_cost_amountssss)) { 
                        $sales_comsn_cost = $sale_com_info->sales_comsn_cost_amountssss;
                ?>
                    <tr>
                        <td class="solaimanlipi_font" align="center" colspan="2">কমিশন খরচ</td>
                        <td class="solaimanlipi_font" align="right" ><?= BanglaConverter::en2bn($sale_com_info->sales_comsn_cost_amountssss); ?>/-</td>
                    </tr>
                <?php } ?>
                <?php 
                    if (!empty($sale_com_info->sales_tohurI_cost_amntsss)) { 
                        $sales_tohuri_cost = $sale_com_info->sales_tohurI_cost_amntsss; 
                ?>
                    <tr>
                        <td class="solaimanlipi_font" align="center" colspan="2">তহুরী খরচ</td>
                        <td class="solaimanlipi_font" align="right" ><?= BanglaConverter::en2bn($sale_com_info->sales_tohurI_cost_amntsss); ?>/-</td>
                    </tr>
                <?php } ?>
                <?php 
                    if (!empty($sale_com_info->godi_cost_ssss)) { 
                    $godi_cost_ssss = $sale_com_info->godi_cost_ssss;
                ?>
                    <tr>
                        <td class="solaimanlipi_font" align="center" colspan="2">গদী খরচ</td>
                        <td class="solaimanlipi_font" align="right" ><?= BanglaConverter::en2bn($sale_com_info->godi_cost_ssss); ?>/-</td>
                    </tr>
                <?php } ?>
                <?php 
                    if (!empty($sale_com_info->ghar_kuli_cost_saaas)) { 
                    $ghar_kuli_cost_saaas = $sale_com_info->ghar_kuli_cost_saaas; 
                ?>
                    <tr>
                        <td class="solaimanlipi_font" align="center" colspan="2">ঘরকুলী খরচ</td>
                        <td class="solaimanlipi_font" align="right" ><?= BanglaConverter::en2bn($sale_com_info->ghar_kuli_cost_saaas); ?>/-</td>
                    </tr>
                <?php } ?>
                <?php  
                    if (!empty($sale_com_info->khali_bosta_cost_setssss)) { 
                    $khali_bosta_cost_setssss = $sale_com_info->khali_bosta_cost_setssss;
                ?>
                    <tr>
                        <td class="solaimanlipi_font" align="center" colspan="2">খালী-বস্তা খরচ</td>
                        <td class="solaimanlipi_font" align="right" ><?= BanglaConverter::en2bn($sale_com_info->khali_bosta_cost_setssss); ?>/-</td>
                    </tr>
                <?php } ?>
                <?php 
                    if (!empty($sale_com_info->bacani_costssss_setss)) { 
                    $bacani_costssss_setss = $sale_com_info->bacani_costssss_setss;
                ?>
                    <tr>
                        <td class="solaimanlipi_font" align="center" colspan="2">বাছানী খরচ</td>
                        <td class="solaimanlipi_font" align="right" ><?= BanglaConverter::en2bn($sale_com_info->bacani_costssss_setss); ?>/-</td>
                    </tr>
                <?php } ?>
                <?php 
                    if (!empty($sale_com_info->others_costa_setsssss)) { 
                    $others_costa_setsssss = $sale_com_info->others_costa_setsssss;
                ?>
                    <tr>
                        <td class="solaimanlipi_font" align="center" colspan="2">অন্যান্য খরচ</td>
                        <td class="solaimanlipi_font" align="right" ><?= BanglaConverter::en2bn($sale_com_info->others_costa_setsssss); ?>/-</td>
                    </tr>
                <?php } ?>

                <tr>
                    <td class="solaimanlipi_font" align="right" colspan="2">মোট খরচ</td>
                    <td class="solaimanlipi_font" align="right" style="font-weight: bold;" ><?= BanglaConverter::en2bn((float)$sales_comsn_cost + (float)$sales_tohuri_cost + (float)$godi_cost_ssss + (float)$ghar_kuli_cost_saaas + (float)$khali_bosta_cost_setssss + (float)$bacani_costssss_setss + (float)$others_costa_setsssss ); ?>/-</td>
                </tr>
                <tr>
                    <td class="solaimanlipi_font" style="font-weight: bold; font-size: 20px;" align="right" colspan="2">মোট বকেয়া</td>
                    <td class="solaimanlipi_font" align="right" style="font-weight: bold; font-size: 20px;" ><?= BanglaConverter::en2bn(round((float)$sale_com_info->cust_now_amount_after_commission_entryss), 2); ?>/-</td>
                </tr>

            </table>
            <p class="solaimanlipi_font" style="font-size: 30px; font-weight: bold; margin-top: 5px; " > <?= BanglaConverter::en2bn(round((float)$sale_com_info->cust_now_amount_after_commission_entryss), 2); ?>/-</p>
            <br>
            
            <div class="solaimanlipi_font" style="margin: 5px 0 5px 0; font-size: 12px;"> বিক্রিত মাল ফেরত যোগ্য নয়। </div>
            <br><br>
            <hr><hr><hr>
            <br><br>
        </center>
    </body>
</html>