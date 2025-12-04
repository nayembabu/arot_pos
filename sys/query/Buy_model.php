<?php  
defined('BASEPATH') OR exit('No direct script access allowed');

class Buy_model extends CI_Model { 

	public function __construct()
	{  
		parent::__construct();
        $this->load->database();  
	} 

	public function get_amanot_person_sms_query_by_date($date)
	{
		return $this->db
					->where('amanot_dates', $date)
					->join('db_amanot_person_data', 'db_amanot_person_data.amanot_person_info_iddd = db_amanot_added.id_person_unq', 'left')
					->get('db_amanot_added')
					->result();
	}

	public function get_staff_infos_data_by_id($id)
	{
        return $this->db
					->where('db_staff_info_id', $id)
                    ->get('db_staff_info')
                    ->row();
	}

	public function get_giving_amanot_query_by_date($date)
	{
		return $this->db
					->where('amanot_give_datess', $date)
					->join('db_amanot_person_data', 'db_amanot_person_data.amanot_person_info_iddd = db_amanot_givess.id_unq_person', 'left')
					->get('db_amanot_givess')
					->result();
	}

	public function update_staff_info_data_by_id($data, $id)
	{
		$this->db
			 ->where('db_staff_info_id', $id)
			 ->update('db_staff_info', $data);
	}

	public function get_haolat_info_by_cust_id_date_to_date($s, $e, $cust_id)
	{
		return $this->db
					->where('types_payable !=', null)
					->where('customer_unq_iddds', $cust_id)
					->where('due_sales_dates_times >=', $s)
					->where('due_sales_dates_times <=', $e)
					->get('db_customer_due_unpay_amounts')
					->result(); 
	}

	public function get_parchase_cust_by_cust_id_and_date_to_date($s, $e, $cust_id)
	{
		return $this->db
					->where('custmr_id_uniqs', $cust_id)
					->where('pur_date_timsssss >=', $s)
                    ->where('pur_date_timsssss <=', $e)
					->join('db_items', 'db_items.id = db_purchase_transports_info.products_items_at_ididii', 'left')
					->join('db_units', 'db_items.unit_id = db_units.id', 'left')
        			->get('db_purchase_transports_info')
        			->result(); 
	}

	public function get_commission_products_by_supp_id($supp_id)
	{
		return $this->db
					->where('pur_comsn_complete_check', 0)
					->where('pur_status_buy_change', 2)
					->where('sup_id_ass_iddd', $supp_id)
					->join('db_suppliers', 'db_suppliers.id = db_purchase_transports_info.sup_id_ass_iddd', 'left')
					->join('db_items', 'db_items.id = db_purchase_transports_info.products_items_at_ididii', 'left')
					->join('db_units', 'db_items.unit_id = db_units.id', 'left')
        			->get('db_purchase_transports_info')
        			->result(); 
	}

	public function get_purchase_transport_info_trans_uniq_iddddd($trns_id)
	{
        return $this->db
        			->where('transport_i_a_iiiiidd', $trns_id)
					->join('db_suppliers', 'db_suppliers.id = db_purchase_transports_info.sup_id_ass_iddd', 'left')
					->join('db_customers', 'db_customers.id = db_purchase_transports_info.custmr_id_uniqs', 'left')
        			->get('db_purchase_transports_info')
        			->result();
	}
	
	public function get_sales_return_info_by_sales_item_id($sales_item_id)
	{
		return $this->db
					->where('sales_items_unq_auto_iddd', $sales_item_id) 
					->get('db_salesitemsreturn')
					->result();  
	}

	public function get_full_sales_info_by_sales_item_id($sales_item_id)
	{
		return $this->db
					->select('a.id, a.sales_id, a.sales_status, a.item_id, a.pur_item_a_priddd, a.trans_uniq_primary_id, a.payment_datesss, a.sales_qnty_bostas, a.ttl_sale_kgs_this_product, a.price_per_kg, a.sales_kgs_perbosta, a.total_sales_price_cost_sss, a.purchase_per_kgs_price, b.sales_date, b.sales_lebar_cost_sss, b.sales_ghat_vara_cost, b.sales_ttl_dis_countss, c.customer_name, c.mobile, c.address, d.ref_lot_no, d.price_per_unit, d.pur_kg_per_bosta,e.item_image, e.item_name, f.unit_name')
					->where('a.id', $sales_item_id)
					->join('db_sales b', 'b.id = a.sales_id', 'left')
					->join('db_customers c', 'c.id = b.customer_id', 'left')
					->join('db_purchaseitems d', 'd.id = a.pur_item_a_priddd', 'left')
					->join('db_items e', 'e.id = d.item_id', 'left')
					->join('db_units f', 'f.id = e.unit_id', 'left')
					->get('db_salesitems a')
					->row();
	}

	public function get_sales_item_info_by_trans_idd($trans_id) 
	{
		return $this->db 
					->where('trans_uniq_primary_id', $trans_id)
					->join('db_sales', 'db_salesitems.sales_id = db_sales.id', 'left')
					->join('db_customers', 'db_sales.customer_id = db_customers.id', 'left')
					->join('db_purchaseitems', 'db_salesitems.pur_item_a_priddd = db_purchaseitems.id', 'left')
                    ->get('db_salesitems')
                    ->result();
	} 

    public function insert_new_staff_info($dt)
    {
        $this->db->insert('db_staff_info', $dt);
    }

    public function get_staff_infos_data()
    {
        return $this->db
                    ->get('db_staff_info')
                    ->result();
        
    } 

	public function view_sells_info_by_puurchase_items_id($ptid)
	{
		return $this->db
					->where('pur_item_a_priddd', $ptid) 
					->join('db_purchase_transports_info', 'db_purchase_transports_info.db_purchase_transports_info_a_idd = db_salesitems.trans_uniq_primary_id', 'left')
					->join('db_sales', 'db_sales.id = db_salesitems.sales_id', 'left')
					->join('db_customers', 'db_customers.id = db_sales.customer_id', 'left')
					->get('db_salesitems')
					->result();
	}

	public function get_all_purchase_item_info_by_trans_id($ptid)
	{
		return $this->db
					->select('a.ttl_purchase_kg_sss, a.id,a.purchase_id,a.purchase_status,a.item_id,a.purchase_trans_info_auto_pr_iddds,a.supplyer_id_a_pr,a.cust_auto_uniqss_id,a.ref_lot_no,a.purchase_item_dates,a.purchase_qty,a.price_per_unit,a.purchase_total_bosta,a.due_sells_bosta_ss,a.pur_kg_per_bosta,a.pur_total_price,a.total_due_payments,a.pur_prostabit_rate,a.pur_buying_types_statu,a.tax_id,a.tax_amt,a.tax_type,a.unit_discount_per,a.discount_amt,a.unit_total_cost,a.total_cost,a.profit_margin_per,a.unit_sales_price,a.status,a.description,a.discount_type,a.discount_input,b.item_name,c.unit_name,b.item_image')
					->where('a.purchase_trans_info_auto_pr_iddds', $ptid) 
					->join('db_items b', 'a.item_id = b.id', 'left')
					->join('db_units c', 'b.unit_id = c.id', 'left')
					->get('db_purchaseitems a')
					->result();
	}

