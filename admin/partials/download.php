<?php
    function goodsin_csv () {
        global $wpdb;
        $fromdate = $_POST['from_date'];
        $todate = $_POST['to_date'];
        $next_date = date('Y-m-d', strtotime($todate .' +1 day'));
        $sql = "SELECT haccp_goods_in.goods_in_time,haccp_suppliers.supplier_name, haccp_products.product_name, haccp_goods_in.goods_in_use_by, haccp_goods_in.goods_in_batch, haccp_goods_in.goods_in_description, haccp_goods_in.goods_in_comments FROM haccp_goods_in
                LEFT JOIN haccp_suppliers on (haccp_goods_in.supplier_id=haccp_suppliers.supplier_id)
                LEFT JOIN haccp_products on (haccp_goods_in.product_id=haccp_products.product_id)
                WHERE goods_in_time>'".$fromdate."' and goods_in_time<'".$next_date."' 
                order by haccp_goods_in.goods_in_time desc
        ";
        // echo $sql; exit;
        $csv_output="date time, supplier, product, use by date, batch, description, comment";
        $csv_output .= "\n";
        
        $results = $wpdb->get_results($sql,ARRAY_A );
        if(count($results) > 0){
            foreach($results as $result){
                $result = array_values($result);
                $result = implode(", ", $result);
                $csv_output .= $result."\n"; 
            }
        }

        $filename = "goodsin_".date("Y-m-d_H-i",time());
        header("Content-type: application/vnd.ms-excel");
        header("Content-disposition: csv" . date("Y-m-d") . ".csv");
        header( "Content-disposition: filename=".$filename.".csv");
        print $csv_output;
        exit;
        
    }

    function daily_checks_csv () {
        global $wpdb;
        $fromdate = $_POST['from_date'];
        $todate = $_POST['to_date'];
        $next_date = date('Y-m-d', strtotime($todate .' +1 day'));
        $sql = "SELECT haccp_daily_checks.daily_checks_time,haccp_daily.daily_name, 
                    IF(haccp_daily.daily_type=1,'Fridge', IF(haccp_daily.daily_type=2, 'Freezer', 'Pests')), 
                    haccp_daily_checks.daily_checks_actual_value, haccp_daily_checks.daily_checks_comments FROM haccp_daily_checks
                LEFT JOIN haccp_daily on (haccp_daily_checks.equipment_id=haccp_daily.daily_id)
                WHERE daily_checks_time>'".$fromdate."' and daily_checks_time<'".$next_date."'
                order by haccp_daily_checks.daily_checks_time desc
        ";
        // echo $sql; exit;
        $csv_output="date time, name, type, actual_value, comment";
        $csv_output .= "\n";
        
        $results = $wpdb->get_results($sql,ARRAY_A );
        if(count($results) > 0){
            foreach($results as $result){
                $result = array_values($result);
                $result = implode(", ", $result);
                $csv_output .= $result."\n"; 
            }
        }

        $filename = "daily_checks_".date("Y-m-d_H-i",time());
        header("Content-type: application/vnd.ms-excel");
        header("Content-disposition: csv" . date("Y-m-d") . ".csv");
        header( "Content-disposition: filename=".$filename.".csv");
        print $csv_output;
        exit;
    }
?>