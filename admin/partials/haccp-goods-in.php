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
    
    if(isset($_POST['goods_post_data'])){
        $post_data = substr($_POST['goods_post_data'], 0, -1);
        $row_array = explode("|", $post_data);
        $datetime = date("Y-m-d H:i:s");
        
        foreach($row_array as $row){
            $cell_array = explode("@", $row);
            
            $wpdb->insert(
				"haccp_goods_in", // table name
				array( // data
					'goods_in_time' => $datetime, 
					'supplier_id' => $cell_array[0],
                    'product_id' => $cell_array[1],
                    'goods_in_description' => $cell_array[2],
                    'goods_in_batch' => $cell_array[3],
                    'goods_in_use_by' => $cell_array[4],
                    'goods_in_comments' => $cell_array[5]
				), 
				array( 
					'%s', 
					'%d',
					'%d',
					'%s',
                    '%s',
                    '%s',
                    '%s'
				) 
            );
        }
    }
    $rows = $wpdb->get_results("SELECT * from haccp_daily where daily_status=1 order by daily_type");
    $supplier_rows = $wpdb->get_results("SELECT supplier_id, supplier_name from haccp_suppliers where supplier_status=1 order by supplier_time");
    $supplier_option = '';
    foreach($supplier_rows as $supplier){
        $supplier_option .= '<option value="'.$supplier->supplier_id.'">'.$supplier->supplier_name.'</option>';
    }
    $product_rows = $wpdb->get_results("SELECT product_id, product_name from haccp_products where product_status=1 order by product_time");
    $product_option = '';
    foreach($product_rows as $product){
        $product_option .= '<option value="'.$product->product_id.'">'.$product->product_name.'</option>';
    }
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
<link rel="stylesheet" href="<?php echo $plugin_url . '../css/goods-in.css'; ?>">