	public function get_purchase_info_by_supp_date_to_date($sDate, $eDate, $supp_id)
	{
		return $this->db
					->where('sup_id_ass_iddd', $supp_id)
					->where('pur_date_timsssss >=', $sDate)
                    ->where('pur_date_timsssss <=', $eDate)
					->join('db_purchase_commission_submited', 'db_purchase_transports_info.db_purchase_transports_info_a_idd = db_purchase_commission_submited.trans_aauto_primary_idddd_un', 'left')
                    ->get('db_purchase_transports_info')
                    ->result(); 
	} 

	public function get_purchases_infos_by_date_to_date($sDate, $eDate)
	{
		return $this->db
					->where('pur_date_timsssss >=', $sDate)
                    ->where('pur_date_timsssss <=', $eDate)
					->join('db_purchase', 'db_purchase.pur_trans_info_auto_iddid = db_purchase_transports_info.db_purchase_transports_info_a_idd', 'left')
					->join('db_suppliers', 'db_suppliers.id = db_purchase_transports_info.sup_id_ass_iddd', 'left')
					->join('db_trans_port_profiles', 'db_trans_port_profiles.db_transport_id = db_purchase_transports_info.transport_i_a_iiiiidd', 'left')
					->join('db_items', 'db_items.id = db_purchase_transports_info.products_items_at_ididii', 'left')
					->join('db_units', 'db_items.unit_id = db_units.id', 'left')
                    ->get('db_purchase_transports_info')
                    ->result(); 
	} 

	public function get_purchases_infos_by_date_to_date_and_trns_id($sDate, $eDate, $trans_id)
	{
		return $this->db
					->where('pur_date_timsssss >=', $sDate)
                    ->where('pur_date_timsssss <=', $eDate)
					->where('transport_i_a_iiiiidd', $trans_id)
					->join('db_purchase', 'db_purchase.pur_trans_info_auto_iddid = db_purchase_transports_info.db_purchase_transports_info_a_idd', 'left')
					->join('db_suppliers', 'db_suppliers.id = db_purchase_transports_info.sup_id_ass_iddd', 'left')
					->join('db_trans_port_profiles', 'db_trans_port_profiles.db_transport_id = db_purchase_transports_info.transport_i_a_iiiiidd', 'left')
					->join('db_transport_cost_account', 'db_transport_cost_account.pruchase_trans__info_prr_idd = db_purchase_transports_info.db_purchase_transports_info_a_idd', 'left')
					->join('db_items', 'db_items.id = db_purchase_transports_info.products_items_at_ididii', 'left')
					->join('db_units', 'db_items.unit_id = db_units.id', 'left')
                    ->get('db_purchase_transports_info')
                    ->result(); 
	} 

	public function get_transport_give_amount_by_date_to_date_and_trns_id($sDate, $eDate, $trans_id)
	{
		return $this->db
					->where('db_transport_given_datess >=', $sDate)
					->where('db_transport_given_datess <=', $eDate)
					->where('db_transport_pr_unq_id', $trans_id)
					->get('db_transport_given_payments')
					->result();
	}

	public function get_trans_purchase_info_by_trans_idd($trans_id)
	{
		return $this->db
					->where('db_purchase_transports_info_a_idd', $trans_id)
					->join('db_customers', 'db_customers.id = db_purchase_transports_info.custmr_id_uniqs', 'left')
					->join('db_suppliers', 'db_suppliers.id = db_purchase_transports_info.sup_id_ass_iddd', 'left')
					->join('db_trans_port_profiles', 'db_trans_port_profiles.db_transport_id = db_purchase_transports_info.transport_i_a_iiiiidd', 'left')
					->join('db_items', 'db_items.id = db_purchase_transports_info.products_items_at_ididii', 'left')
					->join('db_units', 'db_items.unit_id = db_units.id', 'left')
                    ->get('db_purchase_transports_info')
                    ->row();  
	} 

	public function get_supplier_payments_date_to_date($suppID, $sDate, $edDate)
	{
		return $this->db
                    ->where('supplier_id', $suppID)
                    ->where('payment_date >=', $sDate)
                    ->where('payment_date <=', $edDate)
                    ->get('db_supplier_payments')
                    ->result(); 
	}

	public function get_customer_paid_amnt_by_cust_id_date_date($stDate, $endDate, $ccustID)
	{
		return $this->db 
                    ->where('customer_id', $ccustID)
                    ->where('payment_timing !=', null) 
                    ->where('payment_date >=', $stDate)
                    ->where('payment_date <=', $endDate)
                    ->get('db_customer_payments')
                    ->result(); 
	}

	public function insert_sales_commission_infos($datas)
	{
        $this->db->insert('db_sales_commission_submited_info', $datas);
        return $this->db->insert_id();
	}

	public function insert_batch_sales_commission_items($datas)
	{
        $this->db->insert_batch('db_sales_items_comns_entry_items_details_infos', $datas);
	}

	public function get_sales_commission_submited_info_tbl($id)
	{
		return $this->db
					->where('sales_commission_submited_info_iddd', $id)
					->join('db_customers', 'db_customers.id = db_sales_commission_submited_info.custmr_unq_pr_idd_ssspr', 'left')
					->join('db_purchase_transports_info', 'db_purchase_transports_info.db_purchase_transports_info_a_idd = db_sales_commission_submited_info.trans_aato_pr_id_un', 'left')
					->get('db_sales_commission_submited_info')
					->row();
	}

	public function get_sales_commission_item_infos_tbl($id)
	{
		return $this->db
					->where('sales_cmns_unqss_id_auto', $id)
					->join('db_salesitems', 'db_salesitems.id = db_sales_items_comns_entry_items_details_infos.sales_items_cmns_unq_iddd_auto', 'left')
					->join('db_purchaseitems', 'db_purchaseitems.id = db_salesitems.pur_item_a_priddd', 'left')
					->join('db_items', 'db_sales_items_comns_entry_items_details_infos.item_id_sssssaaa = db_items.id', 'left')
					->join('db_units', 'db_items.unit_id = db_units.id', 'left')
					->get('db_sales_items_comns_entry_items_details_infos')
					->result();
	}

	
 
	public function get_sales_info_by_cust_id_date_date($sDate, $eDate, $cust_id)
	{
		return $this->db
                    ->where('customer_id', $cust_id)
                    ->where('sales_date >=', $sDate)
                    ->where('sales_date <=', $eDate)
                    ->get('db_sales')
                    ->result(); 
	}

	public function get_company_info()
	{
		return $this->db
					->where('id', 1)
					->get('db_company')
					->row(); 
	}

	public function get_all_suppliers()
	{
		return $this->db->get('db_suppliers')->result();
	}

