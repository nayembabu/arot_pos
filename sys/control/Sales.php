<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Dompdf\Dompdf;
use Dompdf\Options;
use FontLib\Table\Type\post;  

class BanglaConverter { 

    public static $bn = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
    public static $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
    
    public static function bn2en($number) {
        return str_replace(self::$bn, self::$en, $number);
    }
    
    public static function en2bn($number) {
        return str_replace(self::$en, self::$bn, $number);
    }

	public static function base64ToImage($base64_string, $output_file) {
		$file = fopen($output_file, "wb");
		$data = explode(',', $base64_string);
		fwrite($file, base64_decode($data[1]));
		fclose($file);
		return $output_file;
	}
     
}

class Sales extends MY_Controller {
    public function __construct(){
        parent::__construct();
        $this->load_global();
        $this->load->model('sales_model','sales');
        $this->load->model('buy_model','buy');
        $this->load->helper('sms_template_helper');
    }

    public function is_sms_enabled(){
        return is_sms_enabled();
    }

    public function index()
    {
        $this->permission_check('sales_view');
        $data=$this->data;
        $data['page_title']=$this->lang->line('sales_list');
        $this->load->view('sales-list',$data);
    }

    public function add()
    {	
        $data=$this->data;
        $data['page_title']='নতুন বিক্রয়';

        $data['suppliers']=$this->buy->get_all_suppliers();
        $data['products']=$this->buy->get_all_products();
        $data['trans']=$this->buy->get_all_transports();
        $this->load->view('saled_view_file',$data);
    }

    public function add_rasta() 
    { 
        $data=$this->data;
        $trans_id = $this->input->get('trans_id');
        $data['page_title']='রাস্তায় বিক্রয়';
        $data['trans_info'] = $this->buy->get_due_purchase_transport_info_by_id($trans_id);
        $data['items_infos'] = $this->buy->get_purchase_item_info_by_trans_id($trans_id);
        if (empty($trans_id)) { 
            $this->load->view('sales_rasta_views',$data);
        }else {
            $this->load->view('sale_rasta_view_file',$data);
        }
    }

    public function get_all_customer_json_data()
    {
        $this->output->set_content_type('application/json')->set_output(json_encode($this->buy->get_all_customers()));
    }

    public function sales_product_return_view_fun()
    {
        $data=$this->data;
        $data['page_title']='পন্য ফেরত';
        $data['company_info'] = $this->buy->get_company_info();
        $data['cutomers_info'] = $this->buy->get_all_customers();
        $this->load->view('sale_item_return_view_file',$data);    
    } 

    public function get_sales_info_date_to_date() 
    {
        $sales_infos = $this->buy->get_sales_infos_date_to_date(date('Y-m-d', strtotime($this->input->post('startDate'))), date('Y-m-d', strtotime($this->input->post('endsDate'))), $this->input->post('custID'));
        $this->output->set_content_type('application/json')->set_output(json_encode($sales_infos));
    }

    public function get_sales_item_by_sales_id() 
    {
        $data_sales_items_info = $this->buy->get_sales_items_infos_by_sales_id($this->input->post('sales_id'));
        $this->output->set_content_type('application/json')->set_output(json_encode($data_sales_items_info));
    }   

    public function get_sales_item_by_sales_item_id()
    {
        $data_sales_items_info = $this->buy->get_sales_items_infos_by_sales_item_id($this->input->post('sales_items_id'));
        $this->output->set_content_type('application/json')->set_output(json_encode($data_sales_items_info));
    }

