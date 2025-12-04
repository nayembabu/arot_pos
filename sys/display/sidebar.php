<style>
    a {
        color: #fff; 
    }
</style>

    <!-- Change the theme color if it is set -->
    <script type="text/javascript">
        if(theme_skin!='skin-blue'){
            $("body").addClass(theme_skin);
            $("body").removeClass('skin-blue');
        }
        if(sidebar_collapse=='true'){
            $("body").addClass('sidebar-collapse');
        }
    </script> 
    <!-- end --> 

<?php $CI =& get_instance(); ?>
<header class="main-header">
    <!-- Logo -->
    <a href="<?php echo $base_url; ?>dashboard" class="logo">
      <span class="logo-mini"><b>আয়েতুল্লাহ</b></span>
      <span class="logo-lg"><b>আয়েতুল্লাহ</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" style="background-color:rgb(2, 12, 25);" >
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu"> 
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu " style="margin-right: 40px; ">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo get_profile_picture(); ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php print ucfirst($this->session->userdata('inv_username')); ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo get_profile_picture(); ?>" class="img-circle" alt="User Image"> 
                <p>
                 <?php print ucfirst($this->session->userdata('inv_username')); ?>
                  <small>Year <?=date("Y");?></small>
                </p>
              </li> 
              <!-- Menu Body -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo $base_url; ?>users/edit/<?= $this->session->userdata('inv_userid'); ?>" class="btn btn-default btn-flat"><?= $this->lang->line('profile'); ?></a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo $base_url; ?>logout" class="btn btn-default btn-flat"><?= $this->lang->line('logout'); ?></a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar" style="background-color:rgb(2, 12, 25);" >
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo get_profile_picture(); ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php print ucfirst($this->session->userdata('inv_username'));
          ?><i class="fa fa-fw fa-check-circle text-aqua"></i></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <!--<li class="header">MAIN NAVIGATION</li>-->
        <li class="dashboard-active-li ">
            <a href="<?php echo $base_url; ?>dashboard">
                <i class="fa fa-dashboard text-aqua"></i> 
                <span><?= $this->lang->line('dashboard'); ?></span>
            </a>
        </li>


        <!-- SMS 
        <li class="sms-active-li sms-api-active-li sms-template-active-li sms-templates-list-active-li treeview">
          <a href="#">
            <i class="fa fa-envelope text-aqua"></i> <span><?= $this->lang->line('sms'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="sms-active-li"><a href="<?php echo $base_url; ?>sms"><i class="fa fa-envelope-o "></i> <span><?= $this->lang->line('send_sms'); ?></span></a></li>
            
            <li class="sms-templates-list-active-li sms-template-active-li"><a href="<?php echo $base_url; ?>templates/sms"><i class="fa fa-list "></i> <span><?= $this->lang->line('sms_templates'); ?></span></a></li>
            
            <li class="sms-api-active-li"><a href="<?php echo $base_url; ?>sms/api"><i class="fa fa-cube "></i> <span><?= $this->lang->line('sms_api'); ?></span></a></li>
            
          </ul>
        </li>
        -->
		<!--<li class="header">SETTINGS</li>
		    <li class=" company-profile-active-li site-settings-active-li  change-pass-active-li dbbackup-active-li warehouse-active-li warehouse-list-active-li tax-active-li currency-view-active-li currency-active-li  database_updater-active-li tax-list-active-li units-list-active-li unit-active-li payment_types_list-active-li payment_types-active-li treeview">
          <a href="#">
            <i class="fa fa-gears text-aqua"></i> <span><?= $this->lang->line('settings'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="company-profile-active-li"><a href="<?php echo $base_url; ?>company"><i class="fa fa-suitcase "></i> <span><?= $this->lang->line('company_profile'); ?></span></a></li>
            
            <li class="site-settings-active-li"><a href="<?php echo $base_url; ?>site"><i class="fa fa-shield  "></i> <span><?= $this->lang->line('site_settings'); ?></span></a></li>
            
            <li class="tax-active-li  tax-list-active-li"><a href="<?php echo $base_url; ?>tax"><i class="fa fa-percent  "></i> <span><?= $this->lang->line('tax_list'); ?></span></a></li>
            
            <li class="units-list-active-li unit-active-li"><a href="<?php echo $base_url; ?>units/"><i class="fa fa-list "></i> <span><?= $this->lang->line('units_list'); ?></span></a></li>
            
            <li class="payment_types_list-active-li payment_types-active-li"><a href="<?php echo $base_url; ?>payment_types/"><i class="fa fa-list "></i> <span><?= $this->lang->line('payment_types_list'); ?></span></a></li>
            
            <li class="currency-view-active-li currency-active-li"><a href="<?php echo $base_url; ?>currency/view"><i class="fa fa-gg "></i> <span><?= $this->lang->line('currency_list'); ?></span></a></li>
            
            <li class="change-pass-active-li"><a href="<?php echo $base_url; ?>users/password_reset"><i class="fa fa-lock "></i> <span><?= $this->lang->line('change_password'); ?></span></a></li>
            
            <li class="dbbackup-active-li"><a href="<?php echo $base_url; ?>users/dbbackup"><i class="fa fa-database "></i> <span><?= $this->lang->line('database_backup'); ?></span></a></li> 
		   </ul>
        </li>
        -->

































        <li class="sales_commission_calculate_s-active-li sales_commission_views_filess-active-li saled_view_file-active-li sales_rasta_views-active-li sale_rasta_view_file-active-li sale_item_return_view_file-active-li   treeview">
            <a href="#">
                <i class="fa fa-shopping-basket text-aqua"></i><span> বিক্রয়</span>
                <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span> 
            </a>
            <ul class="treeview-menu">
                <li class="saled_view_file-active-li"><a href="<?php echo $base_url; ?>sales/add"><i class="fa fa-dollar "></i> <span> নতুন বিক্রয়</span></a></li>
                <li class="-active-li"><a href="<?php echo $base_url; ?>a/a"><i class="fa fa-dollar "></i> <span> বিক্রয় এডিট </span></a></li>
                <li class="sales_rasta_views-active-li sale_rasta_view_file-active-li "><a href="<?php echo $base_url; ?>sales/add_rasta"><i class="fa fa-dollar "></i> <span> রাস্তায় বিক্রয় </span></a></li>
                <li class="-active-li"><a href="<?php echo $base_url; ?>a/a"><i class="fa fa-dollar "></i> <span> বিক্রয় কৈফিয়ত</span></a></li>
                <li class="sales_commission_calculate_s-active-li"><a href="<?php echo $base_url; ?>tax/sales_commission_view_funcs"><i class="fa fa-dollar "></i> <span> বিক্রয় কমিশন এন্ট্রি</span></a></li>
                <li class="sales_commission_views_filess-active-li"><a href="<?php echo $base_url; ?>tax/sales_commission_view_history_ss"><i class="fa fa-dollar "></i> <span> বিক্রয় কমিশন হিসাব</span></a></li>
                <li class="sale_item_return_view_file-active-li"><a href="<?php echo $base_url; ?>sales/sales_product_return_view_fun"><i class="fa fa-dollar "></i> <span> বিক্রয় রিটার্ণ </span></a></li>
                <li class="-active-li"><a href="<?php echo $base_url; ?>a/a"><i class="fa fa-dollar "></i> <span> বিক্রয় চালান</span></a></li>
            </ul>
        </li>

        <li class="buy_commission_view_file-active-li buy_commission_view_history-active-li product_buy_pur-active-li purchase_from_cust-active-li   treeview">
            <a href="#">
                <i class="fa fa-shopping-bag text-aqua"></i><span> ক্রয়</span>
                <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li class="product_buy_pur-active-li"><a href="<?php echo $base_url; ?>purchase/add"><i class="fa fa-shopping-cart "></i> <span> নতুন ক্রয়</span></a></li>
                <li class="-active-li"><a href="<?php echo $base_url; ?>a/a"><i class="fa fa-hand-lizard-o "></i> <span> এডিট ক্রয়</span></a></li>
                <li class="-active-li"><a href="<?php echo $base_url; ?>a/a"><i class="fa fa-dollar "></i> <span> ক্রয় কৈফিয়ত</span></a></li>
                <li class="purchase_from_cust-active-li"><a href="<?php echo $base_url; ?>purchase/add_from_customer"><i class="fa fa-dollar "></i> <span> কাস্টমার ক্রয়</span></a></li>
                <li class="buy_commission_view_file-active-li"><a href="<?php echo $base_url; ?>tax/buy_commission_view_func_ss"><i class="fa fa-dollar "></i> <span> ক্রয় কমিশন এন্ট্রি</span></a></li>
                <li class="buy_commission_view_history-active-li"><a href="<?php echo $base_url; ?>tax/buy_commission_view_history_s"><i class="fa fa-dollar "></i> <span> ক্রয় কমিশন হিসাব</span></a></li>
                <li class="-active-li"><a href="<?php echo $base_url; ?>a/a"><i class="fa fa-dollar "></i> <span> ক্রয় চালান</span></a></li>
            </ul>
        </li>

        <li class="income_payment_take-active-li income_payment_take_haolat-active-li other_income_adds-active-li treeview">
            <a href="#">
                <i class="fa fa-money text-aqua"></i><span> জমা</span>
                <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li class="income_payment_take-active-li"><a href="<?php echo $base_url; ?>expense/due_income_payments"><i class="fa fa-dollar "></i> <span>কাস্টমারের টাকা গ্রহণ</span></a></li>
                <li class="income_payment_take_haolat-active-li"><a href="<?php echo $base_url; ?>expense/income_from_supps"><i class="fa fa-dollar "></i> <span>মহাজন থেকে হাওলাত</span></a></li>
                <li class="other_income_adds-active-li"><a href="<?php echo $base_url; ?>expense/other_income_adds"><i class="fa fa-plus-square-o "></i> <span>অন্যান্য ইনকাম</span></a></li>
            </ul>
        </li>

        <li class="expense_payment_paid-active-li expense_loan_taka_gives_customer-active-li expense-active-li transport_payment_paid-active-li   treeview">
            <a href="#">
                <i class="fa fa-usd text-aqua"></i><span> খরচ</span>
                <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li class="transport_payment_paid-active-li"><a href="<?php echo $base_url; ?>expense/transport_amount_paid"><i class="fa fa-users "></i> <span>ট্রান্সপোর্ট টাকা পরিশোধ</span></a></li>
                <li class="expense_payment_paid-active-li"><a href="<?php echo $base_url; ?>expense/paid_payment"><i class="fa fa-users "></i> <span>মহাজনকে পরিশোধ</span></a></li>
                <li class="expense_loan_taka_gives_customer-active-li"><a href="<?php echo $base_url; ?>expense/loan_to_customer"><i class="fa fa-dollar "></i> <span>কাস্টমারকে হাওলাত দেওয়া</span></a></li>
                <li class="expense-active-li"><a href="<?php echo $base_url; ?>expense/add"><i class="fa fa-minus-square "></i> <span>অন্যান্য খরচ</span></a></li>
            </ul>
        </li>

        <li class="amanot_add_view_file-active-li amanot_history_view_file-active-li add_new_amanot_view_files-active-li     treeview">
            <a href="#">
                <i class="fa fa-th-large text-aqua"></i><span> আমানত </span>
                <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
              <li class="add_new_amanot_view_files-active-li"><a href="<?php echo $base_url; ?>payment_types/add_new_amanot_fun"><i class="fa fa-user-circle "></i> <span> নতুন আমানত ব্যক্তি  </span></a></li>
              <li class="amanot_add_view_file-active-li"><a href="<?php echo $base_url; ?>payment_types/amanot_taken_view_fun"><i class="fa fa-calculator "></i> <span> আমানত হিসাব </span></a></li>
              <li class="amanot_history_view_file-active-li"><a href="<?php echo $base_url; ?>payment_types/amanot_history_check_s"><i class="fa fa-file-image-o "></i> <span> আমানত বিস্তারিত </span></a></li>  
            </ul>
        </li>
 
        <li class="customers-active-li customers-view-active-li customer_history_view-active-li    treeview">
            <a href="#">
                <i class="fa fa-usd text-aqua"></i><span> কাস্টমার</span>
                <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li class="customers-active-li"><a href="<?php echo $base_url; ?>customers/add"><i class="fa fa-plus-square-o "></i> <span> নতুন কাস্টমার </span></a></li>
                <li class="customers-view-active-li"><a href="<?php echo $base_url; ?>customers"><i class="fa fa-list "></i> <span>কাস্টমার লিস্ট</span></a></li>
                <li class="customer_history_view-active-li"><a href="<?php echo $base_url; ?>customers/cus_history_checks"><i class="fa fa-list "></i> <span>কাস্টমার হিসাব</span></a></li>
            </ul>
        </li>

        <li class="suppliers-active-li suppliers-list-active-li suppliers_history_check-active-li supplier_report_details-active-li supplier_report_summary-active-li treeview">
            <a href="#">
                <i class="fa fa-usd text-aqua"></i><span> মহাজন</span>
                <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li class="suppliers-active-li"><a href="<?php echo $base_url; ?>suppliers/add"><i class="fa fa-plus-square-o "></i> <span> নতুন মহাজন </span></a></li>
                <li class="suppliers-list-active-li"><a href="<?php echo $base_url; ?>suppliers"><i class="fa fa-list "></i> <span> মহাজন তালিকা </span></a></li>
                <li class="suppliers_history_check-active-li"><a href="<?php echo $base_url; ?>suppliers/history_check"><i class="fa fa-list "></i> <span> মহাজন হিসাব </span></a></li>
                <li class="supplier_report_details-active-li"><a href="<?php echo $base_url; ?>suppliers/all_report_details"><i class="fa fa-list "></i> <span> মহাজন রিপোর্ট বিস্তারিত </span></a></li>
                <li class="supplier_report_summary-active-li"><a href="<?php echo $base_url; ?>suppliers/all_report_history"><i class="fa fa-list "></i> <span> মহাজন রিপোর্ট সংক্ষিপ্ত</span></a></li>
            </ul>
        </li>

        <li class="items-list-active-li items-active-li treeview">
          <a href="#">
            <i class="fa fa-cubes text-aqua"></i> <span> পণ্য </span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="items-active-li"><a href="<?php echo $base_url; ?>items/add"><i class="fa fa-plus-square-o "></i> <span>নতুন পন্য যোগ</span></a></li>
            <li class="items-list-active-li"><a href="<?php echo $base_url; ?>items"><i class="fa fa-list "></i> <span>পন্যের তালিকা</span></a></li>
          </ul>
        </li>

        <li class=" staff_view_pages-active-li treeview">
          <a href="#">
            <i class="fa fa-user-plus text-aqua"></i> স্টাফ </span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
              <li class="staff_view_pages-active-li"><a href="<?php echo $base_url; ?>staff_add"><i class="fa fa-plus-square-o "></i> <span>নতুন স্টাফ যোগ</span></a></li>
              <li class="staff_view_pages-active-li"><a href="<?php echo $base_url; ?>staff_add"><i class="fa fa-minus-square-o "></i> <span>স্টাফ খরচ</span></a></li>
                <li class="-active-li"><a href="<?php echo $base_url; ?>a/a"><i class="fa fa-dollar "></i> <span> স্টাফদের হিসাব </span></a></li>
          </ul>
        </li>

        <li class=" transport_details_view_filess-active-li treeview">
            <a href="#">
                <i class="fa fa-usd text-aqua"></i><span> ট্রান্সপোর্ট</span>
                <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li class="-active-li"><a href="<?php echo $base_url; ?>a/a"><i class="fa fa-dollar "></i> <span> নতুন ট্রান্সপোর্ট </span></a></li>
                <li class="-active-li"><a href="<?php echo $base_url; ?>a/a"><i class="fa fa-dollar "></i> <span> ট্রান্সপোর্ট তালিকা </span></a></li>
                <li class="transport_details_view_filess-active-li"><a href="<?php echo $base_url; ?>tax/transport_details_see"><i class="fa fa-dollar "></i> <span> বিস্তারিত হিসাব </span></a></li>
            </ul>
        </li>

        <li class="send_sms_to_customers-active-li send_sms_to_amanot_view_files-active-li        treeview">
          <a href="#">
            <i class="fa fa-usd text-aqua"></i><span> SMS</span>
            <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="send_sms_to_customers-active-li"><a href="<?php echo $base_url; ?>reports/send_cust_sms"><i class="fa fa-dollar "></i> <span> কাস্টমার SMS </span></a></li>
            <li class="send_sms_to_amanot_view_files-active-li"><a href="<?php echo $base_url; ?>payment_types/send_smsto_amanot_persons"><i class="fa fa-dollar "></i> <span> আমানত SMS </span></a></li> 
            <li class="-active-li"><a href="<?php echo $base_url; ?>a/a"><i class="fa fa-dollar "></i> <span> মহাজন SMS </span></a></li>
          </ul>
        </li>

        <li class="report-sales-active-li report_laber_cost_view_file-active-li report-cash-in-hand-active-li report-profit-loss-active-li report-purchase-active-li report-purchase-item-active-li suppliyer-reports-active-li report-stock-active-li treeview">
            <a href="#">
                <i class="fa fa-usd text-aqua"></i><span> রিপোর্ট</span>
                <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li class="report-sales-active-li"><a href="<?php echo $base_url; ?>reports/sales" ><i class="fa fa-files-o "></i> <span> বিক্রয় রিপোর্ট </span></a></li>
                <li class="report-purchase-active-li"><a href="<?php echo $base_url; ?>reports/purchase" ><i class="fa fa-files-o "></i> <span> ক্রয় রিপোর্ট </span></a></li>
                <li class="report_laber_cost_view_file-active-li"><a href="<?php echo $base_url; ?>reports/laber_cost_view_func_ss" ><i class="fa fa-files-o "></i> <span> লেবার খরচ রিপোর্ট </span></a></li>
                <li class="report-cash-in-hand-active-li"><a href="<?php echo $base_url; ?>reports/cash_insss" ><i class="fa fa-files-o "></i> <span> ক্যাশ হিসাব </span></a></li>
                <li class="report-profit-loss-active-li"><a href="<?php echo $base_url; ?>reports/profit_loss" ><i class="fa fa-files-o "></i> <span> আয় ব্যায় </span></a></li>
                <li class="report-purchase-item-active-li"><a href="<?php echo $base_url; ?>reports/item_purchase" ><i class="fa fa-files-o "></i> <span>আইটেম রিপোর্ট</span></a></li>
                <li class="suppliyer-reports-active-li"><a href="<?php echo $base_url; ?>reports/suppliyers_reports" ><i class="fa fa-files-o "></i> <span>সরবহকারী রিপোর্ট</span></a></li>
                <li class="report-stock-active-li"><a href="<?php echo $base_url; ?>reports/stock" ><i class="fa fa-files-o "></i> <span> স্টক রিপোর্ট </span></a></li>
            </ul>
        </li>

        <li class="  treeview">
            <a href="#">
                <i class="fa fa-usd text-aqua"></i><span> সেটিং</span>
                <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li class="-active-li"><a href="<?php echo $base_url; ?>a/a"><i class="fa fa-dollar "></i> <span> নতুন মহাজন </span></a></li>
                <li class="-active-li"><a href="<?php echo $base_url; ?>a/a"><i class="fa fa-dollar "></i> <span> মহাজন লিস্ট </span></a></li>
                <li class="-active-li"><a href="<?php echo $base_url; ?>a/a"><i class="fa fa-dollar "></i> <span> মহাজন হিসাব </span></a></li>
            </ul>
        </li>

        <li class="users-view-active-li users-active-li roles-list-active-li role-active-li treeview">
          <a href="#">
            <i class="fa fa-users text-aqua"></i> <span> ইউজার</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="users-active-li"><a href="<?php echo $base_url; ?>users/"><i class="fa fa-plus-square-o "></i> <span> নতুন ইউজার</span></a></li>
            <li class="users-view-active-li"><a href="<?php echo $base_url; ?>users/view"><i class="fa fa-list "></i> <span> ইউজার লিস্ট</span></a></li>
            <li class="roles-list-active-li role-active-li"><a href="<?php echo $base_url; ?>roles/view"><i class="fa fa-list "></i><span> রোল লিস্ট</span></a></li>
            
          </ul>
        </li>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