	public function insert_new_supplier($data)
	{
		return $this->db->insert('db_suppliers', $data);
	}

	public function get_all_products()
	{
		return $this->db
					->select('a.id,a.item_code,a.item_name,a.category_id,a.unit_id,a.price,a.status,a.stock,a.final_price,a.sales_price,b.unit_name,b.description,b.status,a.item_image')
					->join('db_units b', 'a.unit_id = b.id', 'left')
					->get('db_items a')
					->result();
	}   

	public function get_commission_products_by_item_id($item_id)
	{
		return $this->db
					->where('pur_comsn_complete_check', 0)
					->where('pur_status_buy_change', 2)
					->where('products_items_at_ididii', $item_id)
					->join('db_suppliers', 'db_suppliers.id = db_purchase_transports_info.sup_id_ass_iddd', 'left')
					->get('db_purchase_transports_info')
					->result();
	}  

	public function get_sales_commission_products_by_cust_id($cust_id)
	{
		return $this->db
					->where('sales_comission_check_this', 0)
					->where('sales_status', 2)
					->where('customer_id', $cust_id)
					// ->join('db_customers', 'db_customers.id = db_sales.customer_id', 'left')
					->get('db_sales')
					->result();
	}

	public function get_commission_products_by_item_supp_id($item_id, $supp_id)
	{
		$cond = array('products_items_at_ididii' => $item_id, 'sup_id_ass_iddd' => $supp_id, 'pur_comsn_complete_check' => 0, 'pur_status_buy_change' => 2);
		return $this->db
					->where($cond)
					->join('db_purchase', 'db_purchase.pur_trans_info_auto_iddid = db_purchase_transports_info.db_purchase_transports_info_a_idd', 'left')
					->get('db_purchase_transports_info')
					->result();
	}

	public function get_all_customers()
	{
		return $this->db->get('db_customers')->result();
	}  

	public function get_sales_due_info_by_sales_id($sales_id)
	{
		return $this->db
					->where('sales_id', $sales_id)
					->get('db_salespayments')
					->result(); 
	}

	public function get_sales_info_by_date_to_date($sdate, $edates)
	{
		return $this->db
					->select('b.imo_numbersss, b.whatsApp_number, b.customer_name, b.customer_code, b.mobile, b.address, b.sales_due, a.id, a.customer_id, a.grand_total, a.paid_amount, a.sales_date, a.sales_status, a.customer_id, a.ttl_sales_prices, a.sales_lebar_cost_sss, a.sales_ghat_vara_cost, a.sales_ttl_dis_countss, a.in_ttl_amounts_sales, a.sales_paid_able_amnt, a.cus_previous_amount_ttl, a.cus_ttl_due_s_now, a.subtotal, a.round_off, a.grand_total, a.payment_status, a.paid_amount, a.sales_carring_system_s, a.created_time, a.created_date')
					->where('sales_date >=', $sdate)
					->where('sales_date <=', $edates)
					->join('db_customers b', 'b.id = a.customer_id', 'left')
					->get('db_sales a')
					->result(); 
	}
 
	public function get_sales_info_by_sales_id($sales_id)
	{
		return $this->db 
					->select('b.customer_name, b.customer_code, b.mobile, b.address, b.sales_due, a.id, a.customer_id, a.grand_total, a.paid_amount, a.sales_date, a.sales_status, a.customer_id, a.ttl_sales_prices, a.sales_lebar_cost_sss, a.sales_ghat_vara_cost, a.sales_ttl_dis_countss, a.in_ttl_amounts_sales, a.sales_paid_able_amnt, a.cus_previous_amount_ttl, a.cus_ttl_due_s_now, a.subtotal, a.round_off, a.grand_total, a.ttl_sales_kgss, a.payment_status, a.paid_amount, a.sales_carring_system_s, c.customer_full_name, c.cus_mobile_noo, c.cus_address_fulls ')
					->where('a.id', $sales_id)
					->join('db_customers b', 'b.id = a.customer_id', 'left')
					->join('normal_customer_details_infoss c', 'c.sales_unq_autos_iiidd = a.id', 'left')
					->get('db_sales a')
					->row();
	}

	public function insert_sales_payments_func($arr)
	{
        $this->db->insert('db_salespayments', $arr);
        return $this->db->insert_id();
	}  

	public function insert_return_sales_items($arr)
	{
        $this->db->insert('db_salesitemsreturn', $arr);
        return $this->db->insert_id();
	}

	public function insert_customer_payments_func($arr)
	{ 
        $this->db->insert('db_customer_payments', $arr);
        return $this->db->insert_id();
	}  

	public function get_customer_payments_date_to_date_without_customerID($start_date, $end_date)
	{
		return $this->db
					// ->where('salespayment_id', null)
					->where('payment_timing !=', null)
					->where('payment_date >=', $start_date)
					->where('payment_date <=', $end_date)
					->join('db_customers', 'db_customers.id = db_customer_payments.customer_id', 'left')
					->get('db_customer_payments')
					->result();
	} 

	public function get_cust_buy_datess($start_date)
	{
		return $this->db
					->where('sup_id_ass_iddd', null)
					->where('pur_date_timsssss', $start_date)
					->join('db_customers', 'db_customers.id = db_purchase_transports_info.custmr_id_uniqs', 'left')
					->get('db_purchase_transports_info')
					->result();
	}

	public function get_customer_payments_date_date($start_date, $end_date, $id)
	{
		return $this->db
					->where('customer_id', $id)
					// ->where('payment_timing !=', null)
					->where('payment_date >=', $start_date)
					->where('payment_date <=', $end_date)
					->get('db_customer_payments')
					->result();
	}

	public function get_customer_payments_by_id($id)
	{
		return $this->db
					->where('a.id', $id)
					->join('db_customers b', 'a.customer_id = b.id', 'left')
					->get('db_customer_payments a')
					->row();
	}

	public function get_customer_due_payments_date_to_date($start_date, $end_date, $id)
	{
		return $this->db
					->where('customer_unq_iddds', $id)
					->where('due_sales_dates_times >=', $start_date)
					->where('due_sales_dates_times <=', $end_date)
					->get('db_customer_due_unpay_amounts')
					->result();
	}

	public function get_customer_sales_by_cus_id($cus_id)
	{
		return $this->db
					->select('a.id, b.item_name, a.reference_no, c.unit_name,b.item_image')
					->where('a.customer_id', $cus_id)
					->where('a.sell_payment_due !=', 0)
					->join('db_items b', 'b.id = a.item_product_auto_iddd', 'left')
					->join('db_units c', 'b.unit_id = c.id', 'left')
					->get('db_sales a')
					->result();
	}

	public function get_all_transports()
	{
		return $this->db->get('db_trans_port_profiles')->result();
	}

	public function get_transports_infos_by_id($id)
	{
		return $this->db
					->where('db_transport_id', $id)
					->get('db_trans_port_profiles')
					->row();
	}

