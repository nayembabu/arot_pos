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

        <!-- <p style="margin-top: -20px;" ><?= $company_info->email;?></p> -->

        <center>
            <div class="" style="">
                <p class="solaimanlipi_font" style="font-size: 18px; font-weight: bold; "><?= $company_info->company_name;?></p>
                <p class="solaimanlipi_font" style="margin-top: -20px;" ><?= $company_info->address;?></p>
                <p class="solaimanlipi_font" style="margin-top: -15px;" ><?= BanglaConverter::en2bn($company_info->mobile);?></p>
            </div>
            <div>
                <div class="solaimanlipi_font">তারিখঃ <?= BanglaConverter::en2bn(date('d-m-Y', strtotime($sales_info->sales_date)));?></div>
            </div>
            <div class="" style="display: table; text-align: end; margin-left: 80px;   ">

                <?php if ($sales_info->customer_id == 1) { 
                    if (empty($sales_info->customer_full_name)) { ?>
                        <p class="solaimanlipi_font" style=""><?= $sales_info->customer_name;?></p>
                        <p class="solaimanlipi_font" style="margin-top: -20px;" ><?= $sales_info->address;?></p>
                        <p class="solaimanlipi_font" style="margin-top: -15px;" ><?= BanglaConverter::en2bn($sales_info->mobile);?></p>
                    <?php } else { ?>
                        <p class="solaimanlipi_font" style=""><?= $sales_info->customer_full_name;?></p>
                        <p class="solaimanlipi_font" style="margin-top: -20px;" ><?= $sales_info->cus_address_fulls;?></p>
                        <p class="solaimanlipi_font" style="margin-top: -15px;" ><?= BanglaConverter::en2bn($sales_info->cus_mobile_noo);?></p>
                    <?php } ?>
                <?php } else { ?>
                    <p class="solaimanlipi_font" style=""><?= $sales_info->customer_name;?></p>
                    <p class="solaimanlipi_font" style="margin-top: -20px;" ><?= $sales_info->address;?></p>
                    <p class="solaimanlipi_font" style="margin-top: -15px;" ><?= BanglaConverter::en2bn($sales_info->mobile);?></p>
                <?php } ?>

            </div>
            <table border="3" cellspacing="0">
                <tr>
                    <td class="solaimanlipi_font">পন্যের বিবরন</td>
                    <td class="solaimanlipi_font" align="center">পরিমাণ</td>
                    <td class="solaimanlipi_font" align="right">টাকা</td>
                </tr>
                <?php foreach ($sales_items_info as $item) {
                    $ttl_item_amount[]=$item->total_sales_price_cost_sss; ?>
                    <tr>
                        <td class="solaimanlipi_font" align="center">
                            <?= $item->ref_lot_no; ?><br>
                            <span style="font-size: 12px;">
                                (মোট <?= BanglaConverter::en2bn(round((float)$item->ttl_sale_kgs_this_product, 2)); ?>কেজি)<br>
                                (রেট <?= BanglaConverter::en2bn(round((float)$item->price_per_kg, 2)); ?>/-)
                            </span>
                        </td>
                        <td class="solaimanlipi_font" align="center"><?= BanglaConverter::en2bn($item->sales_qnty_bostas); ?> <?= $item->unit_name; ?></td>
                        <td class="solaimanlipi_font" align="right"><?= BanglaConverter::en2bn(round($item->total_sales_price_cost_sss, 2)); ?>/-</td>
                    </tr>
                <?php } ?>
                <tr>
                    <td class="solaimanlipi_font" align="right" colspan="3"><?= BanglaConverter::en2bn($in_ttl_sales_amnt = round((float)array_sum($ttl_item_amount)), 2); ?>/-</td>
                </tr>
                <?php if (!empty($sales_info->sales_lebar_cost_sss)) { ?>
                    <tr>
                        <td class="solaimanlipi_font" align="center" colspan="2">লেবার খরচ</td>
                        <td class="solaimanlipi_font" align="right" ><?= BanglaConverter::en2bn($sales_info->sales_lebar_cost_sss); ?>/-</td>
                    </tr>
                <?php } ?>
                <?php if (!empty($sales_info->sales_ghat_vara_cost)) { ?>
                    <tr>
                        <td class="solaimanlipi_font" align="center" colspan="2">ঘাট ভাড়া</td>
                        <td class="solaimanlipi_font" align="right" ><?= BanglaConverter::en2bn($sales_info->sales_ghat_vara_cost); ?>/-</td>
                    </tr>
                <?php } ?>
                <tr>
                    <td class="solaimanlipi_font" align="center" colspan="2">সাবেক</td>
                    <td class="solaimanlipi_font" align="right" style="font-weight: bold;" ><?= BanglaConverter::en2bn((float)$sales_info->cus_previous_amount_ttl); ?>/-</td>
                </tr>
                <tr>
                    <td class="solaimanlipi_font" align="right" colspan="2">মোট</td>
                    <td class="solaimanlipi_font" align="right" style="font-weight: bold;" ><?= BanglaConverter::en2bn(round((float)$in_ttl_sales_amnt + (float)$sales_info->sales_lebar_cost_sss + (float)$sales_info->sales_ghat_vara_cost + (float)$sales_info->cus_previous_amount_ttl), 2); ?>/-</td>
                </tr>
                <tr>
                    <td class="solaimanlipi_font" align="right" colspan="2">কৈফিয়ত</td>
                    <td class="solaimanlipi_font" align="right" style="font-weight: bold;" ><?= BanglaConverter::en2bn(round((float)$sales_info->sales_ttl_dis_countss), 2); ?>/-</td>
                </tr>
                <tr>
                    <td class="solaimanlipi_font" align="right" colspan="2"></td>
                    <td class="solaimanlipi_font" align="right" style="font-weight: bold;" ><?= BanglaConverter::en2bn(round((float)$sales_info->in_ttl_amounts_sales), 2); ?>/-</td>
                </tr>
                <tr>
                    <td class="solaimanlipi_font" align="right" colspan="2">জমা</td>
                    <td class="solaimanlipi_font" align="right" style="font-weight: bold;" ><?= BanglaConverter::en2bn((float)$sales_info->paid_amount); ?>/-</td>
                </tr>
                <tr>
                    <td class="solaimanlipi_font" align="right" colspan="2">মোট বকেয়া</td>
                    <td class="solaimanlipi_font" align="right" style="font-weight: bold;" ><?= BanglaConverter::en2bn(round((float)$sales_info->cus_ttl_due_s_now), 2); ?>/-</td>
                    <!-- <?php echo BanglaConverter::en2bn($in_ttl_sales_amnt + (float)$sales_info->sales_lebar_cost_sss + (float)$sales_info->sales_ghat_vara_cost);  ?>/- -->
                </tr>
                <?php if (!empty($sales_info->sales_carring_system_s)) { ?>
                    <tr>
                        <td class="solaimanlipi_font" colspan="3"><?= $sales_info->sales_carring_system_s; ?></td>
                    </tr>
                <?php } ?>
            </table>
            <p class="solaimanlipi_font" style="font-size: 30px; font-weight: bold; margin-top: 0; " > <?= BanglaConverter::en2bn(round((float)$sales_info->cus_ttl_due_s_now), 2); ?>/-</p>
            <br>
            
            <div class="solaimanlipi_font" style="margin: 5px 0 5px 0; font-size: 12px;"> বিক্রিত মাল ফেরত যোগ্য নয়। </div>
            <br>
            <br>
            <hr>
            <br>
            
            <div class="" style="">
                <p class="solaimanlipi_font" style="font-size: 18px; font-weight: bold; "><?= $company_info->company_name;?></p>
                <p class="solaimanlipi_font" style="margin-top: -20px;" ><?= $company_info->address;?></p>
                <p class="solaimanlipi_font" style="margin-top: -15px;" ><?= BanglaConverter::en2bn($company_info->mobile);?></p>
            </div>
            <div>
                <div class="solaimanlipi_font">তারিখঃ <?= BanglaConverter::en2bn(date('d-m-Y', strtotime($sales_info->sales_date)));?></div>
            </div>
            <div class="" style="display: table; text-align: end; margin-left: 80px;   ">
                <p class="solaimanlipi_font" style=""><?= $sales_info->customer_name;?></p>
                <p class="solaimanlipi_font" style="margin-top: -20px;" ><?= $sales_info->address;?></p>
                <p class="solaimanlipi_font" style="margin-top: -15px;" ><?= BanglaConverter::en2bn($sales_info->mobile);?></p>
            </div>
            <table border="1">
                <?php foreach ($sales_items_info as $item) {
                    $ttl_item_amountss[]=$item->total_sales_price_cost_sss; ?>
                    <tr>
                        <td class="solaimanlipi_font" align="center">
                            <?= $item->ref_lot_no; ?><br>
                            <span style="font-size: 12px;">
                                (মোট <?= BanglaConverter::en2bn($item->ttl_sale_kgs_this_product); ?>কেজি)
                            </span>
                        </td>
                        <td class="solaimanlipi_font" align="center"><b><?= BanglaConverter::en2bn($item->sales_qnty_bostas); ?> <?= $item->unit_name; ?></b></td>
                    </tr>
                <?php } ?>
                    <tr >
                        <td class="solaimanlipi_font" colspan="3"><?= $sales_info->sales_carring_system_s; ?></td>
                    </tr>
            </table>


                
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>

            <div class="solaimanlipi_font" style="margin: 5px 0 5px 0; font-size: 12px;"> মাল বুঝিয়া পাইয়া স্বাক্ষর দিলাম। </div>
            <hr><hr><hr>
        </center>
    </body>
</html>