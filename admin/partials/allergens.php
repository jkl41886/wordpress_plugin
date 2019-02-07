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
$table_name = 'haccp_allergen_sub';

if(isset($_POST['action'])){
	$editid = $_POST['editid'];
	$deleteid = $_POST['deleteid'];
	$allergenid = $_POST['category'];
	$name = $_POST['name'];
	switch($_POST['action']) {
		case 'add':
			$wpdb->insert(
				$table_name, // table name
				array( // data
					'allergen_id' => $allergenid,
					'allergen_sub_name' => $name,
					'allergen_sub_status' => 1
				),
				array( 
					'%d', 
					'%s',
					'%d' 
				) 
			);
			break;
		case 'update':
			$wpdb->update(
				$table_name, 
				array( 
					'allergen_sub_status' => 0
				), 
				array( 'allergen_sub_id' => $editid ), 
				array( 
					'%d' 
				), 
				array( '%d' ) 
			);
			$wpdb->update(
				$table_name, 
				array( 
					'allergen_sub_status' => 0
				), 
				array( 'allergen_sub_name' => $name ), 
				array( 
					'%d' 
				), 
				array( '%s' ) 
			);
			$wpdb->insert(
				$table_name, // table name
				array( // data
					'allergen_id' => $allergenid,
					'allergen_sub_name' => $name,
					'allergen_sub_status' => 1
				),
				array( 
					'%d', 
					'%s',
					'%d' 
				) 
			);
			break;
		case 'delete':
		$wpdb->update(
			$table_name, 
				array( 
					'allergen_sub_status' => 0
				), 
				array( 'allergen_sub_id' => $deleteid ), 
				array( 
					'%d' 
				), 
				array( '%d' ) 
			);
		break;
	}
}
$rows = $wpdb->get_results("SELECT * from $table_name where allergen_sub_status=1 order by allergen_id,allergen_sub_id");
$allergen_parents = $wpdb->get_results("SELECT allergen_id, allergen_name from haccp_allergen where allergen_status=1 order by allergen_id");
$allergen_array = array();

foreach($allergen_parents as $allergen_parent){
	$allergen_array[$allergen_parent->allergen_id] = $allergen_parent->allergen_name;
}

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
<link rel="stylesheet" href="<?php echo $plugin_url . '../css/allergens.css'; ?>">

<script type="text/javascript">
jQuery(document).ready(function(){
	// Activate tooltip
	jQuery('[data-toggle="tooltip"]').tooltip();
	
	jQuery('#addAllergenModal').on('show.bs.modal', function (e) {
		
	});
	jQuery('#editAllergenModal').on('show.bs.modal', function (e) {
		var button = e.relatedTarget;
		jQuery('#editid').val(jQuery(button).attr('data-id'))
		jQuery('#ed_category').val(jQuery(button).attr('data-category'))
		jQuery('#ed_name').val(jQuery(button).attr('data-name'))
	});
	jQuery('#deleteAllergenModal').on('show.bs.modal', function (e) {
		var button = e.relatedTarget;
		jQuery('#deleteid').val(jQuery(button).attr('data-id'))
		
	})
});


</script>
</head>
<body>
    <div class="container">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
						<h2>Manage <b>Allergens</b></h2>
					</div>
					<div class="col-sm-6">
						<a href="#addAllergenModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add New Allergen</span></a>
						<!-- <a href="#deleteEmployeeModal" class="btn btn-danger" data-toggle="modal"><i class="material-icons">&#xE15C;</i> <span>Delete</span></a> -->						
					</div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
						<th>#
							
						</th>
                        <th>Category</th>
						<th>Name</th>
						<th>Actions</th>
                    </tr>
                </thead>
                <tbody>
					<?php
						$i = 0;
						foreach($rows as $row) {
							echo '
								<tr id="'.($row->allergen_sub_id).'">
									<td>
									'.(++$i).'
									</td>
									<td>'.($allergen_array[$row->allergen_id] ).'</td>
									<td>'.($row->allergen_sub_name).'</td>
									<td>
										<a href="#editAllergenModal" class="edit" 
											data-toggle="modal"
											data-id="'.$row->allergen_sub_id.'"
											data-category="'.$row->allergen_id.'"
											data-name="'.$row->allergen_sub_name.'"
											>
											<i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
										<a href="#deleteAllergenModal" class="delete" 
											data-toggle="modal"
											data-id="'.$row->allergen_sub_id.'"
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
	<div id="addAllergenModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
					<input type="hidden" name="action" value="add" >
					<div class="modal-header">						
						<h4 class="modal-title">Add Allergen</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">					
						<div class="form-group">
							<label>Category</label>
							<select class="form-control" name="category" id="category" required>
								<option></option>
								<?php
								foreach($allergen_array as $key=>$category){
									echo '<option value="'.$key.'">'.$category.'</option>';
								}
								?>
								
							</select>
						</div>
						<div class="form-group">
							<label>Name</label>
							<input type="text" class="form-control" name="name" id="name" required>
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
	<div id="editAllergenModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
					<input type="hidden" name="action" value="update" >
					<input type="hidden" name="editid" id="editid"  >
					<div class="modal-header">						
						<h4 class="modal-title">Edit Allergen</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">					
						<div class="form-group">
							<label>Category</label>
							<!-- <input type="text" class="form-control" required> -->
							<select class="form-control" name="category" id="ed_category">
							<option></option>
							<?php
							foreach($allergen_array as $key=>$category){
								echo '<option value="'.$key.'">'.$category.'</option>';
							}
							?>
							</select>
						</div>
						<div class="form-group">
							<label>Name</label>
							<input type="text" class="form-control" name="name" id="ed_name" required>
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
	<div id="deleteAllergenModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
					<input type="hidden" name="action" value="delete" >
					<input type="hidden" name="deleteid" id="deleteid"  >
					<div class="modal-header">						
						<h4 class="modal-title">Delete Allergen</h4>
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