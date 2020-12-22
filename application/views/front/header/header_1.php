<!-- mobile main menu -->
<nav class="navbar navbar-expand-lg navbar-light mobilemenuheader mobilemenu">
    <div class="row">
        <?php
            $home_top_logo = $this->db->get_where('ui_settings',array('type' => 'home_top_logo'))->row()->value;
            ?>      
        <a class="navbar-brand col-6" href="<?php echo base_url();?>">
            <div class="logo mlogo">
                <img width="100px" src="<?php echo base_url(); ?>uploads/logo_image/logo_<?php echo $home_top_logo; ?>.png" alt="logo.png" />
            </div>

            
        </a>
        <div class="col-5">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </div>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo base_url('home/vendor_logup/registration/'); ?>"><?php echo translate('all_vendors'); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Newsletter</a>
            </li>
            <li class="nav-item" style="display: none;">
                <a class="nav-link" href="#">Download</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Follow us on
                </a>
                <div class="dropdown-menu socialheader" aria-labelledby="navbarDropdown">
                    <?php
                        if ($facebook != '') {
                        ?>
                    <a class="dropdown-item" href="<?php echo $facebook;?>">  <img class="facebtn" src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/facebook.png"></a>
                    <?php
                        } if ($instagram != '') {
                        ?>
                    <a class="dropdown-item" href="<?php echo $instagram;?>"><img class="instabtn" src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/instagram.png"></a>
                    <?php
                        }
                        if ($youtube != '') {
                        ?>
                    <a class="dropdown-item" href="<?php echo $youtube;?>"><img class="youbtn" src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/youtube.png"></a>
                    <?php
                        }
                        ?>
                </div>
            </li>
            <li class="nav-item">
                <?php if($this->session->userdata('user_login')!='yes'){ ?>
                <a class="nav-link" href="<?php echo base_url(); ?>home/login_set/login"><?php echo translate('login');?> or <?php echo translate('register');?></a><?php } else { ?>
                <a href="<?php echo base_url(); ?>home/profile/"><?php echo translate('my_profile');?></a> <a class="log_header" href="<?php echo base_url(); ?>home/logout/"><?php echo translate('logout');?></a>
                <?php } ?>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Cash Out Cashback  
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">
                        <ion-icon name="card-outline"></ion-icon>
                        Shop at OMGee and Earn Cashback
                    </a>
                    <a class="dropdown-item" href="#">
                        <ion-icon name="cash-outline"></ion-icon>
                        Cash out your Cashback
                    </a>
                    <a class="dropdown-item" href="#">
                        <ion-icon name="wallet-outline"></ion-icon>
                        Transfer to your bank account
                    </a>
                    <a class="dropdown-item" href="#"><button type="button" class="btn freebtn">Learn More</button></a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php                                            
                    if($currency_id = $this->session->userdata('currency')){} else {
                        $currency_id = $this->db->get_where('business_settings', array('type' => 'currency'))->row()->value;
                    }
                    $symbol = $this->db->get_where('currency_settings',array('currency_settings_id'=>$currency_id))->row()->symbol;
                    $c_name = $this->db->get_where('currency_settings',array('currency_settings_id'=>$currency_id))->row()->code;
                    echo $c_name." (".$symbol.")"; ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <?php
                        $currencies = $this->db->get_where('currency_settings',array('status'=>'ok'))->result_array();
                        foreach ($currencies as $row)
                        {
                        ?>
                    <a class="dropdown-item" currencyid="<?php echo $row['currency_settings_id']; ?>" data-href="<?php echo base_url(); ?>home/set_currency/<?php echo $row['currency_settings_id']; ?>"> <?php echo $row['code']; ?> (<?php echo $row['symbol']; ?>)
                    <?php if($currency_id == $row['currency_settings_id']){ ?>
                    <i class="fa fa-check"></i>
                    <?php } ?></a>
                    <?php
                        }
                        ?>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                English 
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">  English </a>
                    <a class="dropdown-item" href="#">  Chinese</a>
                    <a class="dropdown-item" href="#"> Japanese</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
