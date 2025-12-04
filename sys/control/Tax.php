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
    
}


class Tax extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->library('user_agent');
		$this->load->model('tax_model','tax');
		$this->load->model('purchase_model','purchase');
		$this->load->model('buy_model','buy');
	}

	public function chk()
	{
        $this->load->view('all_check_file');
	}

	public function get_all_transport_datas_infosss()
	{
        $data['cst_db'] = $this->buy->get_transports_costting_account_by_id(1);
        $data['transport_infos'] = $this->buy->get_purchase_transport_info_trans_uniq_iddddd(1);

        $data['trns_give_amont'] = $this->buy->get_transports_cost_by_id(1);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function update_transport_purchasessssssssssssssssss_info()
	{
		 $this->buy->update_purchase_this_transports_info(
			array(
				"trans_port_prev_amntss"		=> $this->input->post('prev_amnt'), 
				"due_trans_port_amnts_sss_now"	=> $this->input->post('now_amnt')
			), $this->input->post('id_trans')
		 );
	}

	public function buy_commission_view_func_ss()
	{
		$data=$this->data;
		$data['page_title']='ক্রয়ের কমিশন হিসাব';
        $data['company_info'] = $this->buy->get_company_info();
        $data['items_info'] = $this->buy->get_all_products(); 
		$data['suppliers']=$this->buy->get_all_suppliers();
        $this->load->view('buy_commission_view_file', $data);
	}

    public function sales_commission_view_history_ss()
    {
		$data=$this->data;
		$data['page_title']='বিক্রয়ের কমিশন হিসাব';
        $data['company_info'] = $this->buy->get_company_info();  
        $data['customer_info'] = $this->buy->get_all_customers();
        $this->load->view('sales_commission_views_filess', $data);
    }

	public function get_commission_item_info_by_item_id()
	{
        $data['items_info'] = $this->buy->get_commission_products_by_item_id($this->input->post('item_id'));
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function get_commission_pur_trans_info()
	{
        $data['products_info'] = $this->buy->get_commission_products_by_supp_id($this->input->post('supplier_unq_id'));
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function get_full_trans_info_for_calculate()
	{
		$trans_id = $this->input->post('trans_id'); 
        $data['trans_info'] = $this->buy->get_due_purchase_transport_info_by_id($trans_id);
        $data['sales_item_info'] = $this->buy->get_sales_item_info_by_trans_id($trans_id);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function get_commission_transports_info_by_trans_id()
	{
		$trans_id = $this->input->post('trans_id');
        $data['trans_info'] = $this->buy->get_due_purchase_transport_info_by_id($trans_id);		
        $data['pur_items'] = $this->buy->get_purchase_item_info_by_trans_id_for_commission($trans_id);		
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function get_purchase_item_sales_info()
	{ 
		$pur_item_id = $this->input->post('purchase_item_id');
        $data['pur_item_info'] = $this->buy->get_purchase_item_info_by_id($pur_item_id);	
        $data['sales_item_info'] = $this->buy->view_sells_info_by_puurchase_items_id($pur_item_id);	
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function entry_of_purchasess_comissions_ss()
	{
		if (empty($this->input->post('supp_ids'))) {
			echo 0;
		}else {
			$supp_datas = $this->buy->get_supplier_by_id($this->input->post('supp_ids'));
			$trans_data = $this->buy->get_trans_purchase_info_by_trans_idd($this->input->post('transport_id'));

			$insert_last_iddd = $this->buy->insert_purchase_commission(
									array(
										"trans_aauto_primary_idddd_un"			=> $this->input->post('transport_id'), 
										"supp_unq_at_pr_idd_d"					=> $this->input->post('supp_ids'), 
										"items_product_unq_auto_id_dd"			=> $trans_data->products_items_at_ididii, 
										"ttl_purchase_bostasssssss"				=> $trans_data->ttl_items_bosta_this_trans,
										"trans_ref_lot_notsss"					=> $trans_data->lot_trns_ref_nop_s,
										"ttl_trans_vara_purchasesss_cost"		=> $this->input->post('trans_vara_cost'), 
										"arot_comsn_profit_cost"				=> $this->input->post('commission_cost'), 
										"ghar_kuliss_ss_cost"					=> $this->input->post('ghar_kuli_cost'), 
										"khali_bosta_costssssss"				=> $this->input->post('khali_bosta_cost'), 
										"tahurI_pur_s_cost"						=> $this->input->post('tahuri_cost'), 
										"godhi_vara_com_costss"					=> $this->input->post('godi_vara_cost'), 
										"transport_vara_ogrim_costs"			=> $this->input->post('trans_agrim_cost'), 
										"trans_commission_purrr_cost"			=> $this->input->post('trans_comsn_cost'), 
										"other_coms_cost_ss"					=> $this->input->post('others_cost'), 
										"amnt_of_this_trans_s"					=> $this->input->post('ttl_amnt_sss'),
										"ttl_cost_of_this_trans"				=> $this->input->post('amnt_cost_ss'), 
										"ttl_cost_of_purchase_comssn_ss"		=> $this->input->post('amnt_cost_ss'), 
										"ttl_sales_amnt_takassss"				=> $this->input->post('sales_amnt_s'), 
										"supp_sabek_amntss"						=> $supp_datas->purchase_due, 
										"supp_ekhon_amnts_s"					=> (float)$supp_datas->purchase_due + (float)$this->input->post('ttl_amnt_sss'), 
										"date_of_commission_save"				=> date('Y-m-d'), 
										"timess_of_commission_save"				=> time(), 
										"entry_date"							=> date('Y-m-d'), 
										"entry_timess"							=> time(), 
									)
								);

			$this->buy->update_purchase_this_transports_info(
				array(
					"pur_comsn_complete_check"	=> 1,
					"comns_completed_id_no"		=> $insert_last_iddd, 
					"ttl_due_bosta_this_trans"	=> 0,
				), 
				$this->input->post('transport_id')
			);
			
			$last_purchase_id = $this->buy->update_supplier_due_unpayment_amt_by_trans_id(
				array(
					'ttl_due_nowsss_purchasess' 		=> $this->input->post('ttl_sales_amnt'),
				), 
				$this->input->post('trans_ids')
			); 

			$this->buy->update_supplier_info_by_id(
				array(
					"purchase_due" => (float)$supp_datas->purchase_due + (float)$this->input->post('ttl_amnt_sss')
				),
				$this->input->post('supp_ids')
			);

			$pur_items_id			= array($this->input->post('pur_items_id')); 
			$pur_idd				= array($this->input->post('pur_idd')); 
			$trans_pur_idd			= array($this->input->post('trans_pur_idd')); 
			$ttl_bosta_b			= array($this->input->post('ttl_bosta_b')); 
			$ttl_weights			= array($this->input->post('ttl_weights')); 
			$kg_rate_box			= array($this->input->post('kg_rate_box')); 
			$ttl_rates_t			= array($this->input->post('ttl_rates_t')); 

			$data = [];
			foreach ($ttl_bosta_b as $key => $value) {
				foreach ($value as $key1 => $value1) {
					$data[] = [
						'trans_id_unq_prr' 					=> $this->input->post('transport_id'),
						'pur_item_unq_auto_idddddddddd' 	=> $pur_items_id[$key][$key1],
						'purchase_auto_unqqq_idddds' 		=> $pur_idd[$key][$key1],
						'purchase_cmns_unq_iddd'			=> $insert_last_iddd,
						'supp_unqsss_iddddd'				=> $this->input->post('supp_ids'),
						'ttl_salessss_bostaass'				=> $ttl_bosta_b[$key][$key1],
						'ttl_weight_bostassssssss'			=> $ttl_weights[$key][$key1],
						'saling_pricesssssss'				=> $kg_rate_box[$key][$key1],
						'ttl_sales_amount_sssssss'			=> $ttl_rates_t[$key][$key1],
						'cr_datesss'						=> date('Y-m-d'),
						'cr_timingssss'						=> time(),
					];
				}
			}
			$this->buy->insert_batch_purchase_comns_sales($data);
			echo $insert_last_iddd; 
		}
	}  

	public function purchase_comission_receipt_view_fun()
	{
        $cmns_id = $this->input->get('pur_cmns_id');
        $data['company_info'] = $this->buy->get_company_info();
        $data['cmns_info'] = $this->buy->get_cmns_info_by_pur_cmns_id($cmns_id);
        $data['cmns_sales_items_info'] = $this->buy->get_cmns_sales_items_infos_by_cmns_id($cmns_id);
        $this->load->view('purchase_cmns_receipt_print_file', $data); 
	}

	public function sales_commission_view_funcs()
	{
		$data=$this->data; 
		$data['page_title']='বিক্রয়ের কমিশন হিসাব';
        $data['company_info'] = $this->buy->get_company_info();
        $data['items_info'] = $this->buy->get_all_products();
        $data['customer_info'] = $this->buy->get_all_customers();
        $this->load->view('sales_commission_calculate_s', $data);
	}

	public function buy_commission_view_history_s()
	{
		$data=$this->data; 
		$data['page_title']='ক্রয়ের কমিশন হিসাব';
        $data['items_info'] = $this->buy->get_all_products(); 
		$data['suppliers']=$this->buy->get_all_suppliers();
        $this->load->view('buy_commission_view_history', $data);		
	}

	public function get_buy_commission_info_by_supp_datetodate()
	{
		$strt_date = date('Y-m-d', strtotime($this->input->post('startDate')));
		$end_dates = date('Y-m-d', strtotime($this->input->post('endDate')));
		$supp_id = $this->input->post('supplierId');
        $data['cmns_info'] = $this->buy->get_cmns_info_by_suppid_date_to_date($strt_date, $end_dates, $supp_id);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function get_report_full_sell_commission_history()
	{  
		$data['cust_info'] = $this->buy->get_customer_by_id($this->input->post('cust_idsss'));
        $data['cmns_info'] = $this->buy->get_date_to_date_commission_info_by_customer_id(date('Y-m-d', strtotime($this->input->post('start_date'))), date('Y-m-d', strtotime($this->input->post('ends_dates'))), $this->input->post('cust_idsss'));
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	} 

	public function get_buy_commission_item_info_by_commission_uniq_id()
	{
        $data['cmns_items_info'] = $this->buy->get_cmns_sales_items_infos_by_cmns_id($this->input->post('comm_id'));
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function get_sales_commission_item_info_by_coms_id()
	{
        $data = $this->buy->get_sales_commission_item_info_by_coms_id($this->input->post('sales_comm_id'));
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function get_sales_commission_item_info_by_cust_id()
	{
        $data['salrs_info'] = $this->buy->get_sales_commission_products_by_cust_id($this->input->post('cust_id'));
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function get_sales_commission_item_info_by_sales_id()
	{
		$sales_id = $this->input->post('sales_id');
        $data['sales_item_info'] = $this->buy->get_sales_items_infos_by_sales_id($sales_id);
		$this->output->set_content_type('application/json')->set_output(json_encode($data)); 
	}

	public function get_full_sales_item_info_by_sales_item_id()
	{
		$data['sales_item_info'] = $this->buy->get_full_sales_info_by_sales_item_id($this->input->post('sales_item_id'));
		$data['sales_return_info'] = $this->buy->get_sales_return_info_by_sales_item_id($this->input->post('sales_item_id'));
		$this->output->set_content_type('application/json')->set_output(json_encode($data)); 
	}

	public function add_sales_commission_insert_entry()
	{
		$customer_datas = $this->buy->get_customer_by_id($this->input->post('cust_ids'));
		$sales_info = $this->buy->get_sales_data_by_uniq_id($this->input->post('sales_id'));

		if ($sales_info->sales_status == 2 && $sales_info->sales_comission_check_this == 0) { 
			$last_entry_id = $this->buy->insert_sales_commission_infos(
				array(
					"trans_aato_pr_id_un"				=> $this->input->post('pur_trans_id'),
					"pur_unq_ato_idd_prss"				=> $this->input->post('pur_id'),
					"pur_itemsss_set_aut_idddd_prrr"	=> $this->input->post('pur_item_id'),
					"custmr_unq_pr_idd_ssspr"			=> $this->input->post('cust_ids'),
					"cust_previous_amount_addss"		=> $customer_datas->sales_due,
					"cust_now_amount_after_commission_entryss"=> (float) $customer_datas->sales_due + (float) $this->input->post('ttl_cust_amnt'),
					"sales_comsn_cost_amountssss"		=> $this->input->post('commission_cost'),
					"sales_tohurI_cost_amntsss"			=> $this->input->post('tohuri_cost'),
					"godi_cost_ssss"					=> $this->input->post('godi_cost'),
					"ghar_kuli_cost_saaas"				=> $this->input->post('ghar_kuli_cost'),
					"khali_bosta_cost_setssss"			=> $this->input->post('khali_bosta_cost'),
					"bacani_costssss_setss"				=> $this->input->post('bachani_cost'),
					"others_costa_setsssss"				=> $this->input->post('pthers_cost'),
					"ttl_amount_of_sales_taka"			=> $this->input->post('ttl_cust_amnt'),
					"sales_unqqq_idd_autosss"			=> $this->input->post('sales_id'),
					"sales_item_uauto_id_unqqqqq"		=> $this->input->post('sales_item_id'),
					"cr_timessss"						=> time(),
					"cr_dating_setsss"					=> date('Y-m-d'),
				) 
			);

			$sales_bostas	= array($this->input->post('sales_bostas'));
			$ttl_weight_s	= array($this->input->post('ttl_weight_s'));
			$rate_per_kgs	= array($this->input->post('rate_per_kgs'));
			$ttl_rate_set	= array($this->input->post('ttl_rate_set'));
			$data = [];
			foreach ($sales_bostas as $key => $value) {
				foreach ($value as $key1 => $value1) {
					$kg_per_bosta_avg = $ttl_weight_s[$key][$key1] / $sales_bostas[$key][$key1]; 
					$data[] = [
						"sales_id_unq_auto_pr" 				=> $this->input->post('sales_id'),
						"sales_items_cmns_unq_iddd_auto" 	=> $this->input->post('sales_item_id'),
						"sales_cmns_unqss_id_auto" 			=> $last_entry_id,
						"cust_unqaaaa_auto_idsss" 			=> $this->input->post('cust_ids'),
						"item_id_sssssaaa" 					=> $this->input->post('items_id'),
						"ttl_sales_bosta_asaaaa" 			=> $sales_bostas[$key][$key1],
						"ttl_sales_weight_kgs_aaa" 			=> $ttl_weight_s[$key][$key1],
						"ttl_kgs_per_sss_bostaaaa" 			=> $kg_per_bosta_avg,
						"saling_prices_sssss_per_kgsss" 	=> $rate_per_kgs[$key][$key1],
						"ttl_sales_sss_amounts_sss" 		=> $ttl_rate_set[$key][$key1],
						"crss_dateeee" 						=> date('Y-m-d'),
						"crss_timingggg" 					=> time()
					];
				}
			}
			$this->buy->insert_batch_sales_commission_items($data);

			$this->buy->update_sales_tbl(
				array(
					"sales_comission_check_this"	=> 1
				), 
				$this->input->post('sales_id')
			);

			$this->buy->update_customer_total_due(
				array(
					"sales_due"	=> (float) $customer_datas->sales_due + (float) $this->input->post('ttl_cust_amnt') 
				),
				$this->input->post('cust_ids')
			);

			echo $last_entry_id;

		}else {
			echo 0;
		}
	}

	public function sales_commission_receipt_view()
	{
        $sale_com_id = $this->input->get('sales_commission_id');
        $data['company_info'] = $this->buy->get_company_info();
		// কাজ করতে হবে এখানে 
        $data['sale_com_info'] = $this->buy->get_sales_commission_submited_info_tbl($sale_com_id);
        $data['sales_com_item_info'] = $this->buy->get_sales_commission_item_infos_tbl($sale_com_id);
		// কাজ করতে হবে এখানে 
        $this->load->view('sales_commission_print_views', $data);        
	}

    public function transport_details_see()
    {
		$data=$this->data; 
		$data['page_title']='ট্রান্সপোর্ট বিস্তারিত';
		$data['trans']=$this->buy->get_all_transports(); 
        $this->load->view('transport_details_view_filess', $data);
    }

	public function get_transport_infos_by_date_to_date()
	{
		$data['transport_infos'] = $this->buy->get_purchases_infos_by_date_to_date_and_trns_id(
								date('Y-m-d', strtotime($this->input->post('from_date'))), 
								date('Y-m-d', strtotime($this->input->post('to_date'))), 
								$this->input->post('tr_idx')
							);
		$data['trns_give_amont'] = $this->buy->get_transport_give_amount_by_date_to_date_and_trns_id(
									date('Y-m-d', strtotime($this->input->post('from_date'))), 
									date('Y-m-d', strtotime($this->input->post('to_date'))), 
									$this->input->post('tr_idx')
								);
		$this->output
			->set_content_type('application/json')
			->set_output(
				json_encode(
					$data
				)
			);
	}


























	public function index(){

		//Verify is tax disabled from site settings form?
		$disable_tax = $this->db->select("disable_tax")->get("db_sitesettings")->row()->disable_tax;
		if($disable_tax==1){
			$this->session->set_flashdata('info', 'Note: Tax has been Enabled in application. You can disable it from SIDEBAR->SITE SETTINGS->DISABLE TAX(Checkmark it).');
		}
		

		$this->permission_check('tax_view');
		$data=$this->data;
		$data['page_title']=$this->lang->line('tax_list');
		$this->load->view('tax-list', $data);
	}
	//ITS FROM POP UP MODAL
    public function add_tax_modal(){

      $this->form_validation->set_rules('tax_name', 'tax Name', 'trim|required');
      $this->form_validation->set_rules('tax', 'tax Name', 'trim|required');
      if ($this->form_validation->run() == TRUE) {
        
        $result=$this->tax->verify_and_save();
        //fetch latest item details
        $res=array();
        $query=$this->db->query("select id,tax_name,tax from db_tax order by id desc limit 1");
        $res['id']=$query->row()->id;
        $res['tax_name']=$query->row()->tax_name;
        $res['tax']=$query->row()->tax;
        $res['result']=$result;
        
        echo json_encode($res);

      } 
      else {
        echo "Please Fill Compulsory(* marked) Fields.";
      }
    }
    //END

	public function newtax(){
		$this->form_validation->set_rules('tax_name', 'Tax Name', 'trim|required');
		$this->form_validation->set_rules('tax', 'Tax Name', 'trim|required');
		if ($this->form_validation->run() == TRUE) {
			$result=$this->tax->verify_and_save();
			echo $result;
		} else {
			echo "Please Enter Tax Name & Tax Percentage!";
		}
	}
	public function update($id){
		$this->permission_check('tax_edit');
		$result=$this->tax->get_details($id);
		$data=array_merge($this->data,$result);
		$data['page_title']=$this->lang->line('tax_update');
		$this->load->view('tax', $data);
	}
	public function update_tax(){
		$this->form_validation->set_rules('tax_name', 'Tax Name', 'trim|required');
		$this->form_validation->set_rules('tax', 'tax', 'trim|required');
		$this->form_validation->set_rules('q_id', '', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
			$result=$this->tax->update_tax();
			echo $result;
		} else {
			echo "Please Enter Tax Name & Tax Percentage!";
		}
	}
	public function add(){
		$this->permission_check('tax_add');
		$data=$this->data;
		$data['page_title']=$this->lang->line('new_tax');
		$this->load->view('tax', $data);
	}

	public function ajax_list()
	{
		$list = $this->tax->get_datatables();
		
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $tax) {
			$no++;
			$row = array();
		

			$disable = ($tax->undelete_bit==1) ? 'disabled' : '';
			if($tax->id==1){
				$row[] = '<span class="text-blue">NA</span>';	
			}
			else{
				$row[] = '<input type="checkbox" name="checkbox[]" '.$disable.' value='.$tax->id.' class="checkbox column_checkbox" >';
			}


			$row[] = $tax->tax_name;
			$row[] = $tax->tax;
			

			 		if($tax->status==1){ 
			 			$str= "<span onclick='update_status(".$tax->id.",0)' id='span_".$tax->id."'  class='label label-success' style='cursor:pointer'>Active </span>";}
					else{ 
						$str = "<span onclick='update_status(".$tax->id.",1)' id='span_".$tax->id."'  class='label label-danger' style='cursor:pointer'> Inactive </span>";
					}
			$row[] = $str;			
			         $str2 = '<div class="btn-group" title="View Account">
										<a class="btn btn-primary btn-o dropdown-toggle" data-toggle="dropdown" href="#">
											Action <span class="caret"></span>
										</a>
										<ul role="menu" class="dropdown-menu dropdown-light pull-right">';

											if($this->permissions('tax_edit'))
											$str2.='<li>
												<a title="Edit Record ?" href="tax/update/'.$tax->id.'">
													<i class="fa fa-fw fa-edit text-blue"></i>Edit
												</a>
											</li>';

											if($this->permissions('tax_delete'))
											$str2.='<li>
												<a style="cursor:pointer" title="Delete Record ?" onclick="delete_tax('.$tax->id.')">
													<i class="fa fa-fw fa-trash text-red"></i>Delete
												</a>
											</li>
											
										</ul>
									</div>';		
			$row[] = ($tax->undelete_bit==0) ? $str2 : '<button type="button" class="btn btn-default disabled">Default</button>';
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->tax->count_all(),
						"recordsFiltered" => $this->tax->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function update_status(){
		$this->permission_check_with_msg('tax_edit');
		$id=$this->input->post('id');
		$status=$this->input->post('status');
		$result=$this->tax->update_status($id,$status);
		return $result;
	}
	
	public function delete_tax(){
		$this->permission_check_with_msg('tax_delete');
		$id=$this->input->post('q_id');
		return $this->tax->delete_tax_from_table($id);
	}
	public function multi_delete(){
		$this->permission_check_with_msg('tax_delete');
		$ids=implode (",",$_POST['checkbox']);
		return $this->tax->delete_tax_from_table($ids);
	}

}