<script type="text/javascript">
jQuery(document).ready(function(){
    var date_id = 1;
    jQuery('#from_date').datepicker({
        //comment the beforeShow handler if you want to see the ugly overlay
        dateFormat: 'yy-mm-dd',
        startDate: '-3d',
        beforeShow: function() {
            setTimeout(function(){
                jQuery('.ui-datepicker').css('z-index', 99999999999999);
            }, 0);
        }
    });		
    
    jQuery('#to_date').datepicker({
        //comment the beforeShow handler if you want to see the ugly overlay
        dateFormat: 'yy-mm-dd',
        startDate: '-3d',
        beforeShow: function() {
            setTimeout(function(){
                jQuery('.ui-datepicker').css('z-index', 99999999999999);
            }, 0);
        }
    });		
    
    jQuery(".save-data").click(function(){
        var save_data = '';
        var valid = true;
        jQuery("tbody").find("tr[class='add_row']").each(function() {
            if(jQuery(this).find("td:nth-child(5)").text() == '') {
                valid = false;
            }
            save_data += jQuery(this).find("input[class='supplier']").val()+"@"
                            +jQuery(this).find("input[class='product']").val()+"@"
                            +jQuery(this).find("td:nth-child(3)").text()+"@"
                            +jQuery(this).find("td:nth-child(4)").text()+"@"
                            +jQuery(this).find("td:nth-child(5)").text()+"@"
                            +jQuery(this).find("td:nth-child(6)").text()+"|"
        })
        if(valid == true){
            jQuery("#goods_post_data").val(save_data);
		    goods_save_form.submit();
        } else {
            alert('Please make the ‘Use by date’. ');
            return;
        }
        
    });
    var supplier_option = '<?php echo $supplier_option;  ?>'
    var product_option = '<?php echo $product_option;  ?>'
	jQuery('[data-toggle="tooltip"]').tooltip();
    // var actions = jQuery("table td:last-child").html();
    var actions = '<a class="add" title="Add" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>'+
        '<a class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>'+
        '<a class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>'+
        '<input type="hidden" class="supplier">'+
        '<input type="hidden" class="product">'
    // Append table with add row form on add new button click
    

    jQuery(".add-new").click(function(){
        jQuery(".save-data").attr("disabled", "disabled");
        var index = jQuery("table tbody tr:last-child").index();
        date_id++;
        var row = '<tr class="add_row">' +
            '<td><select id="supplier" class="form-control" name="supplier">'+supplier_option+'</select></td>' +
            '<td><select id="product" class="form-control" name="product">'+product_option+'</select></td>' +
            '<td><input type="text" class="form-control" name="description"></td>' +
            '<td><input type="text" class="form-control" name="batchnumber"></td>' +
            '<td><input type="text" class="form-control usedate" name="usedate" id="'+(date_id)+'" required></td>' +
            '<td><input type="text" class="form-control" name="comment" id="comment"></td>' +
            '<td>' + actions + '</td>' +
        '</tr>';
        jQuery("table").append(row);
        jQuery("#"+date_id).datepicker({
            //comment the beforeShow handler if you want to see the ugly overlay
            dateFormat: 'yy-mm-dd',
            startDate: '-3d',
            beforeShow: function() {
                setTimeout(function(){
                    jQuery('.ui-datepicker').css('z-index', 99999999999999);
                }, 0);
            }
        });		
        
		jQuery("table tbody tr").eq(index + 1).find(".add, .edit").toggle();
        jQuery('[data-toggle="tooltip"]').tooltip();
    });
    
    jQuery(document).on("click", ".add", function(){
		
        jQuery(this).parents("tr").find('select').each(function() {
            jQuery(this).parents("tr").find('input[class="'+jQuery(this).attr('id')+'"]').val(jQuery(this).val());
            jQuery(this).parent("td").html(jQuery(this).find( "option:selected" ).text())
        })

        jQuery(this).parents("tr").find('input[type="text"]').each(function() {
            jQuery(this).parent("td").html(jQuery(this).val());
        })
        
        jQuery(this).parents("tr").find(".add, .edit").toggle();
        if(jQuery(this).parents("table").find('select, input[type="text"]').length == 0) {
            jQuery(".save-data").removeAttr("disabled");
        }
		    
    });
	// Edit row on edit button click
	jQuery(document).on("click", ".edit", function(){
        date_id++
        jQuery(this).parents("tr").find("td:not(:last-child)").each(function(){
            if(jQuery(this).index() == 0) {

                jQuery(this).html('<select id="supplier" class="form-control" name="supplier">'+supplier_option+'</select>')
                jQuery(this).find('select[name="supplier"]').val(jQuery(this).parents("tr").find('input[class="supplier"]').val())
            } else if(jQuery(this).index() == 1) {

                jQuery(this).html('<select id="product" class="form-control" name="product">'+product_option+'</select>')
                jQuery(this).find('select[name="product"]').val(jQuery(this).parents("tr").find('input[class="product"]').val())
            } else if(jQuery(this).index() == 4) {

                jQuery(this).html('<input type="text" class="form-control" id="'+date_id+'" value="' + jQuery(this).text() + '">');
            } else {
                
                jQuery(this).html('<input type="text" class="form-control" value="' + jQuery(this).text() + '">');
            }
			
        });
        jQuery('#'+date_id).datepicker({
            //comment the beforeShow handler if you want to see the ugly overlay
            dateFormat: 'yy-mm-dd',
            startDate: '-3d',
            beforeShow: function() {
                setTimeout(function(){
                    jQuery('.ui-datepicker').css('z-index', 99999999999999);
                }, 0);
            }
        });		
		jQuery(this).parents("tr").find(".add, .edit").toggle();
		jQuery(".save-data").attr("disabled", "disabled");
    });
	// Delete row on delete button click
	jQuery(document).on("click", ".delete", function(){
        jQuery(this).parents("tr").remove();
		if(jQuery(this).parents("table").find('select, input[type="text"]').length == 0) {
            jQuery(".save-data").removeAttr("disabled");
        }
    });

    $( "#csv_form" ).submit(function( event ) {
        $('#viewLogModal').modal('toggle');
        return true;
    });

});
</script>
</head>
<body>
    <div class="container">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-8"><h2>Goods <b>In</b></h2></div>
                    <div class="col-sm-4">
                        <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST" name="goods_save_form">
                            <input type="hidden" name="goods_post_data" id="goods_post_data" />
                        </form>
                        <div class="row">
                            <div class="col-sm-4">
                                <button type="button" class="btn btn-info add-new"><i class="fa fa-plus"></i> Add</button>
                            </div>
                            <div class="col-sm-4">
                                <button type="button" class="btn btn-info save-data"><i class="fa fa-save"></i> Save</button>
                            </div>
                            <div class="col-sm-4">
                                <a href="#viewLogModal" class="btn btn-info view-log" data-toggle="modal"><i class="fa fa-server"></i> <span>View log</span></a>
                                <!-- <button type="button" class="btn btn-info view-log"><i class="fa fa-server"></i> View log</button> -->
                            </div>
                        </div>
                        
                    </div>
                    
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Supplier</th>
                        <th>Product</th>
                        <th>Description</th>
                        <th>Batch number</th>
                        <th>Use by date</th>
                        <th>Comments</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                  
                </tbody>
            </table>
        </div>
    </div>     
    <!-- viewlog Modal HTML -->
	<div id="viewLogModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="csv_form" action="" method="POST">
                    <input type="hidden" name="download_goodsin" value = "csv" />
					<div class="modal-header">						
						<h4 class="modal-title">View Log</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">	
                        <div class = "row">
                            <div class="form-group col-sm-6">
                                <label>From date</label>
                                <input autocomplete="off" type="text" class="form-control" name="from_date" id="from_date" required>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>To date</label>
                                <input autocomplete="off" type="text" class="form-control" name="to_date" id="to_date" required>
                            </div>
                        </div>
                        
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
						<input type="submit" class="btn btn-success" value="Download CSV">
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>                            