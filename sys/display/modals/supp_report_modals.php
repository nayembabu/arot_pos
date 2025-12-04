  
<!-- Add Keyframe Animation -->
<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(0.95);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }
</style>


<!-- Modal Structure -->
<div id="supp_cust_repor_modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 15px; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);">
            <!-- Modal Header -->
            <div class="modal-header" style="background: linear-gradient(135deg, #4caf50, #8bc34a); color: white; padding: 20px;">
                <button type="button" class="close" data-dismiss="modal" style="color: white;">&times;</button>
                <h2 class="modal-title text-center supp_name_ss">Supplier Details - <span class="supp_addrs_ss " style="font-size: 18px;">Address</span> </h2>
                <p class="modal-title text-center" style="font-size: 18px;"><strong>ক্রয়ের তারিখ:</strong> <span class="pur_datesss" >0000-00-00</span></p>
            </div>

            <!-- Modal Body -->
            <div class="modal-body" style="padding: 20px; background-color: #f7f9fc;  animation: fadeIn 2s;">
            
            <p style="font-size: 24px;"><strong class=""> ক্রয়ের তথ্য  </strong></p>
            <p style="font-size: 17px;"><strong class="lot_namess"></strong></p>
            <p class="details_of_lotsss" style="font-size: 16px; margin: -20px 0 20px 0;" ></p>
            <p style="font-size: 25px;"><strong>বিক্রয়ের তালিকা:</strong></p>
                <div id="accordion">
                    <!-- Customer F -->
                    <div class="customer_list_html_assign " ></div> 
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer" style="background: #f1f1f1; text-align: center; padding: 15px;">
                <button type="button" class="btn btn-success" data-dismiss="modal" style="border-radius: 30px; padding: 10px 20px;">Close</button>
            </div>
        </div>
    </div>
</div>