	public function update_transport_info_by_trns_id($data, $id)
	{
		$this->db->where('db_transport_id', $id);
		$this->db->update('db_trans_port_profiles', $data);
	}

	public function get_transports_cost_by_id($trans_id)
	{
		return $this->db
					->where('db_transport_pr_unq_id', $trans_id)
					->get('db_transport_given_payments')
					->result();
	}

	public function insert_transport_duess($arr)
	{
        $this->db->insert('db_transport_given_payments', $arr);
        return $this->db->insert_id();
	}

	public function get_transports_costting_account_by_id($trans_id)
	{
		return $this->db
					->where('trans_auto_prr_idiiidd', $trans_id)
					->get('db_transport_cost_account')
					->result();
	}

	public function insert_tbl_purchase_datas($data)
	{
        $this->db->insert('db_purchase', $data);
        return $this->db->insert_id();
	}     

	public function insert_tbl_transport_cost_account($data)
	{
        $this->db->insert('db_transport_cost_account', $data);
        return $this->db->insert_id();
	} 

	public function insert_batch_purchase_item_all_datas($data)
	{
        $this->db->insert_batch('db_purchaseitems', $data);
	}

	public function insert_tbl_purchase_item_datas($data)
	{
        $this->db->insert('db_purchaseitems', $data);
        return $this->db->insert_id();
	}

	public function insert_amanot_person_info_data($dt)
	{
        $this->db->insert('db_amanot_person_data', $dt);
        return $this->db->insert_id();
	}

	public function insert_tbl_purchase_payments_datas($data)
	{
        $this->db->insert('db_purchasepayments', $data);
        return $this->db->insert_id();
	}  

	public function insert_tbl_supplyer_payments_datas($data)
	{
        $this->db->insert('db_supplier_payments', $data);
        return $this->db->insert_id();
	}  

	public function insert_tbl_purchase_costs_datas($data)
	{
        $this->db->insert('db_purchase_cost', $data);
        return $this->db->insert_id();
	}

	public function insert_amanot_taking_infos_data($data)
	{
        $this->db->insert('db_amanot_added', $data);
        return $this->db->insert_id();
	}

	public function insert_amanot_cutting_info_data_give($data)
	{
        $this->db->insert('db_amanot_givess', $data);
        return $this->db->insert_id();
	} 

	// 
	public function get_amanot_taking_data($id, $start_date, $end_date)
	{
		return $this->db
					->where('id_person_unq', $id)
					->where('amanot_dates >=', $start_date)
					->where('amanot_dates <=', $end_date)
					->get('db_amanot_added')
					->result();		
	}

	public function get_amanot_cutting_data_give($id, $start_date, $end_date)
	{
		return $this->db
					->where('id_unq_person', $id)
					->where('amanot_give_datess >=', $start_date)
					->where('amanot_give_datess <=', $end_date)
					->get('db_amanot_givess')
					->result();			
	}
	
	public function delete_taking_data_by_id($id)
	{
		$this->db->where('db_amanot_add_idd', $id);
		$this->db->delete('db_amanot_added');
	}

	public function delete_giving_infos_by_id($id)
	{
		$this->db->where('db_amanot_giving_id', $id);
		$this->db->delete('db_amanot_givess');
	}

	public function get_supplier_by_id($id)
	{
		return $this->db
					->where('id', $id)
					->get('db_suppliers')
					->row();
	}

	public function get_supplier_purchase_item_by_id($id)
	{
		return $this->db
					->select('b.item_name, b.item_code, a.id, a.ref_lot_no, a.pur_buying_types_statu, c.unit_name,b.item_image')
					->where('supplyer_id_a_pr', $id)
					->where('total_due_payments !=', 0)
					->join('db_items b', 'b.id = a.item_id', 'left')
					->join('db_units c', 'b.unit_id = c.id', 'left')
					->get('db_purchaseitems a')
					->result();
	}

	public function get_purchase_payments_data_infos($purchase_item_id)
	{
		return $this->db
					->where('purchase_item_s_id', $purchase_item_id)
					->get('db_purchasepayments')
					->result();
	}

	public function get_all_amanot_person_info()
	{
		return $this->db
					->get('db_amanot_person_data')
					->result();
	}

	public function get_amanot_person_info_by_id($id)
	{
		return $this->db
					->where('amanot_person_info_iddd', $id)
					->get('db_amanot_person_data')
					->row();
	}

	public function edit_amanot_person_info_data_by_idd($data, $id)
	{
		return $this->db
					->where('amanot_person_info_iddd', $id)
					->update('db_amanot_person_data', $data);
	}

	// amanot calculation  
	public function get_amanot_taking_amount_total($id)
	{
        return $this->db
					->select_sum('taking_amounts')
					->where('id_person_unq', $id)
					->get('db_amanot_added')
					->row()
					->taking_amounts;
	}

	public function get_ttl_cutting_amounts($id)
	{
        return $this->db
					->select_sum('giving_amnt')
					->where('id_unq_person', $id)
					->get('db_amanot_givess')
					->row()
					->giving_amnt;
	} 

	public function get_ttl_amanot_taking_amount_by_id_and_date($id, $s, $e)
	
	{
        return $this->db
					->select_sum('taking_amounts')
					->where('id_person_unq', $id)
        			->where('amanot_dates >=', $s) 
        			->where('amanot_dates <=', $e) 
					->get('db_amanot_added')
					->row()
					->taking_amounts;
	}

	public function get_ttl_amanot_cutting_amount_by_date_and_id($id, $s, $e)
	{
        return $this->db
					->select_sum('giving_amnt')
					->where('id_unq_person', $id)
        			->where('amanot_give_datess >=', $s) 
        			->where('amanot_give_datess <=', $e) 
					->get('db_amanot_givess')
					->row()
					->giving_amnt;
	} 
	// amanot calculation 

	public function get_supplier_payments_by_id($id)
	{
		return $this->db
					->select('a.purchasepayment_id, a.supplier_id, a.payment_date, a.payment, b.purchase_id, c.items_uniq_int_id, c.purchase_code, c.reference_no, c.purchase_date, c.grand_total, c.paid_amount ')
					->where('a.supplier_id', $id)
					->join('db_purchasepayments b', 'b.id = a.purchasepayment_id', 'left')
					->join('db_purchase c', 'a.supplier_id = c.supplier_id', 'left')
					->get('db_supplier_payments a')
					->result();
	}

	public function get_purchase_payments_by_purchase_item_id($purchase_item_id)
	{
		return $this->db
					->where('purchase_item_s_id', $purchase_item_id)
					->get('db_purchasepayments')
					->result();
	}

