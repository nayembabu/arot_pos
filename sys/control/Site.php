<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends MY_Controller {
    public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->model('site_model');
		$this->load->model('buy_model','buy');
	}
	public function index(){
		$this->permission_check('site_edit');
        $data=$this->site_model->get_details();
        $data['page_title']=$this->lang->line('site_settings');
		$this->load->view('site-settings', $data);
	}

	public function update_site(){
		$this->form_validation->set_rules('site_name', 'Site Name', 'trim|required');
		if ($this->form_validation->run() == TRUE) {
			$result=$this->site_model->update_site();
			echo $result;
		} else {
			echo "Please Enter Compulsary(* marked) fields!";
		}
	}
	public function langauge($id){
		$this->load->model('language_model');
        $this->language_model->set($id);
        redirect($_SERVER['HTTP_REFERER']);
	}

    public function transport_calculate()
    {
        $cost = $this->buy->get_purchase_transport_info_trans_uniq_iddddd(1);
        $pay = $this->buy->get_transports_cost_by_id(1);

        $tc = 0;
        $tcom = 0;
        $p = 0;
        foreach ($pay as $b) {
            $p += $b->db_transport_payment_amount;
        }

        foreach ($cost as $a) { 
            $tc += $a->ttl_trans_other_cost;
            $tcom += $a->ttl_com_amnt_for_trans;
        }
        
        // echo "<pre>";
        // print_r ($cost);
        // echo "</pre>";
        echo 'ভাড়া '. $tc . ' কমিশন '. $tcom. ' মোট '. ($tc + $tcom). ' <br>';
        echo 'পেমেন্ট '. $p . ' মোট '. ($tc + $tcom - $p). '<br>';
        echo 'বাকি '. ($tc + $tcom - $p). '<br>';

        /*
        [lot_trns_ref_nop_s] => পেয়াজ-izfb
            [sup_id_ass_iddd] => 9
            [custmr_id_uniqs] => 
            [pur_from_status] => 
            [pur_date_timsssss] => 2025-01-27
            [pur_status_buy_change] => 1
            [pur_comsn_complete_check] => 0
            [comns_completed_id_no] => 0
            [ttl_items_bosta_this_trans] => 22
            [ttl_due_bosta_this_trans] => 0
            [ttl_item_kg_trans] => 1518
            [ttl_trans_other_cost] => 3080
            [trans_com_per_bosta] => 8
            [ttl_trans_com] => 176
            [prodct_sell_bosta_in_road] => 
            [trans_com_cutting_amnt] => 0
            [ttl_com_amnt_for_trans] => 176
            [ghar_kuli_rates_per_bosta] => 10
            [ttal_ghar_kuli_cost_amnt] => 220
            [ghar_kuli_cost_amnt_for_trans_with_cut] => 220
            [driver_advance_amnt_cost] => 
            [supp_commis_items_wsss] => 
            [others_cost_amnt_for_trans] => 
            [total_trans_price] => 54879.495
            [ttal_discount_amnt_trans] => 0
            [supp_paid_amnt_s] => 
            [supp_pre_amtssss] => 0.00
            [supp_now_due_amnt_ssssss] => 0
            [unpaid_amount_this_trans_tk] => 54879
            [koifiyat_amount_tk_for_this_trans] => .495
            [kofiyat_desc_for_this_trans] => 
            [trans_port_prev_amntss] => 
            [due_trans_port_amnts_sss_now] => 
            [now_timess] => 1737955940
            [now_date_formate] => 2025-01-27
            [check_uniq_id] => 679719db0abc3
            [id] => 
            [supplier_code] => SP0009
            [supplier_name] => জামিরুল
            [mobile] => 
            [phone] => 
            [email] => 
            [gstin] => 
            [tax_number] => 
            [vatin] => 
            [opening_balance] => 
            [purchase_due] => 774153.00
            [purchase_return_due] => 
            [country_id] => 
            [state_id] => 
            [city] => 
            [postcode] => 
            [address] => 
            [system_ip] => 
            [system_name] => 
            [created_date] => 
            [created_time] => 
            [created_by] => 
            [company_id] => 
            [status] => 
            [customer_code] => 
            [customer_name] => 
            [whatsApp_number] => 
            [imo_numbersss] => 
            [sales_due] => 
            [sales_return_due] => 
        */

        echo '<table border="1" cellpadding="10" cellspacing="0">';
        foreach ($cost as $k) { 
            echo    `<tr>
                        <td>$k->driver_advance_amnt_cost</td>
                    </tr>`;
        }
        echo '</table>';


        
    }
}
