<?php
    $this->session->unset_userdata('ishipping_total_price');
    $balance = $this->wallet_model->user_balance();
    $cashback_product = $this->db->get_where('coupon')->result_array();
    $already_add_product_arr = array();

    $current_date = date('Y-m-d');

    foreach($cashback_product as $key => $value) 
    {
        $already_add_product_ar = json_decode($value['spec']);

        if(strtotime($value['till']) > strtotime($current_date))
        {
            $till_ar[] = strtotime($value['till']);

            foreach(json_decode($already_add_product_ar->set) as $key => $productids) 
            {
                $already_add_product_arr[] = array('productid'=>$productids,'discount_type'=>$already_add_product_ar->discount_type,'discount_value'=>$already_add_product_ar->discount_value);
            }
        }
    }
    function searchArrayKeyVal($sKey, $id, $array) 
    {
        foreach ($array as $key => $val)
        {
            if($val[$sKey] == $id) 
            {
               return $key;
            }
        }
       return false;
    }
?>
<style type="text/css">
    .buttonblock{
        position: relative;
    }
    .buttonblock .btngra{
       position: absolute;
    top: -12px;
    right: 0px;
    height: 45px;
    line-height: 42px;
    text-align: center;
    width: 95px;
    text-align: center;
    color: #0f0c29;
    border-radius: 0 5px 5px 0;
    padding: 0;
    border: 0;
    transition: all .3s linear;
    background-image: linear-gradient(to right, #c8a233 0%, #f6da76 51%, #c8a233 100%) !important;
    }
    .buttonblock .promo_code{
         width: 79%;
    background: #ebebeb;
    height: 46px;
    line-height: 42px;
    padding: 0 23px;
    }
.disabled 
{
    pointer-events: none;
    cursor:auto;
}

.grand-totall .search-element button 
{
    position: absolute;
    top: 0;
    right: 0;
    height: 45px;
    line-height: 42px;
    text-align: center;
    width: 87px;
    text-align: center;
    color: #f9f9f9;
    border-radius: 0 5px 5px 0;
    padding: 0;
    border: 0;
    transition: all .3s linear;
    background-image: linear-gradient(to right, #13328b 0%, #254ab1 51%, #13328b 100%) !important;
}
.grand-totall .search-element
{
        margin-top: 9px;
}
@media (min-width: 320px) and (max-width: 480px) {
  
 .buttonblock .promo_code {
    width: 74%;
    height: 46px;
    line-height: 42px;
    padding: 0 16px;
}

.buttonblock .btngra {
    top: -12px;
    right: -18px;
    height: 45px;
    width: 76px;
   
}
  }
</style>
<div class="offcanvas-overlay"></div>
<!-- Breadcrumb Area Start -->
<div class="breadcrumb-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-content">
                    <ul class="nav">
                        <li><a href="<?php echo base_url(); ?>">Home</a></li>
                        <li><?php echo ucwords(translate('cart'));?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Area End-->
<!-- cart area start -->
<div class="cart-main-area mtb-5px body2">
    <div class="container">
        <h3 class="cart-page-title">Your cart items</h3>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
               <?php echo form_open(base_url() . 'home/cart_finish/go', array('method' => 'post','enctype' => 'multipart/form-data','id' => 'cart_form'));?>
                    <div class="table-content table-responsive cart-table-content">
                        <table>
                            <thead>
                                <tr>
                                    <th><?php echo translate('yours');?></th>
                                    <th><?php echo translate('product_description');?></th>
                                    <th><?php echo translate('qty');?></th>
                                    <th><?php echo "RRP";?></th>
                                    <th><?php echo "ORP";?></th>
                                    <th><?php echo "Promo";?></th>
                                    <th><?php echo "Saving";?></th>
                                    <th><?php echo translate('subtotal');?></th>
                                    <th><?php echo "Remove";?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $carted = $this->cart->contents();
                                    $remove_promocode;
                                    foreach ($carted as $items)
                                    { 
                                        $variationqty_arr = json_decode($items['option']);
                                        if($variationqty_arr->promocode_cal_discount_price > 0)
                                        {
                                            $remove_promocode = 'abhi h product';
                                        }
                                        
                                        $product_details = $this->db->get_where('product',array('product_id'=>$variationqty_arr->productid))->row();


                                        if($this->session->userdata('currency') == '2')
                                        {
                                            $rrp = $product_details->sale_price_AU*$items['qty'];
                                            $wholesale = $product_details->wholesale*$items['qty'];
                                        }
                                        else
                                        {
                                            $wholesale = $product_details->wholesale_EXCL_WET_GST*$items['qty'];
                                        }
                                        if($this->session->userdata('currency') == '10')
                                        {
                                            if($product_details->sale_price_HK > 0)
                                            {
                                                $rrp = $product_details->sale_price_HK*$items['qty'];
                                            }
                                            else
                                            {
                                                $rrp = $product_details->sale_price_AU*$items['qty'];
                                            }
                                        }
                                        if($this->session->userdata('currency') == '13')
                                        {
                                            if($product_details->sale_price_JP > 0)
                                            {
                                                $rrp = $product_details->sale_price_JP*$items['qty'];
                                            }
                                            else
                                            {
                                                $rrp = $product_details->sale_price_AU*$items['qty'];
                                            }
                                        }
                                        if($this->session->userdata('currency') == '22')
                                        {
                                            if($product_details->sale_price_SG > 0)
                                            {
                                                $rrp = $product_details->sale_price_SG*$items['qty'];
                                            }
                                            else
                                            {
                                                $rrp = $product_details->sale_price_AU*$items['qty'];
                                            }
                                        }
                                        if($product_details->limited_release =="Yes")
                                        {
                                            $orp_commission_amount = ($this->db->get_where('business_settings', array('type' => 'limit_admin_orp_commission_amount'))->row()->value)/100;
                                        
                                            $commission_amount = ($this->db->get_where('business_settings', array('type' => 'limit_admin_commission_amount'))->row()->value)/100;   
                                        }
                                        else
                                        {
                                            $orp_commission_amount = ($this->db->get_where('business_settings', array('type' => 'nolimit_admin_orp_commission_amount'))->row()->value)/100;
                                        
                                            $commission_amount = ($this->db->get_where('business_settings', array('type' => 'nolimit_admin_commission_amount'))->row()->value)/100;
                                        }
                                        
                                        $gap_revenue = $rrp - $wholesale;
                                        $gap_revenue_commission = $gap_revenue * $commission_amount;    
                                        $orp = $rrp - (($gap_revenue - $gap_revenue_commission)*$orp_commission_amount);

                                        $discount = ($product_details->discount) ? ($product_details->discount) : 0; 

                                        $total_discount = ($orp*($discount/100));

                                        $promocode = ($variationqty_arr->promocode_cal_discount_price > 0) ? $variationqty_arr->promocode_cal_discount_price *$items['qty'] : 0;

                                        $saving = ($rrp - $orp)+$total_discount;

                                        $total_sub_total_orp = $orp - ($orp * ($discount/100));

                                        if($this->session->userdata('currency') == '2')
                                        {
                                            $with_rrp_currency = currency($rrp);
                                            $with_orp_currency = currency($orp); 
                                            $with_saving_currency = ($saving > 0) ? currency($saving) : '-'; 
                                            $with_sub_total_currency = currency($total_sub_total_orp); 
                                        }
                                        if($this->session->userdata('currency') == '10')
                                        {
                                            if($product_details->sale_price_HK > 0)
                                            {
                                                $with_rrp_currency = currency().$rrp;   
                                                $with_orp_currency = currency().$orp;
                                                $with_saving_currency = ($saving > 0) ? currency().$saving : '-';
                                                $with_sub_total_currency = currency().$total_sub_total_orp;  
                                            }
                                            else
                                            {
                                                $with_rrp_currency = currency($rrp);
                                                $with_orp_currency = currency($orp);
                                                $with_saving_currency = ($saving > 0) ? currency($saving) : '-';
                                                $with_sub_total_currency = currency($total_sub_total_orp);
                                            }
                                        }
                                        if($this->session->userdata('currency') == '13')
                                        {
                                            if($product_details->sale_price_JP > 0)
                                            {
                                                $with_rrp_currency = currency().$rrp;
                                                $with_orp_currency = currency().$orp;
                                                $with_saving_currency = ($saving > 0) ? currency().$saving : '-';
                                                $with_sub_total_currency = currency().$total_sub_total_orp;
                                            }
                                            else
                                            {
                                                $with_rrp_currency = currency($rrp);
                                                $with_orp_currency = currency($orp);
                                                $with_saving_currency = ($saving > 0) ? currency($saving) : '-';
                                                $with_sub_total_currency = currency($total_sub_total_orp);
                                            }
                                        }
                                        if($this->session->userdata('currency') == '22')
                                        {
                                            if($product_details->sale_price_SG > 0)
                                            {
                                                $with_rrp_currency = currency().$rrp;
                                                $with_orp_currency = currency().$orp;
                                                $with_saving_currency = ($saving > 0) ? currency().$saving : '-';
                                                $with_sub_total_currency = currency().$total_sub_total_orp;
                                            }
                                            else
                                            {
                                                $with_rrp_currency = currency($rrp);
                                                $with_orp_currency = currency($orp);
                                                $with_saving_currency = ($saving > 0) ? currency($saving) : '-';
                                                $with_sub_total_currency = currency($total_sub_total_orp);
                                            }
                                        }
                                    ?>
                                <tr data-rowid="<?php echo $items['rowid']; ?>">
                                    <td class="product-thumbnail proimgheight">
                                        <?php if($items['image']) { ?>
                                        <a  href="<?php echo $this->crud_model->product_link($variationqty_arr->productid); ?>"><img class="img-responsive" src="<?php echo $items['image']; ?>" alt="" /></a>
                                        <?php } else { ?>
                                        <a  href="<?php echo $this->crud_model->product_link($variationqty_arr->productid); ?>"><img class="img-responsive" src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/wine.png" alt="" /></a>
                                        <?php $count= $items['id']; } ?>
                                    </td> 
                                    <td class="product-name"><a href="<?php echo $this->crud_model->product_link($variationqty_arr->productid); ?>"><?php echo $items['name']; ?></a>
                                    </td>
                                    <td class="product-quantity">
                                        <div class="cart-plus-minus">
                                            <button type='button' variationqty="<?php echo $variationqty_arr->variationqty; ?>" class="dec qtybutton btn in_xs quantity-button minus"  value='minus' >-</button>
                                            <input  type="text" disabled class="cart-plus-minus-box qty in_xs quantity-field quantity_field" data-rowid="<?php echo $items['rowid']; ?>" data-limit='no' value="<?php echo $items['qty']; ?>" id='qty1' onblur="check_ok(this);" data-discount="<?php echo $cal_discount = ($discount/100) * $items['subtotal']; ?>" />
                                            <button type='button' variationqty="<?php echo $variationqty_arr->variationqty; ?>"  class="btn in_xs quantity-button plus inc qtybutton"  value='plus' >+</button>
                                        </div>
                                    </td>
                                    <td class="prize">
                                        <span class="amount rrp">
                                            <?php echo $with_rrp_currency; ?>
                                        </span>
                                    </td>
                                    <td class="prize"><span class="amount orp"><?php echo $with_orp_currency; ?></span></td>
                                    <td class="promocode_price">
                                        <?php
                                            if($promocode > 0)
                                            {
                                                echo currency($promocode);
                                            }
                                            else
                                            {
                                                echo "-";
                                            }
                                        ?>
                                    </td>
                                    <td class="product-price-cart discount">
                                        <?php  echo $with_saving_currency;  ?>
                                    </td>
                                    <td class="product-subtotal sub_total">
                                        <?php  echo $with_sub_total_currency;  ?>    
                                    </td>                               
                                    <td class="total">
                                        <a href="javascript:void(0);" class="close delete_cart_product float-none">
                                            <ion-icon name="trash-sharp"></ion-icon>
                                        </a>
                                    </td>
                                </tr>
                                <?php 
                                }
                                if($remove_promocode != 'abhi h product')
                                {
                                    $promocode=$this->session->set_userdata('promocode','');
                                }    
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="cart-shiping-update-wrapper">
                                <div class="cart-shiping-update">
                                    <a href="javascript:void(0);" class="removeproduct">Clear Shopping Cart</a>
                                </div>
                                <div class="cart-clear">
                                    <a href="<?php echo base_url(); ?>"><button>Continue Shopping</button></a>
                                    <a href="<?php echo base_url().'home/cart_checkout/'; ?>"><button type="button">Update Shopping Cart</button></a>
                                </div>
                            </div>
                        </div>
                    </div>

                <div class="row">
                    <div class="col-lg-7 col-md-6 mb-lm-30px">
                        <div class="cart-tax">
                            <div class="title-wrap">
                                <h4 class="cart-bottom-title section-bg-gray">Billing Address</h4>
                            </div>

                            <div class="tax-wrapper">
                                <p class="required">All Fields are required*</p>
                                <div class="tax-select-wrapper">
                                    <div class="row">
                                        <?php 
                                            if ($this->session->userdata('user_login') == "yes") {
                                                $user_info = $this->db->get_where('user',array('user_id'=>$this->session->userdata('user_id')))->row(); 
                                            }
                                        ?>
                                        <div class="col-sm-6">
                                            <div class="tax-select">
                                                <input type="text" name="first_name" placeholder="<?php echo translate('first_name');?>" class="form-control" value="" required >
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="tax-select">
                                                <input type="text" name="last_name" placeholder="<?php echo translate('last_name');?>" class="form-control" value="" required >
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="tax-select mb-25px">
                                                <input type="text" name="phone" class="form-control" placeholder="<?php echo translate('phone');?>"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo $user_info->phone; ?>" required/>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="tax-select mb-25px">
                                                <input type="text" name="email" class="form-control" placeholder="<?php echo translate('email');?>" value="<?php echo $user_info->email; ?>" required/>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="tax-select mb-25px">
                                                <input type="text" name="address1" class="form-control" placeholder="<?php echo translate('address1');?>" value="<?php echo $user_info->address1; ?>" required/>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="tax-select mb-25px">
                                                <input type="text" name="address2" class="form-control" placeholder="<?php echo translate('address2');?>" value="<?php echo $user_info->address2; ?>" required/>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="tax-select mb-25px">
                                                <input type="text" name="city" class="form-control" placeholder="Suburb/City" value="<?php echo $user_info->city; ?>" required/>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="tax-select mb-25px">
                                                <input type="text" name="state" class="form-control" placeholder="State" value="<?php echo $user_info->state; ?>" required/>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="tax-select mb-25px">
                                                <input type="text" name="state_or_province_code" class="form-control" placeholder="State Or Province Code" value="" required/>
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-6">
                                            <div class="tax-select">
                                                <select name="country" class="form-control" id="country" required>
                                                    <option value="">Select</option>
                                                    <option value="AU" selected>Australia</option>
                                                    <option value="HK">Hong Kong</option>
                                                    <option value="JP">Japanese</option>
                                                    <option value="SG">Singapore</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="tax-select">
                                                <input type="text" name="postal_code" class="form-control postal-code" placeholder="Enter Post Code">
                                            </div>
                                        </div>
                                        <div class="col-sm-4 offset-sm-8 text-right btngra1">
                                            <button type="button" class="btn btngra ishipping_api">Next</button>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkout-account">
                                                <div class="tax-select mrgnbtm">
                                                    <label class="delnew">
                                                        <input class="checkout-toggle same_delivery" name="delivery_different" type="checkbox" value="no">
                                                        <p>Delivery details (If different)</p>
                                                    </label>
                                                    <div class="different-address open-toggle" style="display: none;">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <div class="title-wrap">
                                                                    <h4 class="cart-bottom-title section-bg-gray">Delivery Address</h4>
                                                                </div>
                                                                <div class="tax-wrapper">
                                                                    <p>All Fields are required*</p>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="tax-select-wrapper">
                                                                    <div class="row">
                                                                        <div class="col-sm-6">
                                                                            <div class="tax-select">
                                                                                <input type="text" name="delivery_first_name" placeholder="<?php echo translate('first_name');?>" class="form-control" value="" required >
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="tax-select">
                                                                                <input type="text" name="delivery_last_name" placeholder="<?php echo translate('last_name');?>" class="form-control" value="" required >
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="tax-select mb-25px">
                                                                                <input type="text" name="delivery_phone" class="form-control" placeholder="<?php echo translate('phone');?>"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="" required/>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="tax-select mb-25px">
                                                                                <input type="email" name="delivery_email" class="form-control" placeholder="<?php echo translate('email');?>" value="" required/>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="tax-select mb-25px">
                                                                                <input type="text" name="delivery_address1" class="form-control" placeholder="<?php echo translate('address1');?>" value="" required/>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="tax-select mb-25px">
                                                                                <input type="text" name="delivery_address2" class="form-control" placeholder="<?php echo translate('address2');?>" value="" required/>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="tax-select mb-25px">
                                                                                <input type="text" name="delivery_city" class="form-control" placeholder="Suburb/City" value="" required/>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="tax-select mb-25px">
                                                                                <input type="text" name="delivery_state" class="form-control" placeholder="State" value="" required/>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                        <div class="tax-select mb-25px">
                                                                            <input type="text" name="delivery_state_or_province_code" class="form-control" placeholder="State Or Province Code" value="" required/>
                                                                        </div>
                                                                    </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="tax-select">
                                                                                <select name="delivery_country" class="form-control" id="delivery_country" required>
                                                                                    <option value="">Select...</option>
                                                                                    <option value="AU" selected="selected">Australia</option>
                                                                                    <option value="HK">Hong Kong</option>
                                                                                    <option value="JP">Japanese</option>
                                                                                    <option value="SG">Singapore</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="tax-select">
                                                                                <input type="text" name="delivery_postal_code" class="form-control postal-code" placeholder="Enter Post Code">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-4 offset-sm-8 text-right btngra2 ">
                                                                            <button type="button" class="btn btngra ishipping_api">Next</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="pro-details-policy">
                                                <ul>
                                                    <li>
                                                        <img src="<?php echo base_url();?>template/omgee/images/icons/policy.png" alt="" /><span>Security Policy</span>
                                                    </li>
                                                    <li>
                                                        <img src="<?php echo base_url();?>template/omgee/images/icons/policy-2.png" alt="" /><span>Delivery Policy</span>
                                                    </li>
                                                    <li>
                                                        <img src="<?php echo base_url();?>template/omgee/images/icons/policy-3.png" alt="" /><span>Return Policy</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-12 mt-md-30px">
                        <div class="grand-totall">
                            <div class="title-wrap">
                                <h4 class="cart-bottom-title section-bg-gary-cart">Cart Total</h4>
                            </div>
                            <h5>Enter Your Promocode If You Have One.</h5>
                            <div class="buttonblock">
                            <input type="text" class="form-control promo_code" placeholder="Promocode Code" value="<?php echo $this->session->userdata('promocode'); ?>" >
                            <input type="button" class="btn btngra promocode_btn" value="Apply">
                        </div>
                            <h5>Total products <span id="product_total"></span></h5>
                            <h5 class="text-success">Total Saving<span id="total_discount"></span></h5>
                            <h5>Promocode<span id="promocode_total_discount_price"></span></h5>
                            <h5><?php 
                                    if($this->session->userdata('currency') == 2)
                                    {
                                        echo "GST ".$tax  = $this->db->get_where('business_settings', array('type' => 'aud_tax'))->row()->value.'%';
                                    }
                                    if($this->session->userdata('currency') == 10)
                                    {
                                        echo "Tax ".$tax  = $this->db->get_where('business_settings', array('type' => 'hkd_tax'))->row()->value.'%';
                                    }
                                    if($this->session->userdata('currency') == 13)
                                    {
                                        echo "Tax ".$tax  = $this->db->get_where('business_settings', array('type' => 'jpy_tax'))->row()->value.'%';
                                    }
                                    if($this->session->userdata('currency') == 22)
                                    {
                                        echo "Tax ".$tax  = $this->db->get_where('business_settings', array('type' => 'sgd_tax'))->row()->value.'%';
                                    } ?> included <span id="tax"></span></h5>
                            <h5>Sub-Total <span id="product_sub_total"></span></h5>
                            <p>(Average each product $)</p>
                            <h5>eWallet Cashback Earn <span  id="total_cashback_discount"></span></h5> 
                            <div class="total-shipping  ishipping_result" style="display: none;">
                                <div class="title-wrap">
                                    <h4 class="cart-bottom-title section-bg-gary-cart">Door-To-Door Delivery</h4>
                                </div>
                                <h5>Custom <span id="ishipping_custom"></span></h5>
                                <h5>Duty <span id="ishipping_duty"></span></h5>
                                <h5>Sub Total <span id="ishipping_total"></span></h5>
                                <p>Average each product shipping cost <span>$</span></p>
                                <h5>Estimated Delivery Time <span id="estimated_delivery_time"></span></h5>
                            </div>
                            <div class="total-shipping">
                                <ul>
                                    <li>
                                        <input   type="hidden" name="payment_type" value="stripe"/>
                                        <input id="mastercarddd"  walletamount="<?php echo $this->wallet_model->user_balance(); ?>" type="checkbox" name="payment_type" value="stripe"/> 
                                        <?php
                                        if ($this->crud_model->get_type_name_by_id('general_settings','84','value') == 'ok') 
                                        {
                                            ?>
                                         Use eWallet <span><?php echo currency($this->wallet_model->user_balance()); ?></span>
                                        <?php
                                        }
                                        ?>
                                    </li>
                                </ul>
                            </div>
                            
                            <h4 class="grand-totall-title">Grand Total <span id="grand"></span></h4>
                            <p>Average Each Product <span>$</span></p>
                            <div class="disabled comman_checkout">
                                <a href="javascript:void(0);"  style="display: none;" class="wallet_checkout"   onclick="cart_submission();">Proceed to Checkout</a>
                                <?php include 'payments_options.php'; ?>
                            </div>    
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
<?php
    echo form_open('', array(
    'method' =>
    'post', 'id' => 'coupon_set' )); 
?> 
<input type="hidden" id="coup_frm" name="code">
</form>
<!-- cart area end -->
<script type="text/javascript">
    $( document ).ready(function() 
    { 
        $('body').on('click','.removeproduct', function(){
            var here = $(this);
            var list1 = $('#total');
            $.ajax({
                url: base_url+'home/cart/remove_all/',
                beforeSend: function() {
                    list1.html('...');

                },
                success: function(data) {
                    list1.html(data).fadeIn();
                    notify(cart_product_removed,'success','bottom','right');
                    setTimeout(function(){
                       window.location.reload();
                    }, 3000);
                    //sound('cart_product_removed');
                    reload_header_cart();
                    others_count();
                    thetr.hide('fast');
                    /*if(data == 0){
                        location.replace('<?php echo base_url();?>');   
                    }   */
                    
                },
                error: function(e) {
                    console.log(e)
                }
            });
        });        

        $('body').on('click','.delete_cart_product', function()
        {
            var here = $(this);
            var rowid = here.closest('tr').data('rowid');
            var thetr = here.closest('tr');
            var list1 = $('#total');
            $.ajax({
                url: base_url+'home/cart/remove_one/'+rowid,
                beforeSend: function() {
                    list1.html('...');
                },
                success: function(data) 
                {
                    list1.html(data).fadeIn();
                    notify(cart_product_removed,'success','bottom','right');
                    reload_header_cart();
                    others_count();
                    thetr.hide('fast');
                    if(data == 0){
                       window.location.reload();   
                    }
                },
                error: function(e) {
                    console.log(e)
                }
            });
        });
        $('body').on('click','#mastercarddd',function()
        {
        	var list1 = $('#grand');
        	
            if($("#mastercarddd").prop("checked"))
            {
                $('input[name="payment_type"]').attr('value','wallet');
                var walletamount = $('#mastercarddd').attr('walletamount');
                $('.wallet_checkout').show();
                $('.stripe_checkout').hide();

                $.ajax({
	                url: base_url+'home/cart/userwallet',
	                type: 'post',
	                dataType: 'json',
	                data: {
	                	'walletamount' : walletamount
	                },
	                beforeSend: function() {
	                    list1.html('...');
	                },
	                success: function(data) 
	                {
	                	list1.html(data);
	                },
	                error: function(e) {
	                    console.log(e)
	                }
	            });
            }
            else
            {
                $('input[name="payment_type"]').attr('value','stripe');
                $('.wallet_checkout').hide();
                $('.stripe_checkout').show();

                $.ajax({
	                url: base_url+'home/cart/userwallet',
	                type: 'post',
	                dataType: 'json',
	                data: {
	                	'walletamount' : 0
	                },
	                beforeSend: function() {
	                    list1.html('...');
	                },
	                success: function(data) 
	                {
	                	list1.html(data);
	                },
	                error: function(e) {
	                    console.log(e)
	                }
	            });
            }
        });        
        update_calc_cart();
    });
    
    function radio_check(id)
    {
        $( "#visa" ).prop( "checked", false );
        $( "#mastercardd" ).prop( "checked", false );
        $( "#mastercard" ).prop( "checked", false );
        $( "#"+id ).prop( "checked", true );
    }
    $('.same_delivery').click(function()
    {
        if($(".same_delivery").prop("checked"))
        {
            $('.btngra1').hide();
            $('.btngra2').show();
            delivery = { del : 'delivery_' };
            validation(delivery);
        }
        else
        {
            $('.btngra2').hide();
            $('.btngra1').show();
            validation(delivery);
        }
    });
</script>