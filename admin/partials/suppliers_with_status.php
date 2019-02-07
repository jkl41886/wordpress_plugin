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
$table_name = 'haccp_suppliers';
if(isset($_POST['action'])){
	$editid = $_POST['editid'];
	$deleteid = $_POST['deleteid'];
	$name = $_POST['name'];
	$status = $_POST['status'];
	switch($_POST['action']) {
		case 'add':
			$wpdb->insert( 
				$table_name, // table name
				array( // data
					'supplier_name' => $name,
					'supplier_status' => $status
				), 
				array( 
					'%s',
					'%d' 
				) 
			);
			break;
		case 'update':
			$wpdb->update(
				$table_name, 
				array( 
					'supplier_name' => $name,
					'supplier_status' => $status
				), 
				array( 'supplier_id' => $editid ), 
				array( 
					'%s',
					'%d' 
				), 
				array( '%d' ) 
			);
			break;
		case 'delete':
			$wpdb->delete( $table_name, array( 'supplier_id' => $deleteid ) );
			break;
	}
}
$rows = $wpdb->get_results("SELECT * from $table_name order by supplier_id");

?>

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
<link rel="stylesheet" href="<?php echo $plugin_url . '../css/supplier.css'; ?>">

<script type="text/javascript">
jQuery(document).ready(function(){
	// Activate tooltip
	jQuery('[data-toggle="tooltip"]').tooltip();
	
	jQuery('#editSupplierModal').on('show.bs.modal', function (e) {
		var button = e.relatedTarget;
		jQuery('#editid').val(jQuery(button).attr('data-id'))
		jQuery('#ed_name').val(jQuery(button).attr('data-name'))
		
		jQuery('#ed_status').val(jQuery(button).attr('data-status'))
		jQuery('#ed_status').prop('checked', jQuery(button).attr('data-status')==1) 
	});

	jQuery('#deleteSupplierModal').on('show.bs.modal', function (e) {
		var button = e.relatedTarget;
		jQuery('#deleteid').val(jQuery(button).attr('data-id'))
		
	})
});

function checkTerms(checkObj, hideid) {
	if(checkObj.checked){
		document.getElementById(hideid).disabled=true;
		checkObj.value = 1;
	} else {
		checkObj.value = 0;
		document.getElementById(hideid).disabled=false;
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
						<h2>Manage <b>Suppliers</b></h2>
					</div>
					<div class="col-sm-6">
						<a href="#addSupplierModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add New Supplier</span></a>
					</div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
						<th>#</th>
                        <th>Name</th>
						<th>Status</th>
                    </tr>
                </thead>
                <tbody>
					<?php
						$i = 0;
						foreach($rows as $row) {
							echo '
								<tr id="'.($row->supplier_id).'">
									<td>
									'.(++$i).'
									</td>
									<td>'.($row->supplier_name).'</td>
									<td><input type="checkbox" '.($row->supplier_status==1?"checked":"").' ></td>
									<td>
										<a href="#editSupplierModal" class="edit" 
											data-toggle="modal"
											data-id="'.$row->supplier_id.'"
											data-name="'.$row->supplier_name.'"
											data-status="'.$row->supplier_status.'"
											>
											<i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
										<a href="#deleteSupplierModal" class="delete" 
											data-toggle="modal"
											data-id="'.$row->supplier_id.'"
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
	<div id="addSupplierModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
					<input type="hidden" name="action" value="add" >
					<div class="modal-header">						
						<h4 class="modal-title">Add Supplier</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">					
						<div class="form-group">
							<label>Name</label>
							<input type="text" class="form-control" name="name" id="name" required>
						</div>
						<div class="form-group">
							<label>Status</label>
							<input type="checkbox" class="form-control" name="status" id="status" value="1" onclick="checkTerms(this, 'statusHidden');" checked>
							<input id='statusHidden' type='hidden' value='0' name='status' disabled>
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
	<div id="editSupplierModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
					<input type="hidden" name="action" value="update" >
					<input type="hidden" name="editid" id="editid"  >
					<div class="modal-header">						
						<h4 class="modal-title">Edit Supplier</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">					
						<div class="form-group">
							<label>Name</label>
							<input type="text" class="form-control" name="name" id="ed_name" required>
						</div>
						<div class="form-group">
							<label>Status</label>
							<input type="checkbox" class="form-control" name="status" id="ed_status" value="1" onclick="checkTerms(this,'ed_statusHidden');" checked>
							<input id='ed_statusHidden' type='hidden' value='0' name='status' disabled>
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
	<div id="deleteSupplierModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
					<input type="hidden" name="action" value="delete" >
					<input type="hidden" name="deleteid" id="deleteid"  >
					<div class="modal-header">						
						<h4 class="modal-title">Delete Supplier</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">					
						<p>Are you sure you want to delete these Records?</p>
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