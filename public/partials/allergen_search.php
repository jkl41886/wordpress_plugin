<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<?php
    global $wpdb;
    $plugin_url = plugin_dir_url( __FILE__ );
?>
<link rel="stylesheet" href="<?php echo $plugin_url . '../css/allergen_search.css'; ?>">


<?php 
    if($_POST['allergen_search']=='search') {
        $keyword_array = explode('|', $_POST['keywords']);
        // $header_ary = array();
        // foreach($keyword_array as $keyword) {
        //     $header_ary[$keyword] = array();
        // }
        // $in_array = implode('","', $keyword_array);
        $header_ary = array();

        if ($_POST['flag']==1) {
            $p1 = 'Ingredients to search for allergens';
            $p2 = 'MATCH what I entered';
            foreach($keyword_array as $keyword) {
                $sql = 'SELECT item_allergens_item as parentstr, allergen_name as childstr 
                FROM `haccp_item_allergens` 
                where item_allergens_item like "%'.$keyword.'%" order by item_allergens_item';
                $result = $wpdb->get_results($sql);
                foreach ($result as $row) {
                    if(!isset($header_ary[$row->parentstr])) {
                        $header_ary[$row->parentstr] = array();
                    }
                    array_push($header_ary[$row->parentstr], $row->childstr);
                }
            }
                
        } else {

            $p1 = 'Allergens to search for ingredients';
            $p2 = 'MATCH what I entered';
            foreach($keyword_array as $keyword) {
                $sql = 'SELECT allergen_name as parentstr, item_allergens_item as childstr 
                FROM `haccp_item_allergens` 
                where allergen_name like "%'.$keyword.'%" order by allergen_name ';
                $result = $wpdb->get_results($sql);
                foreach ($result as $row) {
                    if(!isset($header_ary[$row->parentstr])) {
                        $header_ary[$row->parentstr] = array();
                    }
                    array_push($header_ary[$row->parentstr], $row->childstr);
                }
            }
            
            
        }

?>
<style>
.transparent
{
    background: transparent;
    border: none;
    background-color: #a5957b7d;
}
</style>
<form method="POST" action="" id="allergen_results_form">
    <input type="hidden" name="allergen_search" value="goback"/>
    <div class="form-group">
        <div class="row">
            <p>You entered <?php echo $p1; ?> and you asked for the output to <?php echo $p2; ?>.</p>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <span>Search criteria</span>
            </div>
            <div class="col-sm-8">
                <span>Results</span>
            </div>
        </div>
        <?php 
            foreach ($header_ary as $key=>$children) {
                echo '
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="transparent">'.$key.'</div>
                        </div>
                        <div class="col-sm-8">
                            <div class="transparent">'.implode(', ', $children).'</div>
                        </div>
                    </div>
                    
                ';        
            }
        ?>
        <div class="row">
            <div class="col-sm-3">
                <button type="submit" class="form-control btn btn-info back"><i class="fa fa-backward"></i>  Go back</button>
            </div>

        </div>
    </div>
</form>

<?php        
    } else {
?>

<script type="text/javascript">
jQuery(document).ready(function(){
    jQuery(".add-new").click(function(){
         var row = '<div class="row">'+
                    '<div class="col-sm-4">'+
                        '<input type="text" class="form-control keyword" />'+
                    '</div>'+
                    '<div class="col-sm-2">'+
                        '<a class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>'+
                    '</div>'+
                '</div>';
        jQuery(".form-group").append(row);
        
    });
    jQuery(document).on("click", ".delete", function(){
        jQuery(this).parent().parent().remove();
    });
    var keywords = '';
    jQuery("#allergen_search_form").submit(function(){
        jQuery(this).find("input[type='text']").each(function(){
            if(jQuery.trim(jQuery(this).val()) != '') {
                if(keywords != '') {
                    keywords += '|';
                }
                keywords += jQuery(this).val();
            }
        });
        if(keywords == '') {
            return false;
        }
        jQuery("#keywords").val(keywords);
    });
});

</script>
<!-- <p>On this page you can search our products to understand what allergens are present. You can enter an ingredient name to find a list of allergens or you can enter an allergens to see a list of related products.
You can also decide if the output will show you ral the results which match your entered data or those that exclude the ectered data.
</p>

<p>If you are in Any doubt...</p>
-->    
<form method="POST" action="" id="allergen_search_form">
    <input type="hidden" name="keywords" id="keywords"/>
    <input type="hidden" name="allergen_search" value="search"/>
    <div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            <div class="row">
                <label for="flag">I want to enter:<br /></label>
            </div>
            <div class="row">
                <select class="form-control" id="flag" name="flag">
                    <option value="1">Ingredients to search for allergens</option>
                    <option value="2">Allergens to search for ingredients</option>
                </select>
            </div>
        </div>
        
    </div>
    
    <div class="row">
        <div class="col-sm-3">
            <button type="button" class="form-control btn btn-info add-new"><i class="fa fa-plus"></i>Add new item</button>
        </div>
        <div class="col-sm-3">
            <button type="submit" class="form-control btn btn-info submit"><i class="fa fa-save"></i>Submit</button>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <input type="text" class="form-control keyword" />
        </div>
        <div class="col-sm-2">
            <a class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
        </div>
    </div>
  </div>
  
</form>

<?php        
    }
?>