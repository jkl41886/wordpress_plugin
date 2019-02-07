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
    $typeary = array(1=>'Fridge', 2=>'Freezer', 3=>'Pests');
    $datetime = date("Y-m-d H:i:s");
    $status = 'get';
    if(isset($_POST['post_data'])){
        $post_data = substr($_POST['post_data'], 0, -1);
        $row_array = explode("|", $post_data);
        
        foreach($row_array as $row){
            $cell_array = explode("@", $row);
            
            $wpdb->insert(
				"haccp_daily_checks", // table name
				array( // data
					'daily_checks_time' => $datetime, 
					'equipment_id' => $cell_array[0],
                    'daily_checks_name' => $cell_array[1],
                    'daily_checks_actual_value' => $cell_array[2],
                    'daily_checks_comments' => $cell_array[3]
				), 
				array( 
					'%s', 
					'%d',
					'%s',
                    '%s',
                    '%s'
				) 
            );
        }
        $lastid = $wpdb->insert_id;
        //$notification_result = $wpdb->get_results('select count(daily_checks_id) as cnt from haccp_daily_checks where daily_checks_time="'.$datetime.'" ');
        // if($notification_result->cnt>0) {
        //     $status = 'success';
        // } else {
        //     $status = 'error';
        // }
        if($lastid>0) {
            $status = 'success';
        } else {
            $status = 'error';
        }
    }
    
    $rows = $wpdb->get_results("SELECT * from haccp_daily where daily_status=1 order by daily_type");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Haccp daily checks</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<?php
    $plugin_url = plugin_dir_url( __FILE__ );
?>
<link rel="stylesheet" href="<?php echo $plugin_url . '../css/daily-checks.css'; ?>">

<script type="text/javascript">
jQuery(document).ready(function(){

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

	jQuery('[data-toggle="tooltip"]').tooltip();
	var actions = jQuery("table td:last-child").html();
	// Append table with add row form on add new button click
    jQuery(".add-new").click(function(){
        var save_data = '';
        jQuery("tbody").find("tr").each(function() {
            save_data += jQuery(this).attr("id")+"@"
                            +jQuery(this).find("td:nth-child(1)").text()+"@"
                            +jQuery(this).find("td:nth-child(3)").text()+"@"
                            +jQuery(this).find("td:nth-child(4)").text()+"|"
        })
        jQuery("#post_data").val(save_data);
		save_form.submit();
    });
	// Add row on add button click
	jQuery(document).on("click", ".add", function(){
		// var empty = false;
		
        jQuery(this).parents("tr").find('select, input[type="text"]').each(function() {
            jQuery(this).parent("td").html(jQuery(this).val());
        })
        jQuery(this).parents("tr").find(".add, .edit").toggle();
        if(jQuery(this).parents("table").find('select, input[type="text"]').length == 0) {
            jQuery(".add-new").removeAttr("disabled");
        }
		    
    });
	// Edit row on edit button click
	jQuery(document).on("click", ".edit", function(){
        jQuery(this).parents("tr").find("td:nth-child(3), td:nth-child(4)").each(function(){
            if(jQuery(this).index() == 2) {
                let fridges = ['Colder', 2, 3, 4, 5, 6, 'Too warm'];
                let freezers = ['Colder', -23, -22 ,-21, -20, -19, -18,  'Too warm']
                let pests = ['No', 'Yes'];
                const origin_value = jQuery(this).text();
                jQuery(this).html('<select id="'+jQuery(this).parents("tr").index()+'_temperature"></select>');
                let temp_obj = document.getElementById(jQuery(this).parents("tr").index()+"_temperature");
                temp_obj.options.length = 0;
                if(jQuery(this).parents("tr").find("td:nth-child(2)").text() == "Fridge"){
                    fridges.forEach(function(fridge){
                        temp_obj.options[temp_obj.options.length] = new Option(fridge, fridge);
                    })
                }
                if(jQuery(this).parents("tr").find("td:nth-child(2)").text() == "Freezer"){
                    freezers.forEach(function(freezer){
                        temp_obj.options[temp_obj.options.length] = new Option(freezer, freezer);
                    })
                }
                if(jQuery(this).parents("tr").find("td:nth-child(2)").text() == "Pests"){
                    pests.forEach(function(pest){
                        temp_obj.options[temp_obj.options.length] = new Option(pest, pest);
                    })
                }
                temp_obj.value = origin_value
            }
            if(jQuery(this).index() == 3) {
                jQuery(this).html('<input type="text" class="form-control" value="' + jQuery(this).text() + '">');
            }
			
		});
		jQuery(this).parents("tr").find(".add, .edit").toggle();
		jQuery(".add-new").attr("disabled", "disabled");
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
        <?php 
            if($status == 'success') {
                echo '
                    <div class="alert alert-success alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Success!</strong> Your submit is successfully.
                    </div>        
                ';
            } else if($status == 'error') {
                echo '
                <div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Error!</strong> Please retry or ask.
                </div>        
                ';
            }
        ?>
        
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-8"><h2><b>Daily Checks</b></h2></div>
                    <div class="col-sm-2">
                        <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST" name="save_form">
                            <input type="hidden" name="post_data" id="post_data" />
                        </form>
                        <button type="button" class="btn btn-info add-new"><i class="fa fa-save"></i> Save</button>
                    </div>
                    <div class="col-sm-2">
                        <a href="#viewLogModal" class="btn btn-info view-log" data-toggle="modal"><i class="fa fa-server"></i> <span>View log</span></a>
                    <!-- <button type="button" class="btn btn-info view-log"><i class="fa fa-server"></i> View log</button> -->
                    </div>
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Type</th>
                        <th>Temperature</th>
                        <th>Comments</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                  <?php 
                      foreach($rows as $row) {
                        echo '
                          <tr id="'.($row->daily_id).'">
                           
                            <td>'.($row->daily_name).'</td>
                            <td>'.($typeary[$row->daily_type] ).'</td>
                            <td>'.($row->daily_default_value).'</td>
                            <td></td>
                            <td>
                              <a class="add" title="Add" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
                              <a class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                            </td>
                          </tr>
                        ';
                      }
                  ?>
                                        
                </tbody>
            </table>
        </div>
    </div>     
    <!-- viewlog Modal HTML -->
	<div id="viewLogModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="csv_form" action="" method="POST">
                    <input type="hidden" name="download_dailychecks" value = "csv" />
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
						<input type="submit" class="btn btn-success"  value="Download CSV">
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>                            