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
$table_name = 'haccp_daily';
$typeary = array(1=>'Fridge', 2=>'Freezer', 3=>'Pests');
if(isset($_POST['action'])){
	$editid = $_POST['editid'];
	$deleteid = $_POST['deleteid'];
	$type = $_POST['type'];
	$name = $_POST['name'];
	$temperature = $_POST['temperature'];
	switch($_POST['action']) {
		case 'add':
			$wpdb->insert( 
				$table_name, // table name
				array( // data
					'daily_type' => $type, 
					'daily_name' => $name,
					'daily_default_value' => $temperature,
					'daily_status' => 1
				), 
				array( 
					'%d', 
					'%s',
					'%s',
					'%d' 
				) 
			);
			break;
		case 'update':
			$wpdb->update(
				$table_name, 
				array( 
					'daily_status' => 0
				), 
				array( 'daily_id' => $editid ), 
				array( 
					'%d' 
				), 
				array( '%d' ) 
			);

			$wpdb->update(
				$table_name, 
				array( 
					'daily_status' => 0
				), 
				array( 'daily_name' => $name ), 
				array( 
					'%d' 
				), 
				array( '%s' ) 
			);
			
			$wpdb->insert( 
				$table_name, // table name
				array( // data
					'daily_type' => $type, 
					'daily_name' => $name,
					'daily_default_value' => $temperature,
					'daily_status' => 1
				), 
				array( 
					'%d', 
					'%s',
					'%s',
					'%d' 
				) 
			);
			break;
		case 'delete':
			$wpdb->update(
				$table_name, 
				array( 
					'daily_status' => 0
				), 
				array( 'daily_id' => $deleteid ), 
				array( 
					'%d' 
				), 
				array( '%d' ) 
			);
			break;
	}
}
$rows = $wpdb->get_results("SELECT * from $table_name where daily_status=1 order by daily_id");

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>HACCP settings</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<?php
$plugin_url = plugin_dir_url( __FILE__ );

?>
<link rel="stylesheet" href="<?php echo $plugin_url . '../css/equip.css'; ?>">

<script type="text/javascript">
jQuery(document).ready(function(){
	// Activate tooltip
	jQuery('[data-toggle="tooltip"]').tooltip();
	jQuery('#editEquipModal').on('show.bs.modal', function (e) {
		var button = e.relatedTarget;
		jQuery('#editid').val(jQuery(button).attr('data-id'))
		jQuery('#ed_type').val(jQuery(button).attr('data-type'))
		changeType(document.getElementById('ed_type'), 'ed_temperature')
		jQuery('#ed_name').val(jQuery(button).attr('data-name'))
		jQuery('#ed_temperature').val(jQuery(button).attr('data-default'))
	});

	jQuery('#deleteEquipModal').on('show.bs.modal', function (e) {
		var button = e.relatedTarget;
		jQuery('#deleteid').val(jQuery(button).attr('data-id'))
		
	})
});

function changeType (obj, temp_id) {
	var fridges = ['Colder', 2, 3, 4, 5, 6, 'Too warm'];
	var freezers = ['Colder', -23, -22 ,-21, -20, -19, -18,  'Too warm']
	var pests = ['No', 'Yes'];
	var temp_obj = document.getElementById(temp_id);
	temp_obj.options.length = 0;
	if(obj.value == 1){
		fridges.forEach(function(fridge){
			temp_obj.options[temp_obj.options.length] = new Option(fridge, fridge);
		})
	}
	if(obj.value == 2){
		freezers.forEach(function(freezer){
			temp_obj.options[temp_obj.options.length] = new Option(freezer, freezer);
		})
	}
	if(obj.value == 3){
		pests.forEach(function(pest){
			temp_obj.options[temp_obj.options.length] = new Option(pest, pest);
		})
	}
}

</script>
</head>
<body>
    <div class="container">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
						<h2><b>Manage daily check items</b></h2>
					</div>
					<div class="col-sm-6">
						<a href="#addEquipModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add a new item</span></a>
						<!-- <a href="#deleteEmployeeModal" class="btn btn-danger" data-toggle="modal"><i class="material-icons">&#xE15C;</i> <span>Delete</span></a> -->						
					</div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
						<th>#
							
						</th>
                        <th>Type</th>
                        <th>Name</th>
						<th>Default setting</th>
						<th>Actions</th>
                    </tr>
                </thead>
                <tbody>
					<?php
						$i = 0;
						foreach($rows as $row) {
							echo '
								<tr id="'.($row->daily_id).'">
									<td>
									'.(++$i).'
									</td>
									<td>'.($typeary[$row->daily_type] ).'</td>
									<td>'.($row->daily_name).'</td>
									<td>'.($row->daily_default_value).'</td>
									<td>
										<a href="#editEquipModal" class="edit" 
											data-toggle="modal"
											data-id="'.$row->daily_id.'"
											data-type="'.$row->daily_type.'"
											data-name="'.$row->daily_name.'"
											data-default="'.$row->daily_default_value.'"
											>
											<i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
										<a href="#deleteEquipModal" class="delete" 
											data-toggle="modal"
											data-id="'.$row->daily_id.'"
											><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
									</td>
								</tr>
							';
						}
					?>
                    
                </tbody>
            </table>
			
        </div>
    </div>
	<!-- Add Modal HTML -->
	<div id="addEquipModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
					<input type="hidden" name="action" value="add" >
					<div class="modal-header">						
						<h4 class="modal-title">Add a new item</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">					
						<div class="form-group">
							<label>Type</label>
							<!-- <input type="text" class="form-control" required> -->
							<select class="form-control" name="type" id="type" onChange="changeType(this, 'temperature')">
								<option></option>
								<option value="1">Fridge</option>
								<option value="2">Freezer</option>
								<option value="3">Pests</option>
							</select>
						</div>
						<div class="form-group">
							<label>Name</label>
							<input type="text" class="form-control" name="name" id="name" required>
						</div>
						<div class="form-group">
							<label>Temperature</label>
							<select class="form-control" name="temperature" id="temperature">
								
							</select>
						</div>
									
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
						<input type="submit" class="btn btn-success" value="Add">
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- Edit Modal HTML -->
	<div id="editEquipModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
					<input type="hidden" name="action" value="update" >
					<input type="hidden" name="editid" id="editid"  >
					<div class="modal-header">						
						<h4 class="modal-title">Edit item</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">					
						<div class="form-group">
							<label>Type</label>
							<!-- <input type="text" class="form-control" required> -->
							<select class="form-control" name="type" id="ed_type" onChange="changeType(this, 'ed_temperature')">
								<option></option>
								<option value="1">Fridge</option>
								<option value="2">Freezer</option>
								<option value="3">Pests</option>
							</select>
						</div>
						<div class="form-group">
							<label>Name</label>
							<input type="text" class="form-control" name="name" id="ed_name" required>
						</div>
						<div class="form-group">
							<label>Temperature</label>
							<select class="form-control" name="temperature" id="ed_temperature">
								
							</select>
						</div>
									
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
						<input type="submit" class="btn btn-success" value="Update">
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- Delete Modal HTML -->
	<div id="deleteEquipModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
					<input type="hidden" name="action" value="delete" >
					<input type="hidden" name="deleteid" id="deleteid"  >
					<div class="modal-header">						
						<h4 class="modal-title">Delete items</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">					
						<p>Are you sure you want to delete this item?</p>
						<p class="text-warning"><small>This action cannot be undone.</small></p>
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
						<input type="submit" class="btn btn-danger" value="Delete">
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>                                		                            