<!DOCTYPE html>
<html lang="en">
    <head>
        <base href="<?php echo base_url(); ?>" target="">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Checking </title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


        <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>


    </head>
    <body>

        <div class="container mt-5">
            <h2 class="text-center " >Transport History Checking</h2>
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr class="table-primary text-center ">
                        <th>নং</th>
                        <th>তারিখ</th>
                        <th>পূর্বের বকেয়া</th>
                        <th>ভাড়া</th>
                        <th>কমিশন</th>
                        <th>ড্রাইভার এডভান্স</th>
                        <th>বর্তমান বকেয়া</th>
                        <th>অপশন</th>
                    </tr>
                </thead>
                <tbody class="set_html_data" ></tbody>
            </table>
        </div>








            </table>
        </div>









        <script>
            get_all_darass();
            function get_all_darass() { 
                $.ajax({
                    type: "get",
                    url: "tax/get_all_transport_datas_infosss",
                    data: "",                            
                    beforeSend: function() {
                        $('.spiner_load_activity').css('display', 'block');
                    },
                    complete: function() {
                        $('.spiner_load_activity').css('display', 'none');
                    },
                    success: function (re) {
                        let table_tr_assign = '';
                        let table_data = [];
                        let tm = 0;
                        let n = 0;

                        for (n = 0; n < re.transport_infos.length; n++) {
                            table_data.push({
                                serial: n + 1,
                                id_trns: re.transport_infos[n].db_purchase_transports_info_a_idd,
                                id_pay: 0,
                                date: re.transport_infos[n].pur_date_timsssss,
                                prev_amnt: re.transport_infos[n].trans_port_prev_amntss,
                                trns_vara: re.transport_infos[n].ttl_trans_other_cost,
                                trns_comms: re.transport_infos[n].ttl_com_amnt_for_trans,
                                driver_advns: re.transport_infos[n].driver_advance_amnt_cost,
                                now_amnt_s: re.transport_infos[n].due_trans_port_amnts_sss_now,
                            });
                        }

                        for (let m = 0; m < re.trns_give_amont.length; m++) {
                            table_data.push({
                                serial: n++,
                                id_trns: 0,
                                id_pay: re.trns_give_amont[m].db_transport_given_payment_auto_idddd,
                                date: re.trns_give_amont[m].db_transport_given_datess,
                                prev_amnt: re.trns_give_amont[m].trns_prev_amnt_entrr,
                                trns_vara: '----',
                                trns_comms: re.trns_give_amont[m].db_transport_methods,
                                driver_advns: 'জমা---- '+re.trns_give_amont[m].db_transport_payment_amount,
                                now_amnt_s: re.trns_give_amont[m].trns_now_amnt_ssssss_shows,
                            });
                        }

                        // তারিখ অনুযায়ী ডেটা sort করা
                        table_data.sort((a, b) => {
                            let dateA = new Date(a.date);
                            let dateB = new Date(b.date);

                            // প্রথমে তারিখ অনুযায়ী sort
                            if (dateA - dateB !== 0) {
                                return dateA - dateB;
                            }
                        }); 

                        // তারিখ অনুযায়ী ডেটা sort করা
                        table_data.sort((a, b) => new Date(a.date) - new Date(b.date));
                    
                        // টেবিল পুনরায় তৈরি করা এবং সঠিক সিরিয়াল সেট করা
                        table_data.forEach((data, index) => { 
                            table_tr_assign += `<tr class="datas_rows_tr ">
                                                    <td class="text-center vertical-middle">${index + 1}</td>
                                                    <td class="text-center vertical-middle" >${data.date}</td>
                                                    <td class="text-right " ><input type="text" style="text-align: right; " class="form-control form-control-sm td_prev_amnts " value="${data.prev_amnt}" /> </td> 
                                                    <td class="text-right " style="text-align: right; " >${data.trns_vara}</td>
                                                    <td class="text-right " style="text-align: right; " >${data.trns_comms}</td>
                                                    <td class="text-right " style="text-align: right; " >${data.driver_advns}</td>
                                                    <td class="text-right " style="text-align: right; " ><input type="text" class="form-control form-control-sm now_amnts_show " value="${data.now_amnt_s}" > </td>
                                                    <td class="text-center vertical-middle">
                                                        <div class="btn btn-info btn-sm editing_btn_td" idpay_s="${data.id_pay}" id_trans="${data.id_trns}">${data.id_trns} Edit</div>
                                                    </td>
                                                </tr>`;  
                        });
                        $('.set_html_data').html(table_tr_assign);
                    }
                });
            }


            $(document).on('click', '.editing_btn_td', function () {
                let id_pay = $(this).attr('idpay_s');
                let id_trans = $(this).attr('id_trans');
                // Edit button functionality here 

                let prev_amnt = $(this).closest('tr').find('.td_prev_amnts').val();
                let now_amnt = $(this).closest('tr').find('.now_amnts_show').val();

                $.ajax({
                    type: "post",
                    url: "tax/update_transport_purchasessssssssssssssssss_info",
                    data: {
                        id_trans: id_trans,
                        prev_amnt: prev_amnt,
                        now_amnt: now_amnt
                    },
                    success: function (sr) {
                        get_all_darass();
                    }
                });

            });
        </script>




<!-- <input type="text" class="form-control form-control-sm " value="" > -->





    </body>
</html>