	public function get_purchase_item_by_id($id)
	{
		return $this->db
					->select('a.id,a.purchase_id,a.ttl_purchase_kg_sss,a.purchase_status,a.item_id,a.purchase_trans_info_auto_pr_iddds,a.supplyer_id_a_pr,a.cust_auto_uniqss_id,a.ref_lot_no,a.purchase_item_dates,a.purchase_qty,a.price_per_unit,a.purchase_total_bosta,a.due_sells_bosta_ss,a.pur_kg_per_bosta,a.pur_total_price,a.total_due_payments,a.pur_prostabit_rate,a.pur_buying_types_statu,a.tax_id,a.tax_amt,a.tax_type,a.unit_discount_per,a.discount_amt,a.unit_total_cost,a.total_cost,a.profit_margin_per,a.unit_sales_price,a.status,a.description,a.discount_type,a.discount_input, b.supplier_code,b.supplier_name,b.mobile,b.phone,b.address,b.purchase_due, c.items_uniq_int_id,c.purchase_code,c.reference_no,c.purchase_date,c.buying_type_status, d.item_code,d.item_name, e.unit_name, f.db_purchase_transports_info_a_idd,f.transport_i_a_iiiiidd,f.products_items_at_ididii,f.lot_trns_ref_nop_s,f.sup_id_ass_iddd,f.custmr_id_uniqs,f.pur_from_status,f.pur_date_timsssss,f.pur_status_buy_change,f.pur_comsn_complete_check,f.comns_completed_id_no,f.ttl_items_bosta_this_trans,f.ttl_due_bosta_this_trans,f.ttl_item_kg_trans,f.ttl_trans_other_cost,f.trans_com_per_bosta,f.ttl_trans_com,f.prodct_sell_bosta_in_road,f.trans_com_cutting_amnt,f.ttl_com_amnt_for_trans,f.ghar_kuli_rates_per_bosta,f.ttal_ghar_kuli_cost_amnt,f.ghar_kuli_cost_amnt_for_trans_with_cut,f.driver_advance_amnt_cost,f.supp_commis_items_wsss,f.others_cost_amnt_for_trans,f.total_trans_price,f.ttal_discount_amnt_trans,f.supp_paid_amnt_s,f.unpaid_amount_this_trans_tk,f.koifiyat_amount_tk_for_this_trans,f.kofiyat_desc_for_this_trans,f.now_timess,f.now_date_formate,d.item_image')
					->where('a.id', $id)
					->join('db_purchase_transports_info f', 'f.db_purchase_transports_info_a_idd = a.purchase_trans_info_auto_pr_iddds', 'left')
					->join('db_suppliers b', 'a.supplyer_id_a_pr = b.id', 'left')
					->join('db_purchase c', 'a.purchase_id = c.id', 'left')
					->join('db_items d', 'a.item_id = d.id', 'left')
					->join('db_units e', 'd.unit_id = e.id', 'left')
					->get('db_purchaseitems a')
					->row();
	} 

	public function get_sales_data_by_uniq_id($unq_id)
	{
		return $this->db
					->where('id', $unq_id)
					->get('db_sales')
					->row();
	}

	public function save_new_customer($datas)
	{
        $this->db->insert('db_customers', $datas);
        return $this->db->insert_id();
	}

	public function get_customer_by_id($id)
	{
		return $this->db
					->where('id', $id)
					->get('db_customers')
					->row();
	}

	public function get_this_product_info_by_id($id)
	{
		return $this->db
					->where('d.id', $id)
					->join('db_units e', 'd.unit_id = e.id', 'left')
					->get('db_items d')
					->row();
	}

	public function get_all_purchases_infos($product_id)
	{
		return $this->db
					->select('a.id, a.purchase_id, a.purchase_id, a.purchase_status, a.item_id, a.supplyer_id_a_pr, a.ref_lot_no, a.purchase_qty, a.price_per_unit, a.purchase_total_bosta, a.due_sells_bosta_ss, a.pur_kg_per_bosta, a.pur_total_price, a.pur_prostabit_rate, a.unit_total_cost, a.total_cost, a.profit_margin_per, a.unit_sales_price, a.status, b.buying_type_status, c.supplier_name, e.unit_name,d.item_image ')
					->where('a.item_id', $product_id)
					->where('a.due_sells_bosta_ss !=', 0)
					->join('db_purchase b', 'a.purchase_id = b.id', 'left')
					->join('db_suppliers c', 'a.supplyer_id_a_pr = c.id', 'left')
					->join('db_items d', 'a.item_id = d.id', 'left')
					->join('db_units e', 'd.unit_id = e.id', 'left')
					->get('db_purchaseitems a')
					->result();
	}

	public function get_purchase_item_info_by_id($id)
	{
		return $this->db
					->where('id', $id)
					->join('db_purchase_cost', 'db_purchase_cost.purchase_idd_autooo = db_purchaseitems.purchase_id', 'left')
					->get('db_purchaseitems')
					->row();
	}

	public function get_sell_info_by_purchase_id($purchase_id)
	{
		return $this->db
					->select('a.grand_total, a.id, a.sales_code, a.reference_no, a.item_product_auto_iddd, a.purchase_auto_pr_ids, a.sales_date, a.customer_id, a.sales_status, b.customer_code, b.customer_name, b.mobile, b.address')
					->where('a.purchase_auto_pr_ids', $purchase_id)
					->join('db_customers b', 'a.customer_id = b.id', 'left')
					->get('db_sales a')
					->result();
	}
	
	public function entry_s_new_sales($arry)
	{
        $this->db->insert('db_sales', $arry);
        return $this->db->insert_id();
	} 
	
	public function get_sales_items_infos_by_sales_id($sales_id)
	{
		return $this->db
					->select('a.id, a.sales_id, a.ttl_sale_kgs_this_product, a.sales_status, a.item_id, a.refs_lots_nosss, a.purchase_apr_ids, a.pur_item_a_priddd, a.trans_uniq_primary_id, a.description, a.payment_datesss, a.sales_qnty_bostas, a.price_per_kg, a.sales_kgs_perbosta, a.total_sales_price_cost_sss, a.purchase_per_kgs_price,b.db_purchase_transports_info_a_idd,b.transport_i_a_iiiiidd, b.products_items_at_ididii, b.lot_trns_ref_nop_s, b.sup_id_ass_iddd,b.custmr_id_uniqs,b.pur_from_status,b.pur_date_timsssss,b.pur_status_buy_change,b.ttl_items_bosta_this_trans,b.ttl_due_bosta_this_trans,b.ttl_item_kg_trans,b.ttl_trans_other_cost,b.trans_com_per_bosta,b.ttl_trans_com,b.prodct_sell_bosta_in_road,b.trans_com_cutting_amnt,b.ttl_com_amnt_for_trans,b.ghar_kuli_rates_per_bosta,b.ttal_ghar_kuli_cost_amnt,b.ghar_kuli_cost_amnt_for_trans_with_cut,b.driver_advance_amnt_cost,b.supp_commis_items_wsss,b.others_cost_amnt_for_trans,b.total_trans_price,b.ttal_discount_amnt_trans,b.supp_paid_amnt_s,b.unpaid_amount_this_trans_tk,b.koifiyat_amount_tk_for_this_trans,b.kofiyat_desc_for_this_trans,c.purchase_id,c.purchase_status,c.purchase_trans_info_auto_pr_iddds,c.supplyer_id_a_pr,c.cust_auto_uniqss_id,c.ref_lot_no,c.purchase_item_dates,c.purchase_qty,c.price_per_unit,c.purchase_total_bosta,c.due_sells_bosta_ss,c.pur_kg_per_bosta,c.pur_total_price,c.total_due_payments,c.pur_prostabit_rate,c.pur_buying_types_statu,c.unit_discount_per,c.discount_amt,c.unit_total_cost,c.total_cost,c.profit_margin_per,c.unit_sales_price,c.status,d.item_code, d.item_name, d.item_image, d.unit_id, e.unit_name ')
					->where('a.sales_id', $sales_id)
					->join('db_purchase_transports_info b', 'b.db_purchase_transports_info_a_idd = a.trans_uniq_primary_id', 'left')
					->join('db_purchaseitems c', 'c.id = a.pur_item_a_priddd', 'left')
					->join('db_items d', 'd.id = b.products_items_at_ididii', 'left')
					->join('db_units e', 'd.unit_id = e.id', 'left')
					->get('db_salesitems a')
					->result();	
	}