    public function insert_return_sales_items()
    {
        $sales_item_id      = $this->input->post('sales_item_ids');
        $pur_item_id        = $this->input->post('pur_item_ids');
        $ttl_return_qnty    = $this->input->post('return_qnty');
        $ttl_return_weight  = $this->input->post('return_weight');
        $ttl_return_cost    = $this->input->post('return_cost');
        $lot_no             = rand(1000,9999);

        $data_sales_items_info = $this->buy->get_sales_items_infos_by_sales_item_id($sales_item_id);
        $data_pur_item_info = $this->buy->get_purchase_item_by_id($pur_item_id);
        $data_customer_info = $this->buy->get_customer_by_cus_id($data_sales_items_info->customer_id);

        // if (empty($data_pur_item_info->supplyer_id_a_pr)) {
        //     $supp = '';
        //     $cuss = $data_pur_item_info->cust_auto_uniqss_id;
        // }elseif (empty($data_pur_item_info->cust_auto_uniqss_id)) {
        //     $supp = $data_pur_item_info->supplyer_id_a_pr;
        //     $cuss = '';
        // } 

        // $this->buy->update_sales_items_tbl(
        //     array(
        //         "sales_qnty_bostas" => (int)$data_sales_items_info->sales_qnty_bostas - (int)$ttl_return_qnty
        //     ), $data_sales_items_info->id 
        // );

        // if (empty($ttl_return_cost)) {
        //     $unit_price = (float)$data_pur_item_info->price_per_unit;
        // } else {
        //     $unit_price = (float)$data_pur_item_info->price_per_unit + ((float)$ttl_return_cost/(float)$ttl_return_qnty/$data_sales_items_info->sales_kgs_perbosta); 
        // }


			$last_purchase_transports_id = $this->buy->insert_purchase_this_transports_info(
				array( 
					'products_items_at_ididii' 					=> $data_pur_item_info->item_id, 
					'custmr_id_uniqs' 							=> $data_sales_items_info->customer_id, 
					'pur_date_timsssss' 						=> date('Y-m-d'), 
					'pur_status_buy_change' 					=> 1, 
					'lot_trns_ref_nop_s' 					    => $lot_no, 
					'ttl_items_bosta_this_trans' 				=> $ttl_return_qnty, 
					'ttl_due_bosta_this_trans' 					=> $ttl_return_qnty, 
					'ttl_item_kg_trans' 						=> $ttl_return_weight, 
					'ttl_trans_other_cost' 						=> 0, 
					'trans_com_per_bosta' 						=> 0, 
					'ttl_trans_com' 							=> 0, 
					'prodct_sell_bosta_in_road' 				=> 0, 
					'trans_com_cutting_amnt' 					=> 0, 
					'ttl_com_amnt_for_trans' 					=> 0, 
					'ghar_kuli_rates_per_bosta' 				=> 0, 
					'ttal_ghar_kuli_cost_amnt' 					=> 0, 
					'ghar_kuli_cost_amnt_for_trans_with_cut'	=> 0, 
					'driver_advance_amnt_cost' 					=> 0, 
					'others_cost_amnt_for_trans' 				=> $ttl_return_cost, 
					'total_trans_price' 						=> (float)$data_sales_items_info->price_per_kg*(float)$ttl_return_weight, 
					'supp_commis_items_wsss' 					=> 0, 
					'supp_paid_amnt_s' 							=> 0, 
					'supp_pre_amtssss' 							=> 0, 
					'supp_now_due_amnt_ssssss' 					=> 0, 
					'unpaid_amount_this_trans_tk' 				=> 0, 
					'koifiyat_amount_tk_for_this_trans' 		=> 0, 
					'kofiyat_desc_for_this_trans' 				=> 0, 
					'now_timess' 								=> time(), 
					'now_date_formate' 							=> date('Y-m-d'),  
				)
			);

			$last_purchase_id = $this->buy->insert_tbl_purchase_datas(
				array(
					'items_uniq_int_id' 			=> $data_pur_item_info->item_id,
					'pur_trans_info_auto_iddid'		=> $last_purchase_transports_id,
					'ttl_buy_purchases_bosta'		=> $ttl_return_qnty,
					'due_of_this_trans_purchase'	=> $ttl_return_qnty,
					'purchase_code' 				=> time(),
					'reference_no' 					=> $lot_no, 
					'grand_total' 					=> (float)$data_sales_items_info->price_per_kg*(float)$ttl_return_weight,  
					'paid_amount' 					=> 0, 
					'ttl_pur_kgssss' 				=> $ttl_return_weight,   
					'supp_pre_amountss' 			=> 0, 
					'supp_now_dues_amountss' 		=> 0, 
					'purchase_date' 				=> date('Y-m-d'),
					'purchase_status' 				=> 'Received',
					'buying_type_status' 			=> 1,
					'custmr_id' 					=> $data_sales_items_info->customer_id,
					'created_date' 					=> date('Y-m-d'),
					'created_time' 					=> time(),
					'system_ip' 					=> $_SERVER['REMOTE_ADDR'],
					'system_name' 					=> gethostbyaddr($_SERVER['REMOTE_ADDR']),
					'status' 						=> 1,
				)
			);  

        $add_purchase_item_id = $this->buy->insert_tbl_purchase_item_datas(
            array(
                "purchase_id"                       => $last_purchase_id,
                "purchase_status"                   => 'Received',
                "item_id"                           => $data_pur_item_info->item_id,
                "purchase_trans_info_auto_pr_iddds" => $last_purchase_transports_id,
                "cust_auto_uniqss_id"               => $data_sales_items_info->customer_id,
                "ref_lot_no"                        => $data_pur_item_info->ref_lot_no,
                "purchase_item_dates"               => date('Y-m-d'),
                "pur_buying_types_statu"            => 1,
                "ttl_purchase_kg_sss"               => $ttl_return_weight,
                "purchase_qty"                      => $ttl_return_qnty,
                "price_per_unit"                    => $data_sales_items_info->price_per_kg,
                "purchase_total_bosta"              => $ttl_return_qnty,
                "due_sells_bosta_ss"                => $ttl_return_qnty,
                "pur_kg_per_bosta"                  => (float)$ttl_return_weight / (float)$ttl_return_qnty,
                "description"                       => 'Sales return products',
                "status"                            => 1,
            )
        );  

        $this->buy->insert_return_sales_items(
            array(
                "sales_id"                  => $data_sales_items_info->sales_id,
                "sales_items_unq_auto_iddd" => $data_sales_items_info->id,
                "return_status"             => '1',
                "return_qty"                => $ttl_return_qnty,
                "price_per_unit"            => $data_sales_items_info->price_per_kg,
                "return_ttl_weight_s"       => $ttl_return_weight,
                "ttl_sale_return_dates"     => date('Y-m-d'),
                "purchase_price"            => $data_sales_items_info->purchase_per_kgs_price,  
                "pur_items_unq_a_iddd"      => $data_sales_items_info->pur_item_a_priddd, 
                "cust_auto_unq_ids"         => $data_sales_items_info->customer_id,
                "new_pur_items_unq_id"      => $add_purchase_item_id,
            )
        );

        if ($data_sales_items_info->sales_status == 1) {
            $this->buy->update_customer_total_due(
                array(
                    "sales_due"					=> (float)$data_customer_info->sales_due - ((float)$ttl_return_weight*(float)$data_sales_items_info->price_per_kg),
                ), $data_customer_info->id 
            );
                
            $sales_payment_id = $this->buy->insert_sales_payments_func(
                array(
                    "sales_id"					    => $sales_item_id,
                    "customer_id"					=> $data_customer_info->id,
                    "payment_date"					=> date('Y-m-d'),
                    "payment_type"					=> 'return sales item',
                    "payment"					    => ((float)$ttl_return_weight*(float)$data_sales_items_info->price_per_kg),
                    "created_time"					=> time(),
                    "created_date"					=> date('Y-m-d'),
                )
            );

            $this->buy->insert_customer_payments_func(
                array(
                    "salespayment_id"   => $sales_payment_id,
                    "customer_id"       => $data_customer_info->id,
                    "payment_date"      => date('Y-m-d'),
                    "payment_type"      => $data_customer_info->customer_name.'বিক্রয় পন্য ফেরত',
                    "payment"           => ((float)$ttl_return_qnty*(float)$data_pur_item_info->pur_kg_per_bosta*(float)$data_pur_item_info->price_per_unit),
                    "created_time"      => time(),
                    "created_date"      => date('Y-m-d')
                )
            );
        }

    }

