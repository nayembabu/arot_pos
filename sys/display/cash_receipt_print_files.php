<!DOCTYPE html>
<html lang="en">
    <head>
        <base href="<?php echo base_url(); ?>" target="">
        
    </head>
    <body style="margin: 0; padding: 0; ">

        <!-- <p style="margin-top: -20px;" ><?= $company_info->email;?></p> -->

        <center>
            <div class="" style="">
                <p style="font-size: 18px; font-weight: bold; "><?= $company_info->company_name;?></p>
                <p style="margin-top: -20px;" ><?= $company_info->address;?></p>
                <p style="margin-top: -15px;" ><?= BanglaConverter::en2bn($company_info->mobile);?></p>
            </div>
            <div>
                <div>তারিখঃ <?= BanglaConverter::en2bn(date('d-m-Y', strtotime($pay_info->payment_date)));?></div>
            </div>
            <div class="" style="display: table; text-align: end; margin-left: 80px;   ">
                <p style=""><?= $pay_info->customer_name;?></p>
                <p style="margin-top: -20px;" ><?= $pay_info->address;?></p>
                <p style="margin-top: -15px;" ><?= BanglaConverter::en2bn($pay_info->mobile);?></p>
                <p style="margin-top: -15px;" >জমার সময়ঃ <?= $pay_info->payment_timing;?> </p>
                <p style="margin-top: -15px;" >জমার মারফতঃ  <?= $pay_info->payment_type;?></p>
            </div>
            <table border="1px">
                <tr>
                    <td>পূর্বের বকেয়া ছিলো</td>
                    <td align="right"><?= BanglaConverter::en2bn($pay_info->sales_due+$pay_info->payment);?> টাকা</td>
                </tr>
                <tr>
                    <td>জমার পরিমানঃ</td>
                    <td align="right"><?= BanglaConverter::en2bn($pay_info->payment);?> টাকা</td>
                </tr>
                <tr>
                    <td>বর্তমান বকেয়া</td>
                    <td align="right"><?= BanglaConverter::en2bn($pay_info->sales_due);?> টাকা</td>
                </tr>
            </table>

            
            <p style="font-size: 35px; font-weight: bold; margin-top: 0; " > <?= BanglaConverter::en2bn((float)$pay_info->sales_due); ?>/-</p>
            <br>
            <hr><hr><hr>
        </center>
    </body>
</html>