	public function get_sales_items_infos_by_sales_item_id($sales_item_id)
	{
		return $this->db
					->select('a.id, a.sales_id, a.sales_status, a.item_id, a.refs_lots_nosss, a.purchase_apr_ids, a.pur_item_a_priddd, a.trans_uniq_primary_id, a.description, a.payment_datesss, a.sales_qnty_bostas, a.price_per_kg, a.sales_kgs_perbosta, a.total_sales_price_cost_sss, a.purchase_per_kgs_price, b.customer_id, b.sales_status, b.ttl_sales_prices, b.sales_date, b.sales_lebar_cost_sss, b.sales_ghat_vara_cost, b.sales_ttl_dis_countss, b.in_ttl_amounts_sales, b.sales_paid_able_amnt, b.cus_previous_amount_ttl, b.cus_ttl_due_s_now, b.subtotal, b.grand_total, b.sales_carring_system_s, b.paid_amount')
					->where('a.id', $sales_item_id)
					->join('db_sales b', 'a.sales_id=b.id', 'left')
					->get('db_salesitems a')
					->row();	
	}

	public function update_sales_items_tbl($data, $id)
	{
		$this->db
			 ->where('id', $id)
			 ->update('db_salesitems', $data);
	}

	public function insert_batch_sales_item_all_datas($data)
	{
        $this->db->insert_batch('db_salesitems', $data);
	}  
	
	public function insert_supplier_paymentss($arry)
	{
        $this->db->insert('db_supplier_payments', $arry);
        return $this->db->insert_id();
	}
	
	public function insert_normal_customer_infoss($arry)
	{
        $this->db->insert('normal_customer_details_infoss', $arry);
        return $this->db->insert_id();
	}
	
	public function insert_expense_data($arry)
	{
        $this->db->insert('db_expense', $arry);
        return $this->db->insert_id();
	}
	
	public function insert_purchase_payments_func($data)
	{
        $this->db->insert('db_purchasepayments', $data);
        return $this->db->insert_id();
	}

	public function insert_sales_total_amount_s($data)
	{
        $this->db->insert('db_customer_due_unpay_amounts', $data);
        return $this->db->insert_id();
	}
	
	public function entry_sales_paymentss($arry)
	{
        $this->db->insert('db_salespayments', $arry);
        return $this->db->insert_id();
	}

	public function get_customer_by_cus_id($id)
	{
		return $this->db
					->where('id', $id)
					->get('db_customers')
					->row();
	}

	public function update_purchase_items_due($data, $id)
	{
		$this->db
			 ->where('id', $id)
			 ->update('db_purchaseitems', $data);
	}

	public function update_customer_total_due($data, $id)
	{
		$this->db
			 ->where('id', $id)
			 ->update('db_customers', $data);
	}

	public function update_sales_tbl($data, $id)
	{
		$this->db
			 ->where('id', $id)
			 ->update('db_sales', $data);
	}
	
	public function insert_income_payment($arry)
	{
        $this->db->insert('db_incomes', $arry);
        return $this->db->insert_id();
	}

	public function show_purchase_items_reports($s, $e, $item)
	{
		$this->db->select('a.purchase_code, a.items_uniq_int_id, a.purchase_date, a.supplier_id, a.buying_type_status, b.id, b.purchase_id, b.item_id, b.ref_lot_no, b.purchase_qty, b.price_per_unit, b.purchase_total_bosta, b.due_sells_bosta_ss, b.pur_kg_per_bosta, b.pur_total_price, b.total_due_payments, b.pur_prostabit_rate, b.total_cost, c.supplier_name, e.unit_name,d.item_image');
        $this->db->where('a.purchase_date >=', $s);
        $this->db->where('a.purchase_date <=', $e);
        $this->db->where('a.items_uniq_int_id', $item);
		$this->db->join('db_purchaseitems b', 'b.purchase_id = a.id', 'left');
		$this->db->join('db_suppliers c', 'c.id = a.supplier_id', 'left');
		$this->db->join('db_items d', 'a.items_uniq_int_id = d.id', 'left');
		$this->db->join('db_units e', 'd.unit_id = e.id', 'left');
        $query = $this->db->get('db_purchase a');
        return $query->result();
	}
 
	public function get_payment_from_customer($s, $e)
	{
        $this->db->where('payment_date >=', $s);
        $this->db->where('payment_date <=', $e);
        $query = $this->db->get('db_salespayments');
        return $query->result();
	}

	public function get_all_income_data()
	{
        return $this->db->get('db_incomes')->result();
	}

	public function get_all_expense_data()
	{
        return $this->db->get('db_expense')->result();
	}

	public function get_all_income_data_count()
	{
        return $this->db->select_sum('income_amount')
						->get('db_incomes')
						->row()->income_amount;
	}

	public function get_all_expense_data_count()
	{
        return $this->db->select_sum('expense_amt')
						->get('db_expense')
						->row()->expense_amt;
	}

	public function get_income_data_count($stdat, $enddate)
	{
        return $this->db->select_sum('income_amount')
						->where('income_date >=', $stdat)
						->where('income_date <=', $enddate)
						->get('db_incomes')
						->row()->income_amount;
	}

	public function get_expense_data_count($stdat, $enddate)
	{
        return $this->db->select_sum('expense_amt')
						->where('expense_date >=', $stdat)
						->where('expense_date <=', $enddate)
						->get('db_expense')
						->row()->expense_amt;
	}

	public function get_ohers_income($s, $e)
	{
        $this->db->where('income_date >=', $s);
        $this->db->where('income_date <=', $e);
        $query = $this->db->get('db_incomes');
        return $query->result();
	}

	public function expense_other_perpose($s, $e)
	{
        $this->db->where('expense_date >=', $s);
        $this->db->where('expense_date <=', $e);
        $query = $this->db->get('db_expense');
        return $query->result();
	}