<!-- end -->
<!-- Header Nav Start -->
<div class="header-nav mobile_d_none">
    <div class="header-nav-wrapper d-md-flex d-sm-flex d-xl-flex d-lg-flex justify-content-between">
        <div class="header-static-nav col-lg-6 col-sm-6 col-md-4 col-12">
            <ul class="mob_ul_view">
                <li>
                    <a href="<?php echo base_url('home/vendor_logup/registration/'); ?>"><?php echo translate('all_vendors'); ?></a>
                </li>
                <li>
                    <a href="#" data-toggle="modal" data-target="#newsletter">Newsletter </a>
                    <div class="modal fade news_pop" id="newsletter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <img class="img-responsive" src="<?php echo base_url(); ?>/template/omgee/images/iconfindericon/winepop.png">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <section class="new_sec">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h5>Join the Newsletter</h5>
                                                    <p>Subscribe to our newsletter to recieve the latest drinks and offers from our team </p>
                                                    <div class="subscribe-content">
                                                        <form action="http://103.15.67.74/pro1/omgee/home/subscribe" class="newsletter-form" data-toggle="validator" novalidate="true">
                                                            <input type="text" class="input-newsletter form-control"  placeholder="name@example.com" name="email" id="subscr" required="" autocomplete="off">
                                                            <button type="button" class="default-btn disabled submit-button subscriber enterer" style="pointer-events: all; cursor: pointer;">Send</button>
                                                            <div id="validator-newsletter" class="form-result"></div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li style="display: none;">
                    <a href="#">Download</a>
                </li>
            </ul>
            <div class="social-info">
                <ul class="menu-nav mob_tab_view">
                    <li class="pr-0 prnew">
                        <div class="dropdown menutopright">
                            <button type="button"  id="mob_tab_view-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <ion-icon name="share-social-sharp"></ion-icon>
                            </button>
                            <ul class="dropdown-menu socialheader mobile_tab_drop animation slideDownIn" aria-labelledby="mob_tab_view-3">
                                <li>
                                    <?php
                                        if ($facebook != '') {
                                        ?>
                                    <a href="<?php echo $facebook;?>"><img class="facebtn" src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/facebook.png"></a>
                                </li>
                                <li>
                                    <?php
                                        } if ($instagram != '') {
                                        ?>
                                    <a href="<?php echo $instagram;?>"><img class="instabtn" src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/instagram.png"></a>
                                </li>
                                <li>
                                    <?php
                                        }
                                        if ($youtube != '') {
                                        ?>
                                    <a href="<?php echo $youtube;?>"><img class="gplusbtn" src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/youtube.png"></a>
                                </li>
                                <li>
                                    <?php
                                        }
                                        ?>
                            </ul>
                        </div>
                    </li>
                </ul>
                <div class="socialheader tab_mob_none">
                    <?php
                        if ($facebook != '') {
                        ?>
                    <a href="<?php echo $facebook;?>"><img class="facebtn" src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/facebook.png"></a>
                    <?php
                        } if ($instagram != '') {
                        ?>
                    <a href="<?php echo $instagram;?>"><img class="instabtn" src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/instagram.png"></a>
                    <?php
                        }
                        if ($youtube != '') {
                        ?>
                    <a href="<?php echo $youtube;?>"><img class="gplusbtn" src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/youtube.png"></a>
                    <?php
                        } 
                        ?>
                </div>
            </div>
        </div>
        <div class="header-menu-nav col-lg-6 col-sm-6 col-md-8 col-12">
            <div class="row">
                <div class="col-lg-8 col-sm-8 col-md-8 mob_lan mainscreen tab_header_nav">
                    <ul class="menutopleft">
                        <li><?php if($this->session->userdata('user_login')!='yes'){ ?>
                            <a href="<?php echo base_url(); ?>home/login_set/login"><?php echo translate('login');?> or <?php echo translate('register');?></a><?php } else { ?>
                            <a href="<?php echo base_url(); ?>home/profile/"><?php echo translate('my_profile');?></a> <a class="log_header" href="<?php echo base_url(); ?>home/logout/"><?php echo translate('logout');?></a>
                            <?php } ?>
                        </li>
                    </ul>
                    <div class="header-menu  sticky-nav d-xl-block custommegamenu">
                        <div class="header-horizontal-menu">
                            <ul class="menu-content">
                                <li class="menu-dropdown">
                                    <a href="#">Cash out Cashback <i class="ion-ios-arrow-down"></i></a>
                                    <ul class="mega-menu-wrap row">
                                        <li class="firstmega">
                                            <ul>
                                                <li class="mega-menu-title">
                                                    <p>
                                                        <ion-icon name="card-outline"></ion-icon>
                                                        Shop and Earn Cashback
                                                    </p>
                                                </li>
                                                <ion-icon class="arrowstyle" name="arrow-redo-outline"></ion-icon>
                                            </ul>
                                        </li>
                                        <li class="secmega">
                                            <ul>
                                                <li class="mega-menu-title">
                                                    <p>
                                                        <ion-icon name="cash-outline"></ion-icon>
                                                        CASH OUT Your Cashback 
                                                    </p>
                                                </li>
                                                <ion-icon class="arrowstyle" name="arrow-redo-outline"></ion-icon>
                                            </ul>
                                        </li>
                                        <li>
                                            <ul>
                                                <li class="mega-menu-title">
                                                    <p>
                                                        <ion-icon name="wallet-outline"></ion-icon>
                                                        Transfer to your bank account
                                                    </p>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="btnmega">
                                            <ul>
                                                <li class="mega-menu-title"><a href="#"><button type="button"
                                                    class="btn freebtn">Learn More</button></a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-4 col-md-3 englang tab_header_nav mob_nav">
                    <ul class="menu-nav">
                        <li class="pr-0 prnew">
                            <div class="dropdown menutopright">
                                <button type="button" id="dropdownMenuButton-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php                                            
                                    if($currency_id = $this->session->userdata('currency')){} else {
                                        $currency_id = $this->db->get_where('business_settings', array('type' => 'currency'))->row()->value;
                                    }
                                    $symbol = $this->db->get_where('currency_settings',array('currency_settings_id'=>$currency_id))->row()->symbol;
                                    $c_name = $this->db->get_where('currency_settings',array('currency_settings_id'=>$currency_id))->row()->code;
                                    echo $c_name." (".$symbol.")"; ?> <i class="ion-ios-arrow-down"></i>
                                </button>
                                <ul class="dropdown-menu animation slideDownIn" aria-labelledby="dropdownMenuButton-3" style="">
                                    <?php
                                        $currencies = $this->db->get_where('currency_settings',array('status'=>'ok'))->result_array();
                                        foreach ($currencies as $row)
                                        {
                                        ?>
                                    <li>
                                        <a class="set_currency" currencyid="<?php echo $row['currency_settings_id']; ?>" data-href="<?php echo base_url(); ?>home/set_currency/<?php echo $row['currency_settings_id']; ?>">
                                        <?php echo $row['code']; ?> (<?php echo $row['symbol']; ?>)
                                        <?php if($currency_id == $row['currency_settings_id']){ ?>
                                        <i class="fa fa-check"></i>
                                        <?php } ?></a>
                                    </li>
                                    <?php
                                        }
                                        ?>
                                </ul>
                            </div>
                        </li>
                        <li class="pr-0">
                            <?php
                                if($set_lang = $this->session->userdata('language')){
                                
                                }else {
                                    $set_lang = $this->db->get_where('general_settings',array('type'=>'language'))->row()->value;
                                }
                                $lid = $this->db->get_where('language_list',array('db_field'=>$set_lang))->row()->language_list_id;
                                $lnm = $this->db->get_where('language_list',array('db_field'=>$set_lang))->row()->name;
                                ?>
                            <div class="dropdown menutopright">
                                <button type="button" id="dropdownMenuButton-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php
                                    if($set_lang = $this->session->userdata('language')){} else {
                                        $set_lang = $this->db->get_where('general_settings',array('type'=>'language'))->row()->value;
                                    }
                                    $lid = $this->db->get_where('language_list',array('db_field'=>$set_lang))->row()->language_list_id;
                                    $lnm = $this->db->get_where('language_list',array('db_field'=>$set_lang))->row()->name;
                                    ?>
                                <img src="assets/images/flag/1.jpg" alt="" /> <?php echo $lnm; ?> <i class="ion-ios-arrow-down"></i>
                                </button>
                                <ul class="dropdown-menu animation slideDownIn" aria-labelledby="dropdownMenuButton-3">
                                    <?php
                                        $langs = $this->db->get_where('language_list',array('status'=>'ok'))->result_array();
                                        foreach ($langs as $row)
                                        {
                                        ?>
                                    <li>
                                        <a class="set_langs" data-href="<?php echo base_url(); ?>home/set_language/<?php echo $row['db_field']; ?>" >
                                        <img src="assets/images/flag/1.jpg" alt="" /> <?php echo $row['name']; ?>
                                        <?php if($set_lang == $row['db_field']){ ?>
                                        <i class="fa fa-check"></i>
                                        <?php } ?>
                                        </a>
                                    </li>
                                    <?php
                                        }
                                        ?>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Header Nav End -->