    public function sales_receipt_view_fun() 
    {
        $sale_id = $this->input->get('sales_id');
        $data['company_info'] = $this->buy->get_company_info();
        $data['sales_info'] = $this->buy->get_sales_info_by_sales_id($sale_id);
        $data['sales_items_info'] = $this->buy->get_sales_items_infos_by_sales_id($sale_id);
        // $this->output->set_content_type('application/json')->set_output(json_encode($data));
        $this->load->view('sale_receipt_print_file',$data);        
    }
    
	public function cash_receipt_view()
	{
		$pay_id = $this->input->get('pay_id');
        $data['company_info'] = $this->buy->get_company_info();
        $data['pay_info'] = $this->buy->get_customer_payments_by_id($pay_id);
        $this->load->view('cash_receipt_print_files',$data);    
	}

    public function get_purchase_transport_info_by_date()
    {
        $selected_dates = date('Y-m-d', strtotime($this->input->post('select_dates')));
        $data['transport_info'] = $this->buy->get_purchase_transport_info_by_date($selected_dates);
        if (!empty($data['transport_info']->prodct_sell_bosta_in_road)) {
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }else {
            echo 0;
        }
    }

    public function get_purchase_transport_info_by_date_for_sales_rasta()
    {
        $selected_dates = date('Y-m-d', strtotime($this->input->post('select_dates')));
        $data['transport_info'] = $this->buy->get_purchase_transport_info_by_date_for_sales_rasta($selected_dates);
        if (!empty($data['transport_info'])) {
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }else {
            echo 0;
        }
    }
    