	public function cost_pay_to_supplier($s, $e)
	{
        $this->db->where('payment_date >=', $s);
        $this->db->where('payment_date <=', $e);
        $query = $this->db->get('db_purchasepayments');
        return $query->result();
	}

	public function get_purchase_cost_by_purchase_id($purchase_id)
	{
        $this->db->where('purchase_idd_autooo', $purchase_id);
        $query = $this->db->get('db_purchase_cost');
        return $query->row();		
	}

	public function get_sell_history_by_purchase_item_id($purchase_id)
	{
        $this->db->where('purchase_item_ap_ids', $purchase_id);
		$this->db->join('db_customers', 'db_customers.id = db_sales.customer_id', 'left');
        $query = $this->db->get('db_sales');
        return $query->result();
	}

	public function get_purchase_payments_by_purchase_id($purchase_id)
	{
        $this->db->where('purchase_id', $purchase_id);
        $query = $this->db->get('db_purchasepayments');
        return $query->result();
	}

	public function get_purchase_item_by_date_to_date($s, $e, $supplier_id)
	{
        $this->db->where('purchase_item_dates >=', $s);
        $this->db->where('purchase_item_dates <=', $e);
        $this->db->where('supplyer_id_a_pr', $supplier_id);
		$this->db->join('db_items', 'db_purchaseitems.item_id = db_items.id', 'left');
		$this->db->join('db_units', 'db_items.unit_id = db_units.id', 'left');
        $query = $this->db->get('db_purchaseitems');
        return $query->result();
	}

	public function update_item_by_id($data, $id)
	{
		$this->db->where('id', $id);
		$this->db->update('db_items', $data);
	}

	public function get_all_units()
	{
		$this->db->where('status !=', 0);
        $query = $this->db->get('db_units');
        return $query->result();
	}

	public function add_new_transport_profiles($data)
	{
		$this->db->insert('db_trans_port_profiles', $data);
	} 
	
	public function insert_purchase_this_transports_info($arry)
	{
        $this->db->insert('db_purchase_transports_info', $arry);
        return $this->db->insert_id();
	}

	public function insert_supplier_due_payment_amt($data)
	{
		$this->db->insert('db_supplier_due_unpayment', $data);
	} 

	public function update_supplier_due_unpayment_amt_by_trans_id($arry, $trans_id)
	{
        $this->db
				->where('purchase_transport_infos_iddis', $trans_id)
				->update('db_supplier_due_unpayment', $arry);
	}

	public function get_purchase_transport_info_by_date($dates)
	{
        return $this->db
					->where('ttl_due_bosta_this_trans !=', 0)
        			->where('pur_date_timsssss', $dates)
					->join('db_suppliers', 'db_suppliers.id = db_purchase_transports_info.sup_id_ass_iddd', 'left')
					->join('db_customers', 'db_customers.id = db_purchase_transports_info.custmr_id_uniqs', 'left')
        			->get('db_purchase_transports_info')
        			->result();
	}
	
	public function get_purchase_transport_info_by_date_for_sales_rasta($dates)
	{
        return $this->db
					->where('prodct_sell_bosta_in_road !=', 0)
        			->where('pur_date_timsssss', $dates)
					->join('db_suppliers', 'db_suppliers.id = db_purchase_transports_info.sup_id_ass_iddd', 'left')
					->join('db_customers', 'db_customers.id = db_purchase_transports_info.custmr_id_uniqs', 'left')
        			->get('db_purchase_transports_info')
        			->result();
	}
 
	public function get_due_purchase_transport_info_by_item_id($item_id)
	{
        return $this->db
					->where('ttl_due_bosta_this_trans !=', 0)
        			->where('products_items_at_ididii', $item_id)
					->join('db_suppliers', 'db_suppliers.id = db_purchase_transports_info.sup_id_ass_iddd', 'left')
					->join('db_customers', 'db_customers.id = db_purchase_transports_info.custmr_id_uniqs', 'left')
        			->get('db_purchase_transports_info')
        			->result();
	}

	public function get_due_purchase_transport_info_by_id($id)
	{
        return $this->db
					->where('db_purchase_transports_info_a_idd', $id)
					->join('db_suppliers', 'db_suppliers.id = db_purchase_transports_info.sup_id_ass_iddd', 'left')
					->join('db_trans_port_profiles', 'db_trans_port_profiles.db_transport_id = db_purchase_transports_info.transport_i_a_iiiiidd', 'left')
					->join('db_items', 'db_items.id = db_purchase_transports_info.products_items_at_ididii', 'left')
					->join('db_units', 'db_items.unit_id = db_units.id', 'left')
					->get('db_purchase_transports_info')
        			->row();
	}
	
	public function update_purchase_this_transports_info($arry, $id)
	{
        $this->db
				->where('db_purchase_transports_info_a_idd', $id)
				->update('db_purchase_transports_info', $arry);
	}

	public function get_purchase_info_by_trans_id($trans_id)
	{
		return $this->db
					->where('pur_trans_info_auto_iddid', $trans_id)
					->get('db_purchase')
					->row();		
	} 

	public function get_purchase_cost_by_trans_id($trans_id)
	{
		return $this->db
					->where('purchase_transportss_info_a_pr_iddd', $trans_id)
					->get('db_purchase_cost')
					->row();		
	} 

	public function get_all_purchase_item_info()
	{
		return $this->db
        			->where('a.due_sells_bosta_ss !=', 0)
					->join('db_items b', 'a.item_id = b.id', 'left')
					->join('db_units c', 'b.unit_id = c.id', 'left')
					->join('db_suppliers d', 'd.id = a.supplyer_id_a_pr', 'left')
					->get('db_purchaseitems a')
					->result();
	}

	public function get_purchase_item_info_by_trans_id_for_commission($ptid)
	{
		return $this->db
					->select('a.id, a.purchase_id, a.purchase_status, a.item_id, a.purchase_trans_info_auto_pr_iddds, a.supplyer_id_a_pr, a.ref_lot_no, a.purchase_item_dates, a.purchase_qty, a.price_per_unit, a.purchase_total_bosta, a.due_sells_bosta_ss, a.pur_kg_per_bosta, a.pur_total_price, a.total_due_payments, a.pur_prostabit_rate, a.pur_buying_types_statu, a.unit_discount_per, a.discount_amt, a.unit_total_cost, a.total_cost, a.profit_margin_per, a.unit_sales_price, b.item_name, b.category_id, c.unit_name, c.description,b.item_image ')
					->where('a.purchase_trans_info_auto_pr_iddds', $ptid) 
					->join('db_items b', 'a.item_id = b.id', 'left')
					->join('db_units c', 'b.unit_id = c.id', 'left')
					->get('db_purchaseitems a')
					->result();
	}

