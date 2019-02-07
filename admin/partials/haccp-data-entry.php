<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       localhost
 * @since      1.0.0
 *
 * @package    Haccp
 * @subpackage Haccp/admin/partials
 */

$active="class='active'";
?>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<!--<script src="//code.jquery.com/jquery-1.11.1.min.js"></script> -->
<style>
.with-nav-tabs.panel-primary .nav-tabs > li > a,
.with-nav-tabs.panel-primary .nav-tabs > li > a:hover,
.with-nav-tabs.panel-primary .nav-tabs > li > a:focus {
    color: #fff;
}
.with-nav-tabs.panel-primary .nav-tabs > .open > a,
.with-nav-tabs.panel-primary .nav-tabs > .open > a:hover,
.with-nav-tabs.panel-primary .nav-tabs > .open > a:focus,
.with-nav-tabs.panel-primary .nav-tabs > li > a:hover,
.with-nav-tabs.panel-primary .nav-tabs > li > a:focus {
	color: #fff;
	background-color: #3071a9;
	border-color: transparent;
}
.with-nav-tabs.panel-primary .nav-tabs > li.active > a,
.with-nav-tabs.panel-primary .nav-tabs > li.active > a:hover,
.with-nav-tabs.panel-primary .nav-tabs > li.active > a:focus {
	color: #428bca;
	background-color: #fff;
	border-color: #428bca;
	border-bottom-color: transparent;
}
.with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu {
    background-color: #428bca;
    border-color: #3071a9;
}
.with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > li > a {
    color: #fff;   
}
.with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > li > a:hover,
.with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > li > a:focus {
    background-color: #3071a9;
}
.with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > .active > a,
.with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > .active > a:hover,
.with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > .active > a:focus {
    background-color: #4a9fe9;
}
</style>
<script>
</script>
<div class="panel with-nav-tabs panel-primary">
    <div class="panel-heading">
            <ul class="nav nav-tabs">
                <li <?php if(!isset($_GET['tab']) || $_GET['tab']=='equip' ) echo $active; ?> ><a href="<?php echo $_SERVER['REQUEST_URI']."&tab=equip" ?>" >Daily checks setup</a></li>
                <li <?php if($_GET['tab']=='supplier' ) echo $active; ?> ><a href="<?php echo $_SERVER['REQUEST_URI']."&tab=supplier" ?>">Suppliers</a></li>
                <li <?php if($_GET['tab']=='product' ) echo $active; ?> ><a href="<?php echo $_SERVER['REQUEST_URI']."&tab=product" ?>">Products</a></li>
                <li <?php if($_GET['tab']=='allergens' ) echo $active; ?> ><a href="<?php echo $_SERVER['REQUEST_URI']."&tab=allergens" ?>">Allergens</a></li>
                <!-- <li><a href="#tab2primary" data-toggle="tab">Suppliers</a></li>
                <li><a href="#tab3primary" data-toggle="tab">Products</a></li>
                <li><a href="#tab4primary" data-toggle="tab">Allergens</a></li> -->
                <!-- <li class="dropdown">
                    <a href="#" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#tab4primary" data-toggle="tab">Primary 4</a></li>
                        <li><a href="#tab5primary" data-toggle="tab">Primary 5</a></li>
                    </ul>
                </li> -->
            </ul>
    </div>
    <div class="panel-body">
        <div class="tab-content">
            <div class="tab-pane fade in active" id="tab1primary">
            <?php 
                if(!isset($_GET['tab']) || $_GET['tab']=='equip' )
                    include('equip.php'); 
                if($_GET['tab']=='supplier' )
                    include('suppliers.php'); 
                if($_GET['tab']=='product' )
                    include('products.php');
                if($_GET['tab']=='allergens' )
                    include('allergens.php');
            ?>
            </div>
            <!-- <div class="tab-pane fade" id="tab2primary">
            </div>
            <div class="tab-pane fade" id="tab3primary"><?php //include('products.php'); ?></div>
            <div class="tab-pane fade" id="tab4primary"><?php //include('allergens.php'); ?></div>
             <div class="tab-pane fade" id="tab4primary">Primary 4</div>
            <div class="tab-pane fade" id="tab5primary">Primary 5</div> -->
        </div>
    </div>
</div>