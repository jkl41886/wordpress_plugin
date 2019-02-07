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

    global $wpdb;
    if($_POST['action'] == "save"){
        foreach($_POST as $key=>$value){
            $temp = explode("_", $key);
            if($temp[0] == "sub"){
                $wpdb->insert(
                    "haccp_item_allergens", // table name
                    array( // data
                        'item_allergens_item' => $_POST['product_name'], 
                        'allergen_name' => $temp[2],
                        'allergen_type' => $temp[0],
                        'allergen_sub_item_id' => $temp[1]
                    ), 
                    array( 
                        '%s', 
                        '%s',
                        '%s',
                        '%d'
                    ) 
                );
            } else if($temp[0] == "parent"){
                $wpdb->insert(
                    "haccp_item_allergens", // table name
                    array( // data
                        'item_allergens_item' => $_POST['product_name'], 
                        'allergen_name' => $temp[2],
                        'allergen_type' => $temp[0],
                        'allergen_id' => $temp[1]
                    ), 
                    array( 
                        '%s', 
                        '%s',
                        '%s',
                        '%d'
                    ) 
                );
            } else if($temp[0] == "none") {
                $wpdb->insert(
                    "haccp_item_allergens", // table name
                    array( // data
                        'item_allergens_item' => $_POST['product_name'], 
                        'allergen_name' => $temp[0],
                        'allergen_type' => $temp[0],
                        'allergen_id' => -1,
                        'allergen_sub_item_id' => -1
                    ), 
                    array(
                        '%s', 
                        '%s',
                        '%d',
                        '%d',
                        '%d'
                    ) 
                );
            }
        }
    }

    // $saved_data_rows = $wpdb->get_results('select allergen_name, allergen_id, allergen_sub_item_id from haccp_item_allergens where 1 ');
    
    // $saved_data_array = array();
    // foreach($saved_data_rows as $saved_data) {
    //     if($saved_data->allergen_name=="none"){
    //         array_push($saved_data_array, "none");
    //     } else if($saved_data->allergen_name=="sub"){
    //         array_push($saved_data_array,"sub_".$saved_data->allergen_sub_item_id);
    //     } else if($saved_data->allergen_name=="parent"){
    //         array_push($saved_data_array,"parent_".$saved_data->allergen_id);
    //     }
    // }
    
    $category_rows = $wpdb->get_results('select allergen_id, allergen_name from haccp_allergen where allergen_status=1 order by allergen_id');

    $allergens_rows = $wpdb->get_results('select allergen_sub_id ,allergen_id, allergen_sub_name from haccp_allergen_sub where allergen_sub_status=1 order by allergen_id');
    $allergens_array = array();
    
    foreach($allergens_rows as $allergens) {
        
        if(!isset($allergens_array[$allergens->allergen_id])) {
            $allergens_array[$allergens->allergen_id] = array();
        }
        array_push($allergens_array[$allergens->allergen_id],array($allergens->allergen_sub_id, $allergens->allergen_sub_name));
        //$allergens_array[$allergens->allergen_id] = array($allergens->allergen_sub_id, $allergens->allergen_sub_name);
    }
    // var_dump($allergens_array); exit;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Goods in</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<?php
    $plugin_url = plugin_dir_url( __FILE__ );
?>
<link rel="stylesheet" href="<?php echo $plugin_url . '../css/haccp-allergens1.css'; ?>">

<script type="text/javascript">
jQuery(document).ready(function(){
    var checkbox = jQuery('table tbody input[type="checkbox"]:not(input[id="ch0"])');
    jQuery("#ch0").change(function(){
        if(this.checked){
            checkbox.each(function(){
                this.checked = false;    
            });
        } else {
            checkbox.each(function(){
                this.checked = true;
            });
        }
        
    })
	jQuery("#check_all").click(function(){
        checkbox.each(function(){
            this.checked = true;  
        });
        jQuery("#ch0").prop("checked", false);
        
    });
    jQuery("#uncheck_all").click(function(){
        checkbox.each(function(){
            this.checked = false;
        });
        jQuery("#ch0").prop("checked", true);
        
    });
    jQuery("#save_data").click(function(){
        if(jQuery("#product_name").val() == ''){
            return;
        }
        jQuery("#action").val("save");
        jQuery("#allergens_form").attr("method","POST");
        jQuery("#allergens_form").submit();
        
    });
    
    
});

</script>
</head>
<body>
    <div class="container">
    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" name="allergens_form" id="allergens_form">
        <input type="hidden" name="action" id="action" />
        <div class="table-wrapper">
            <div class="table-title">

                <div class="row">
                    <div class="col-sm-4"><h2>Allergens</h2></div>
                    <div class="col-sm-4 form-group" >
                        <input placeholder="Product Name" class="form-control" type="text" name="product_name" id="product_name" autocomplete="off" required autofocus/>
                    </div>
                    <div class="col-sm-4">
                        
                        <div class="row">
                            <div class="col-sm-4">
                                <button id="check_all" type="button" class="btn btn-info add-new"><i class="fa fa-check-square-o"></i> Check All</button>
                            </div>
                            <div class="col-sm-4">
                                <button id="uncheck_all" type="button" class="btn btn-info save-data"><i class="fa fa-square-o"></i> Uncheck All</button>
                            </div>
                            <div class="col-sm-4">
                                <button id="save_data" type="submit" class="btn btn-info view-log"><i class="fa fa-save"></i> Submit</button>
                            </div>
                        </div>
                        
                    </div>
                    
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Allergens</th>
                    </tr>
                </thead>
                <tbody>
                    <tr id="0">
                        <td>None</td>
                        <td>
                            <input id="ch0" type="checkbox" name="none" value="-1" />
                            <label for="ch0">None</label>
                        </td>
                    </tr>
                    <?php 
                        foreach($category_rows as $category){
                            echo '<tr id="'.$category->allergen_id.'">';
                                echo '<td>'.$category->allergen_name.'</td>';
                                echo '<td>';
                                if(isset($allergens_array[$category->allergen_id])){
                                    foreach ($allergens_array[$category->allergen_id] as $allergen_sub_array) {
                                        // $checked = array_search('sub_'.$allergen_sub_array[0], $saved_data_array)>-1?"checked":"" ;
                                        echo '<input class="allergen_check" id="sub_'.$allergen_sub_array[0].'" type="checkbox" name="sub_'.$allergen_sub_array[0].'_'.$allergen_sub_array[1].'" checked  />
                                                <label for="sub_'.$allergen_sub_array[0].'">'.$allergen_sub_array[1].'</label>
                                                ';
                                        
                                    }
                                } else {
                                    // $checked = array_search('parent_'.$category->allergen_id, $saved_data_array)>-1?"checked":"" ;
                                    echo '<input class="allergen_check" id="parent_'.$category->allergen_id.'" type="checkbox" name="parent_'.$category->allergen_id.'_'.$category->allergen_name.'" checked />
                                            <label for="parent_'.$category->allergen_id.'">'.$category->allergen_name.'</label>
                                            ';
                                }
                                
                                echo '</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>   
    </form>
  
</body>
</html>                            