	public function get_purchase_item_info_by_trans_id($ptid)
	{
		return $this->db
					->select('a.id, a.purchase_id, a.purchase_status, a.item_id, a.purchase_trans_info_auto_pr_iddds, a.supplyer_id_a_pr, a.ref_lot_no, a.purchase_item_dates, a.purchase_qty, a.price_per_unit, a.purchase_total_bosta, a.due_sells_bosta_ss, a.pur_kg_per_bosta, a.pur_total_price, a.total_due_payments, a.pur_prostabit_rate, a.pur_buying_types_statu, a.unit_discount_per, a.discount_amt, a.unit_total_cost, a.total_cost, a.profit_margin_per, a.unit_sales_price, b.item_name, b.category_id, c.unit_name, c.description,b.item_image ')
        			->where('a.due_sells_bosta_ss !=', 0)
					->where('a.purchase_trans_info_auto_pr_iddds', $ptid) 
					->join('db_items b', 'a.item_id = b.id', 'left')
					->join('db_units c', 'b.unit_id = c.id', 'left')
					->get('db_purchaseitems a')
					->result();
	}

	public function get_sales_infos_date_to_date($sdate, $enddt, $c_id)
	{
		return $this->db
					->where('sales_date >=', $sdate)
					->where('sales_date <=', $enddt)
					->where('customer_id', $c_id)
					->get('db_sales')
					->result();
	}

	public function update_supplier_info_by_id($arry, $id)
	{
        $this->db
				->where('id', $id)
				->update('db_suppliers', $arry);
	}

	public function get_sales_item_info_by_trans_id($trans_id)
	{
		return $this->db
					->where('trans_uniq_primary_id', $trans_id)
					->get('db_salesitems')
					->result();
	}

	public function insert_purchase_commission($data)
	{
		$this->db->insert('db_purchase_commission_submited', $data);
        return $this->db->insert_id(); 
	} 

	public function purchase_stock_out_by_trans_id($arry, $trans_id)
	{
        $this->db
				->where('purchase_trans_info_auto_pr_iddds', $trans_id)
				->update('db_purchaseitems', $arry);
	}

	public function insert_batch_purchase_comns_sales($data)
	{
        $this->db->insert_batch('db_purchase_comns_entry_sales_infos', $data);
	}

	public function get_cmns_info_by_suppid_date_to_date($s, $e, $id)
	{
		return $this->db
					->order_by('db_purchase_commission_submited_pr_iddd', 'asc')
        			->where('date_of_commission_save >=', $s)
        			->where('date_of_commission_save <=', $e)
        			->where('supp_unq_at_pr_idd_d', $id)
					->join('db_suppliers', 'db_suppliers.id = db_purchase_commission_submited.supp_unq_at_pr_idd_d', 'left')
					->join('db_purchase_transports_info', 'db_purchase_transports_info.db_purchase_transports_info_a_idd = db_purchase_commission_submited.trans_aauto_primary_idddd_un', 'left')
					->join('db_items', 'db_items.id = db_purchase_commission_submited.items_product_unq_auto_id_dd', 'left')
					->join('db_units', 'db_items.unit_id = db_units.id', 'left')
					->get('db_purchase_commission_submited')
					->result();
	}

	public function get_date_to_date_commission_info_by_customer_id($s, $e, $id)
	{
		return $this->db
					->order_by('sales_commission_submited_info_iddd', 'asc')
        			->where('cr_dating_setsss >=', $s)
        			->where('cr_dating_setsss <=', $e)
        			->where('custmr_unq_pr_idd_ssspr', $id)
					->join('db_sales', 'db_sales.id = db_sales_commission_submited_info.sales_unqqq_idd_autosss', 'left')
					->join('db_customers', 'db_customers.id = db_sales_commission_submited_info.custmr_unq_pr_idd_ssspr', 'left')
					->get('db_sales_commission_submited_info')
					->result();
	}  

	public function get_sales_commission_item_info_by_coms_id($cmns_id)
	{
		return $this->db
					->where('sales_cmns_unqss_id_auto', $cmns_id)
					->join('db_sales', 'db_sales.id = db_sales_items_comns_entry_items_details_infos.sales_id_unq_auto_pr', 'left')
					->join('db_salesitems', 'db_salesitems.id = db_sales_items_comns_entry_items_details_infos.sales_items_cmns_unq_iddd_auto', 'left') 
					->join('db_purchaseitems', 'db_purchaseitems.id = db_salesitems.pur_item_a_priddd', 'left') 
					->join('db_customers', 'db_customers.id = db_sales_items_comns_entry_items_details_infos.cust_unqaaaa_auto_idsss', 'left')
					->join('db_items', 'db_items.id = db_sales_items_comns_entry_items_details_infos.item_id_sssssaaa', 'left')
					->join('db_units', 'db_items.unit_id = db_units.id', 'left')
					->get('db_sales_items_comns_entry_items_details_infos')
					->row(); 
	}
    
	public function get_sales_commission_item_info_by_coms_idss($cmns_id)
	{
		return $this->db
					->where('sales_cmns_unqss_id_auto', $cmns_id)
					->join('db_sales', 'db_sales.id = db_sales_items_comns_entry_items_details_infos.sales_id_unq_auto_pr', 'left')
					->join('db_salesitems', 'db_salesitems.id = db_sales_items_comns_entry_items_details_infos.sales_items_cmns_unq_iddd_auto', 'left') 
					->join('db_purchaseitems', 'db_purchaseitems.id = db_salesitems.pur_item_a_priddd', 'left') 
					->join('db_customers', 'db_customers.id = db_sales_items_comns_entry_items_details_infos.cust_unqaaaa_auto_idsss', 'left')
					->join('db_items', 'db_items.id = db_sales_items_comns_entry_items_details_infos.item_id_sssssaaa', 'left')
					->join('db_units', 'db_items.unit_id = db_units.id', 'left')
					->get('db_sales_items_comns_entry_items_details_infos')
					->result(); 
	}


	public function get_cmns_info_by_pur_cmns_id($cmns_id)
	{
		return $this->db
					->where('db_purchase_commission_submited_pr_iddd', $cmns_id)
					->join('db_suppliers', 'db_suppliers.id = db_purchase_commission_submited.supp_unq_at_pr_idd_d', 'left')
					->join('db_purchase_transports_info', 'db_purchase_transports_info.db_purchase_transports_info_a_idd = db_purchase_commission_submited.trans_aauto_primary_idddd_un', 'left')
					->join('db_items', 'db_items.id = db_purchase_commission_submited.items_product_unq_auto_id_dd', 'left')
					->join('db_units', 'db_items.unit_id = db_units.id', 'left')
					->get('db_purchase_commission_submited')
					->row();
	} 

	public function get_cmns_sales_items_infos_by_cmns_id($cmns_id)
	{
		return $this->db
					->where('purchase_cmns_unq_iddd', $cmns_id)
					->get('db_purchase_comns_entry_sales_infos')
					->result();
	}

	public function get_check_uniq_id_entry($uniq, $colm, $dbn)
	{
		return $this->db
					->where($colm, $uniq)
					->get($dbn)
					->row();
	}





}