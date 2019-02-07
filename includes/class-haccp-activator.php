<?php

/**
 * Fired during plugin activation
 *
 * @link       localhost
 * @since      1.0.0
 *
 * @package    Haccp
 * @subpackage Haccp/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Haccp
 * @subpackage Haccp/includes
 * @author     Jonas <jonascal95@gmail.com>
 */
class Haccp_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;
		global $jal_db_version;

		$charset_collate = $wpdb->get_charset_collate();
		
		$sql = "
		SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
		SET AUTOCOMMIT = 0;
		START TRANSACTION;
		SET time_zone = '+00:00';

		DROP TABLE IF EXISTS `haccp_allergen`;
		CREATE TABLE `haccp_allergen` (
		  `allergen_id` bigint(20) NOT NULL AUTO_INCREMENT,
		  `allergen_name` char(32) NOT NULL,
		  `allergen_status` tinyint(4) NOT NULL DEFAULT '1',
		  `allergen_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (`allergen_id`)
		) AUTO_INCREMENT=1;
		
		
		
		INSERT INTO `haccp_allergen` (`allergen_id`, `allergen_name`, `allergen_status`, `allergen_time`) VALUES
		(1, 'Gluten', 1, '2019-01-22 11:07:12'),
		(2, 'Crustaceans', 1, '2019-01-22 11:07:12'),
		(3, 'Eggs', 1, '2019-01-22 11:07:12'),
		(4, 'Fish', 1, '2019-01-22 11:07:12'),
		(5, 'Peanuts', 1, '2019-01-22 11:07:12'),
		(6, 'Soybeans', 1, '2019-01-22 11:07:12'),
		(7, 'Lactose(milk etc)', 1, '2019-01-22 11:07:12'),
		(8, 'Nuts', 1, '2019-01-22 11:07:12'),
		(9, 'Celery', 1, '2019-01-22 11:07:12'),
		(10, 'Mustard', 1, '2019-01-22 11:07:12'),
		(11, 'Sesame', 1, '2019-01-22 11:07:12'),
		(12, 'Sulphur', 1, '2019-01-22 11:07:12'),
		(13, 'Lupin', 1, '2019-01-22 11:06:37'),
		(14, 'Molluscs', 1, '2019-01-22 11:06:37');
		
		
		DROP TABLE IF EXISTS `haccp_allergen_sub`;
		CREATE TABLE `haccp_allergen_sub` (
		  `allergen_sub_id` bigint(20) NOT NULL AUTO_INCREMENT,
		  `allergen_id` bigint(20) NOT NULL,
		  `allergen_sub_name` char(32) NOT NULL,
		  `allergen_sub_status` tinyint(4) NOT NULL,
		  `allergen_sub_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (`allergen_sub_id`)
		) AUTO_INCREMENT=1;
		
		
		DROP TABLE IF EXISTS `haccp_daily`;
		CREATE TABLE `haccp_daily` (
		  `daily_id` bigint(20) NOT NULL AUTO_INCREMENT,
		  `daily_type` tinyint(4) NOT NULL,
		  `daily_name` char(32) NOT NULL,
		  `daily_default_value` char(32) NOT NULL,
		  `daily_status` tinyint(4) NOT NULL,
		  `daily_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (`daily_id`)
		) AUTO_INCREMENT=1;
		
		
		DROP TABLE IF EXISTS `haccp_daily_checks`;
		CREATE TABLE `haccp_daily_checks` (
		  `daily_checks_id` bigint(20) NOT NULL AUTO_INCREMENT,
		  `daily_checks_time` datetime NOT NULL,
		  `equipment_id` bigint(20) NOT NULL,
		  `daily_checks_name` char(32) NOT NULL,
		  `daily_checks_actual_value` char(32) NOT NULL,
		  `daily_checks_comments` char(255) NOT NULL,
		  PRIMARY KEY (`daily_checks_id`)
		) AUTO_INCREMENT=1;
		
		
		DROP TABLE IF EXISTS `haccp_goods_in`;
		CREATE TABLE `haccp_goods_in` (
		  `goods_in_id` bigint(20) NOT NULL AUTO_INCREMENT,
		  `goods_in_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  `product_id` bigint(20) NOT NULL,
		  `supplier_id` bigint(20) NOT NULL,
		  `goods_in_use_by` date NOT NULL,
		  `goods_in_batch` char(128) NOT NULL,
		  `goods_in_description` char(128) NOT NULL,
		  `goods_in_comments` char(255) NOT NULL,
		  PRIMARY KEY (`goods_in_id`)
		) AUTO_INCREMENT=1;
		
		
		DROP TABLE IF EXISTS `haccp_item_allergens`;
		CREATE TABLE `haccp_item_allergens` (
		  `item_allergens_id` bigint(20) NOT NULL AUTO_INCREMENT,
		  `item_allergens_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  `item_allergens_item` char(32) NOT NULL,
		  `allergen_name` char(32) NOT NULL,
		  `allergen_type` varchar(40) NOT NULL,
		  `allergen_id` bigint(20) NOT NULL,
		  `allergen_sub_item_id` bigint(20) NOT NULL,
		  `allergen_value` tinyint(4) NOT NULL,
		  PRIMARY KEY (`item_allergens_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;
		
		
		DROP TABLE IF EXISTS `haccp_products`;
		CREATE TABLE `haccp_products` (
		  `product_id` bigint(20) NOT NULL AUTO_INCREMENT,
		  `product_name` char(32) NOT NULL,
		  `product_status` tinyint(4) NOT NULL,
		  `product_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (`product_id`)
		) AUTO_INCREMENT=1;
		
		
		DROP TABLE IF EXISTS `haccp_suppliers`;
		CREATE TABLE `haccp_suppliers` (
		  `supplier_id` bigint(20) NOT NULL AUTO_INCREMENT,
		  `supplier_name` char(32) NOT NULL,
		  `supplier_status` tinyint(4) NOT NULL,
		  `supplier_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (`supplier_id`)
		) AUTO_INCREMENT=1;
		
		COMMIT;  ";
		//echo $sql; exit;
		// $wpdb->query($sql);

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

		add_option( 'jal_db_version', $jal_db_version );
	}

}