<div class="header-top  headerheight d-xl-block  sticky-nav">
    <div class="container">
        <div class="row">
            <div class="col-lg-2 col-md-2 col-4 d-flex">
                <div class="logo main_logo">
                    <?php
                        $home_top_logo = $this->db->get_where('ui_settings',array('type' => 'home_top_logo'))->row()->value;
                        ?>
                    <a href="<?php echo base_url();?>"><img class="img-responsive" src="<?php echo base_url(); ?>uploads/logo_image/logo_<?php echo $home_top_logo; ?>.png" alt="OMGee" /></a>
                </div>
            </div>
            <div class="col-lg-5 col-md-4 col-12 align-self-center">
                <div class="header-right-element d-flex">
                    <div class="search-element media-body">
                        <?php
                            echo form_open(base_url() . 'home/text_search/', array(
                                'method' => 'post',
                                'accept-charset' => "UTF-8",'class'=>'d-flex'
                            ));
                            ?>
                                <input type="text" name="query"  accept-charset="utf-8" class="form-control enterclick" placeholder="<?php echo translate('what_are_you_looking_for');?>" />
                                <button class="entersubmit"><i class="icon-magnifier"></i></button>
                        </form>
                    </div>
                    <!--Cart info Start -->
                </div>
                <!--Cart info End -->
            </div>
            <div class="col-lg-5 col-md-6 align-self-center">
                <div class="header-tools d-flex">
                    <div class="cart-info d-flex align-self-center">
                        <div class="righttopmenu">
                            <img class="bouncenew" src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/1.png">
                            <?php if($this->session->userdata('user_login')!='yes'){ 
                                $earn =  $this->db->get_where('general_settings',array('type' => 'earn'))->row()->value; 
                                ?>
                            <a href="<?php echo base_url(); ?>home/login_set/login" >Earn <?php echo currency($earn); ?> from referral</a>
                            <?php }
                                else {
                                  $earn =  $this->db->get_where('general_settings',array('type' => 'earn'))->row()->value;
                                    ?>
                            <a href="<?php echo base_url().'home/refer'; ?>">Earn <?php echo currency($earn); ?> from referral</a>
                            <?php
                                } ?>
                        </div>
                        <div class="righttopmenu">
                            <img src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/2.png">
                            <a href="#">Get OMGee Extension</a>
                        </div>
                        <div class="righttopmenu">
                            <img src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/3.png">
                            <a href="<?php echo base_url().'home/cart_checkout'?>">(<span class="cart_num"></span>) <?php echo ucfirst(translate('cart')); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Header Nav End -->