    public function get_due_purchase_transport_infos()
    {
        $product_id = $this->input->post('pr_id');
        $data['transport_info'] = $this->buy->get_due_purchase_transport_info_by_item_id($product_id);
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function get_product_info_by_product_id()
    {
        $product_id = $this->input->post('pr_id');
        $data['product_info'] = $this->buy->get_this_product_info_by_id($product_id);
        $data['purchase_info'] = $this->buy->get_all_purchases_infos($product_id);
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function get_items_details_by_purchase_item_id()
    {
        $purchase_trans_id = $this->input->post('pt_id');
        $data['transport_info'] = $this->buy->get_due_purchase_transport_info_by_id($purchase_trans_id);
        $data['purchase_info'] = $this->buy->get_purchase_info_by_trans_id($purchase_trans_id);
        $data['product_info'] = $this->buy->get_this_product_info_by_id($data['transport_info']->products_items_at_ididii);
        $data['purchase_cost_info'] = $this->buy->get_purchase_cost_by_trans_id($purchase_trans_id);
        $data['purchase_item_infos'] = $this->buy->get_purchase_item_info_by_trans_id($purchase_trans_id);
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function get_purchases_all_info_for_sales_item()
    { 
        $purchase_item_id = $this->input->post('pur_item_id');
        $pur_trans_aut_id = $this->input->post('pur_tran_id');
        $data['pur_item_info'] = $this->buy->get_purchase_item_by_id($purchase_item_id);
        $data['transport_info'] = $this->buy->get_due_purchase_transport_info_by_id($pur_trans_aut_id);
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }      

    public function get_purchases_customer_infos_by_id()
    {
        $customer_data = $this->buy->get_customer_by_cus_id($this->input->post('cus_idd'));
        $this->output->set_content_type('application/json')->set_output(json_encode($customer_data));
    } 

    public function sales_this_product_qnty()
    { 
            $uniq_ids = time();

        if (empty($this->input->post('cus_uniq')) || empty($this->input->post('sale_type')) || empty($this->input->post('ttl_item_price'))) { 
            echo 0;
        }else {            
            $item_idss          = array($this->input->post('item_unq_ids'));
            $item_u_id          = array($this->input->post('item_uniq_id'));
            $trans_u_id         = array($this->input->post('trans_uniq_id'));
            $ttl_qnty           = array($this->input->post('ttl_qnty'));
            $ttl_kgs            = array($this->input->post('tt_kg_sales'));
            $kg_rates           = array($this->input->post('rate_per_kg'));
            $ttl_sale_price     = array($this->input->post('ttl_sale_price'));
            $salling_ttl_cost   = array($this->input->post('salling_rates'));

            $customer_data = $this->buy->get_customer_by_cus_id($this->input->post('cus_uniq'));

            $cust_now_balance_amountssssss = ((((float)$customer_data->sales_due + (float)$this->input->post('ttl_item_price') + (float)$this->input->post('lebar_cost') + (float)$this->input->post('ghat_vara'))) - (float)$this->input->post('discount_s')) - (float)$this->input->post('paid_amount_ss');

            if ($this->input->post('due_cus_amount') !=  $cust_now_balance_amountssssss) { 
                echo 0;
                die();
            }

            $sales_last_id = $this->buy->entry_s_new_sales(
                array(
                    "sales_date"				=> date('Y-m-d', strtotime($this->input->post('sale_date'))),
                    "sales_status"				=> $this->input->post('sale_type'),
                    "customer_id"				=> $this->input->post('cus_uniq'),
                    "ttl_sales_prices"			=> $this->input->post('ttl_item_price'),
                    "sales_lebar_cost_sss"		=> $this->input->post('lebar_cost'),
                    "sales_ghat_vara_cost"		=> $this->input->post('ghat_vara'),
                    "sales_ttl_dis_countss"		=> $this->input->post('discount_s'),
                    "in_ttl_amounts_sales"		=> $this->input->post('ttl_cus_amount'),
                    "ttl_sales_kgss"		    => array_sum(array_map('array_sum', $ttl_kgs)),
                    "sales_paid_able_amnt"		=> $this->input->post('paid_amount_ss'),
                    "cus_previous_amount_ttl"	=> $this->input->post('cus_prev_amnt'),
                    "cus_ttl_due_s_now"			=> $this->input->post('due_cus_amount'),
                    "subtotal"					=> $this->input->post('ttl_item_price'),
                    "grand_total"				=> $this->input->post('ttl_cus_amount'),
                    "paid_amount"				=> $this->input->post('paid_amount_ss'),
                    "sales_carring_system_s"	=> $this->input->post('carring_system'),
                    "created_date"				=> date('Y-m-d'),
                    "created_time"				=> time(),
                    "uniq_id_ssss"				=> $uniq_ids,
                )
            );


            $sales_data = [];

            foreach ($item_u_id as $key => $value) { 
                foreach ($value as $key1 => $value1) { 

                    $purchase_trans_data_infos = $this->buy->get_due_purchase_transport_info_by_id($trans_u_id[$key][$key1]); 

                    $this->buy->update_purchase_this_transports_info(
                        array(
                            "ttl_due_bosta_this_trans"		=> (float)$purchase_trans_data_infos->ttl_due_bosta_this_trans - (float)$ttl_qnty[$key][$key1],
                        ), 
                        $trans_u_id[$key][$key1] 
                    );

                    $purchase_item_data = $this->buy->get_purchase_item_info_by_id($item_u_id[$key][$key1]);
                    $total_item_due_ss = $purchase_item_data->due_sells_bosta_ss - $ttl_qnty[$key][$key1];
                    $this->buy->update_purchase_items_due(
                        array(
                            "due_sells_bosta_ss"		=> $total_item_due_ss,
                        ), 
                        $purchase_item_data->id 
                    );
                    $parse_lot_data[] = $purchase_item_data->ref_lot_no;

                    $sales_data[] = [
                        "sales_id"                      => $sales_last_id,
                        "sales_status"                  => $this->input->post('sale_type'),
                        "item_id"                       => $item_idss[$key][$key1],
                        "pur_item_a_priddd"             => $item_u_id[$key][$key1],
                        "trans_uniq_primary_id"         => $trans_u_id[$key][$key1],
                        "payment_datesss"               => date('Y-m-d', strtotime($this->input->post('sale_date'))),
                        "sales_qnty_bostas"             => $ttl_qnty[$key][$key1],
                        "price_per_kg"                  => $kg_rates[$key][$key1],
                        "ttl_sale_kgs_this_product"     => $ttl_kgs[$key][$key1],
                        "sales_kgs_perbosta"            => $ttl_kgs[$key][$key1] / $ttl_qnty[$key][$key1],
                        "total_sales_price_cost_sss"    => $ttl_sale_price[$key][$key1],
                        "purchase_per_kgs_price"        => $salling_ttl_cost[$key][$key1],
                    ]; 
                }
            }
            $this->buy->insert_batch_sales_item_all_datas($sales_data);

            if ($this->input->post('sale_type') == 1) {
                $this->buy->update_customer_total_due(
                    array(
                        "sales_due"					=> $this->input->post('due_cus_amount'),
                    ),
                    $this->input->post('cus_uniq')
                );
            }

            $this->buy->insert_sales_total_amount_s(
                array(
                    "due_sales_dates_times"			=> date('Y-m-d', strtotime($this->input->post('sale_date'))),
                    "customer_unq_iddds"			=> $this->input->post('cus_uniq'),
                    "sale_s_pr_auto_diiiidd"		=> $sales_last_id,
                    "sales_items_ttl_prices_sss"	=> $this->input->post('ttl_item_price'),
                    "sales_lebar_cost_sss_pp"		=> $this->input->post('lebar_cost'),
                    "sales_ghat_vara_cost_sss_pp"	=> $this->input->post('ghat_vara'),
                    "ttl_salesss_discount_ss"		=> $this->input->post('discount_s'),
                    "sales_paidable_amount_sss"		=> $this->input->post('ttl_cus_amount'),
                    "sales_paid_amount_ssssssssss"	=> $this->input->post('paid_amount_ss'),
                    "ttl_due_now_ss_sales_ssss"		=> $this->input->post('due_cus_amount'),
                    "create_entry_datess"			=> date('Y-m-d'),
                    "create_entry_timessstmp"		=> time(),
                )
            );
            
            $sales_payment_id = $this->buy->insert_sales_payments_func(
                array(
                    "sales_id"					    => $sales_last_id,
                    "customer_id"					=> $this->input->post('cus_uniq'),
                    "payment_date"					=> date('Y-m-d', strtotime($this->input->post('sale_date'))),
                    "payment_type"					=> 'cash',
                    "payment"					    => $this->input->post('paid_amount_ss'),
                    "created_time"					=> time(),
                    "created_date"					=> date('Y-m-d'),
                )
            );

            $this->buy->insert_expense_data(
                array(
                    "category_id"					=> 1,
                    "expense_date"					=> date('Y-m-d', strtotime($this->input->post('sale_date'))),
                    "expense_for"					=> $customer_data->customer_name.' -  লেবার খরচ',
                    "expense_amt"					=> $this->input->post('lebar_cost'),
                    "sales_unqqqq_iddi"				=> $sales_last_id,
                    "cust_idds_qqs"					=> $customer_data->id,
                    "created_date"					=> date('Y-m-d'),
                    "created_time"					=> time(),
                    "status"					    => 1,
                )
            );
            $this->buy->insert_expense_data(
                array(
                    "category_id"					=> 1,
                    "expense_date"					=> date('Y-m-d', strtotime($this->input->post('sale_date'))),
                    "expense_for"					=> $customer_data->customer_name.' -  ঘাট ভাড়া ',
                    "expense_amt"					=> $this->input->post('ghat_vara'),
                    "sales_unqqqq_iddi"				=> $sales_last_id,
                    "cust_idds_qqs"					=> $customer_data->id,
                    "created_date"					=> date('Y-m-d'),
                    "created_time"					=> time(),
                    "status"					    => 1,
                )
            ); 
            $this->buy->insert_income_payment(
                array(
                    "income_date"	                => date('Y-m-d', strtotime($this->input->post('sale_date'))),
                    "income_for"	                => $customer_data->customer_name.' বিক্রির টাকা ',
                    "income_amount"                 => $this->input->post('paid_amount_ss'),
                    "saless_unqqqsa_iddddiiii"		=> $sales_last_id,
                    "custsss_iddss_qqsq"			=> $customer_data->id,
                    "create_date"	                => date('Y-m-d'),
                    "created_time"	                => time(),
                )
            );

            $this->buy->insert_customer_payments_func(
                array(
                    "salespayment_id"   => $sales_payment_id,
                    "customer_id"       => $customer_data->id,
                    "payment_date"      => date('Y-m-d', strtotime($this->input->post('sale_date'))),
                    "payment_type"      => 'Sales Payment Entry',
                    "payment"           => $this->input->post('paid_amount_ss'),
                    "created_time"      => time(),
                    "created_date"      => date('Y-m-d')
                )
            );  

            
            if ($this->input->post('cus_uniq') == 1) {
                $this->buy->insert_normal_customer_infoss(
                    array(
                        "customer_full_name"        => $this->input->post('n_cust_name'),
                        "cus_mobile_noo"            => $this->input->post('n_cust_mobile'),
                        "cus_address_fulls"         => $this->input->post('n_cust_address'),
                        "sales_unq_autos_iiidd"     => $sales_last_id,
                    )
                );
            }

            echo $sales_last_id;
            
        }
    }

    public function sales_save_and_update(){
        $this->form_validation->set_rules('sales_date', 'Sales Date', 'trim|required');
        $this->form_validation->set_rules('customer_id', 'Customer Name', 'trim|required');
        
        if ($this->form_validation->run() == TRUE) {
            $result = $this->sales->verify_save_and_update();
            echo $result;
        } else {
            echo "Please Fill Compulsory(* marked) Fields.";
        }
    }

    public function update($id){
        $this->permission_check('sales_edit');
        $data=$this->data;
        $data=array_merge($data,array('sales_id'=>$id));
        $data['page_title']=$this->lang->line('sales');
        $this->load->view('sales', $data);
    }
    

    public function ajax_list()
    {
        $list = $this->sales->get_datatables();
        
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $sales) {
            
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" name="checkbox[]" value='.$sales->id.' class="checkbox column_checkbox" >';
            $row[] = show_date($sales->sales_date);

            $info = (!empty($sales->return_bit)) ? "\n<span class='label label-danger' style='cursor:pointer'><i class='fa fa-fw fa-undo'></i>Return Raised</span>" : '';

            $row[] = $sales->sales_code.$info;
            $row[] = $sales->sales_status;
            $row[] = $sales->reference_no;
            $row[] = $sales->customer_name;
            //$row[] = $sales->warehouse_name;
            $row[] = app_number_format($sales->grand_total);
            $row[] = app_number_format($sales->paid_amount);
            $row[] = app_number_format($sales->sales_due);
                    $str='';
                    if($sales->payment_status=='Unpaid')
                      $str= "<span class='label label-danger' style='cursor:pointer'>Unpaid </span>";
                    if($sales->payment_status=='Partial')
                      $str="<span class='label label-warning' style='cursor:pointer'> Partial </span>";
                    if($sales->payment_status=='Paid')
                      $str="<span class='label label-success' style='cursor:pointer'> Paid </span>";

            $row[] = $str;
            $row[] = ucfirst($sales->created_by);

                     if($sales->pos ==1):
                         $str1='pos/edit/';
                     else:
                         $str1='sales/update/';
                     endif;

                    $str2 = '<div class="btn-group" title="View Account">
                                        <a class="btn btn-primary btn-o dropdown-toggle" data-toggle="dropdown" href="#">
                                            Action <span class="caret"></span>
                                        </a>
                                        <ul role="menu" class="dropdown-menu dropdown-light pull-right">';
                                            if($this->permissions('sales_view'))
                                            $str2.='<li>
                                                <a title="View Invoice" href="sales/invoice/'.$sales->id.'" >
                                                    <i class="fa fa-fw fa-eye text-blue"></i>View sales
                                                </a>
                                            </li>';

                                            if($this->permissions('sales_edit'))
                                            $str2.='<li>
                                                <a title="Update Record ?" href="'.$str1.$sales->id.'">
                                                    <i class="fa fa-fw fa-edit text-blue"></i>Edit
                                                </a>
                                            </li>';

                                            if($this->permissions('sales_payment_view'))
                                            $str2.='<li>
                                                <a title="Pay" class="pointer" onclick="view_payments('.$sales->id.')" >
                                                    <i class="fa fa-fw fa-money text-blue"></i>View Payments
                                                </a>
                                            </li>';

                                            if($this->permissions('sales_payment_add'))
                                            $str2.='<li>
                                                <a title="Pay" class="pointer" onclick="pay_now('.$sales->id.')" >
                                                    <i class="fa fa-fw fa-hourglass-half text-blue"></i>Payment Receive
                                                </a>
                                            </li>';

                                            if($this->permissions('sales_add') || $this->permissions('sales_edit'))
                                            $str2.='<li>
                                                <a title="Update Record ?" target="_blank" href="sales/print_invoice/'.$sales->id.'">
                                                    <i class="fa fa-fw fa-print text-blue"></i>Print
                                                </a>
                                            </li>

                                            <li>
                                                <a title="Update Record ?" target="_blank" href="sales/pdf/'.$sales->id.'">
                                                    <i class="fa fa-fw fa-file-pdf-o text-blue"></i>PDF
                                                </a>
                                            </li>
                                            <li>
                                                <a style="cursor:pointer" title="Print POS Invoice ?" onclick="print_invoice('.$sales->id.')">
                                                    <i class="fa fa-fw fa-file-text text-blue"></i>POS Invoice
                                                </a>
                                            </li>'; 

                                            if($sales->sales_status=='Final' && $this->permissions('sales_return'))
                                            $str2.='<li>
                                                <a title="Sales Return" href="sales_return/add/'.$sales->id.'">
                                                    <i class="fa fa-fw fa-undo text-blue"></i>Sales Return
                                                </a>
                                            </li>';

                                            if($this->permissions('sales_delete'))
                                            $str2.='<li>
                                                <a style="cursor:pointer" title="Delete Record ?" onclick="delete_sales(\''.$sales->id.'\')">
                                                    <i class="fa fa-fw fa-trash text-red"></i>Delete
                                                </a>
                                            </li>
                                            
                                        </ul>
                                    </div>';			

            $row[] = $str2;

            $data[] = $row;
        }
    

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->sales->count_all(),
                        "recordsFiltered" => $this->sales->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
    public function update_status(){
        $this->permission_check('sales_edit');
        $id=$this->input->post('id');
        $status=$this->input->post('status');

        
        $result=$this->sales->update_status($id,$status);
        return $result;
    }
    public function delete_sales(){
        $this->permission_check_with_msg('sales_delete');
        $id=$this->input->post('q_id');
        echo $this->sales->delete_sales($id);
    }
    public function multi_delete(){
        $this->permission_check_with_msg('sales_delete');
        $ids=implode (",",$_POST['checkbox']);
        echo $this->sales->delete_sales($ids);
    }


    //Table ajax code
    public function search_item(){
        $q=$this->input->get('q');
        $result=$this->sales->search_item($q);
        echo $result;
    }
    public function find_item_details(){
        $id=$this->input->post('id');
        
        $result=$this->sales->find_item_details($id);
        echo $result;
    }

    //sales invoice form
    public function invoice($id)
    {	
        if(!$this->permissions('sales_add') && !$this->permissions('sales_edit')){
            $this->show_access_denied_page();
        }
        $data=$this->data;
        $data=array_merge($data,array('sales_id'=>$id));
        $data['page_title']=$this->lang->line('sales_invoice');
        $this->load->view('sal-invoice',$data);
    }
    
    //Print sales invoice 
    public function print_invoice($sales_id)
    {
        if(!$this->permissions('sales_add') && !$this->permissions('sales_edit')){
            $this->show_access_denied_page();
        }
        $data=$this->data;
        $data=array_merge($data,array('sales_id'=>$sales_id));
        $data['page_title']=$this->lang->line('sales_invoice');
        if(get_invoice_format_id()==3){
            $this->load->view('print-sales-invoice-3',$data);
        }
        else if(get_invoice_format_id()==2){
            $this->load->view('print-sales-invoice-2',$data);
        }
        else{
            $this->load->view('print-sales-invoice',$data);
        }
    }

    //Print sales POS invoice 
    public function print_invoice_pos($sales_id)
    {
        if(!$this->permissions('sales_add') && !$this->permissions('sales_edit')){
            $this->show_access_denied_page();
        }
        $data=$this->data;
        $data=array_merge($data,array('sales_id'=>$sales_id));
        $data['page_title']=$this->lang->line('sales_invoice');
        $this->load->view('sal-invoice-pos',$data);
    }
    

    public function pdf($sales_id){
        if(!$this->permissions('sales_add') && !$this->permissions('sales_edit')){
            $this->show_access_denied_page();
        }
        $this->load->model('pdf_model');

        $data=$this->data;
        $data['page_title']=$this->lang->line('sales_invoice');
        $data=array_merge($data,array('sales_id'=>$sales_id));
        if(get_invoice_format_id()==3){
            $this->load->view('print-sales-invoice-3',$data);
        }
        else if(get_invoice_format_id()==2){
            $this->load->view('print-sales-invoice-2',$data);
        }
        else{
            $this->load->view('print-sales-invoice',$data);
        }

        // Get output html
        $html = $this->output->get_output();

        $this->pdf_model->render($html,'Sales Invoice - '.$sales_id);
    }
    
    

    
    /*v1.1*/
    public function return_row_with_data($rowcount,$item_id){
        echo $this->sales->get_items_info($rowcount,$item_id);
    }
    public function return_sales_list($sales_id){
        echo $this->sales->return_sales_list($sales_id);
    }
    public function delete_payment(){
        $this->permission_check_with_msg('sales_payment_delete');
        $payment_id = $this->input->post('payment_id');
        echo $this->sales->delete_payment($payment_id);
    }
    public function show_pay_now_modal(){
        $this->permission_check_with_msg('sales_view');
        $sales_id=$this->input->post('sales_id');
        echo $this->sales->show_pay_now_modal($sales_id);
    }
    public function save_payment(){
        $this->permission_check_with_msg('sales_add');
        echo $this->sales->save_payment();
    }
    public function view_payments_modal(){
        $this->permission_check_with_msg('sales_view');
        $sales_id=$this->input->post('sales_id');
        echo $this->sales->view_payments_modal($sales_id);
    }
}
