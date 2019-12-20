<?php
/* 
Plugin Name: JMS Customer Manager
Plugin URI: https://github.com/jamesliu668/jms-customer-manager
Description: Help to manage customer information in WordPress.
Author: James Liu
Version: 1.0.0
Author URI: http://jmsliu.com/
License: GPL3

{Plugin Name} is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
{Plugin Name} is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with {Plugin Name}. If not, see {License URI}.
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

//ali sms
//include dirname(__FILE__)."/lib/TopSdk.php";
date_default_timezone_set('Asia/Shanghai');

global $jms_customer_manager_version;
$jms_customer_manager_version = '1.0';
    
//install database
register_activation_hook( __FILE__, 'installJMSCustomerManager' );

add_action( 'admin_menu', 'jmsCustomerAdminPage' );
add_action('wp_ajax_jms_customer', 'jms_customer_ajax');
add_action('wp_ajax_nopriv_jms_customer', 'jms_customer_ajax');


/**
 * Init database, current version 1.0
 */
function installJMSCustomerManager() {
    global $jms_customer_manager_version;
    global $wpdb;
    

    $jms_customer_manager_version = get_option( "jms_customer_manager_version", null );
    if ( $jms_customer_manager_version == null ) {
        $charset_collate = $wpdb->get_charset_collate();
        
        $table_name = $wpdb->prefix . "jms_customer";
        $sql = "CREATE TABLE IF NOT EXISTS `".$table_name."` (
                `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                `wechat_id` VARCHAR(255) NULL,
                `open_id` VARCHAR(255) NULL,
                `name` VARCHAR(255) NULL,
                `age` INT UNSIGNED NULL,
                `desc` TEXT NULL,
                `phone` VARCHAR(255) NULL,
                `child_info` TEXT NULL COMMENT 'json objects\n',
                `interest` TEXT NULL COMMENT 'json',
                `credits` INT UNSIGNED NULL,
                `level` INT UNSIGNED NULL,
                `tier` INT NULL,
                `create_date` DATETIME NULL,
                `update_date` DATETIME NULL,
                PRIMARY KEY (`id`),
                UNIQUE INDEX `id_UNIQUE` (`id` ASC))
                ENGINE = InnoDB ".$charset_collate.";";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
        
        add_option( "jms_customer_manager_version", $jms_customer_manager_version );
    }
}

function jmsCustomerAdminPage() {
    add_menu_page(
        __("客户管理", 'jms-customer-manager' ),
        __("客户管理", 'jms-customer-manager'),
        'manage_options',
        'jms-customer-manager-top',
        'jmsCustomerAdminPageOptions' );
}

function jmsCustomerAdminPageOptions() {
    global $wpdb, $wp;
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
    
    if( isset($_POST["action"]) ) {
        if($_POST[ "action" ] == "new-save") {
            if(check_admin_referer( 'new_customer' )) {
                require_once(dirname(__FILE__)."/controllers/JMSCustomerController.php");
                $customerController = new JMSCustomerController();

                $name = trim($_POST[ "customer_name" ]);
                $wechatid = trim($_POST[ "wechat_id" ]);
                $desc = trim($_POST[ "customer_desc" ]);
                $childInfo = trim($_POST[ "customer_child" ]);
                $interest = trim($_POST[ "customer_interest" ]);
                $sellTier = trim($_POST[ "customer_tier" ]);
                $customerController->addCustomer($name, $wechatid, $desc, $childInfo, $interest, $sellTier);
            } else {
                echo __( '页面安全密钥已过期，请重新打开添加页面提交视频。' );
            }
        } else if($_POST[ "action" ] == "update-save") {
            if(check_admin_referer( 'update_customer' )) {
                require_once(dirname(__FILE__)."/controllers/JMSCustomerController.php");
                $customerController = new JMSCustomerController();

                $id = trim($_POST[ "id" ]);
                $name = trim($_POST[ "customer_name" ]);
                $wechatid = trim($_POST[ "wechat_id" ]);
                $desc = trim($_POST[ "customer_desc" ]);
                $childInfo = trim($_POST[ "customer_child" ]);
                $interest = trim($_POST[ "customer_interest" ]);
                $sellTier = trim($_POST[ "customer_tier" ]);

                $customerController->updateCustomer($id, $name, $wechatid, $desc, $childInfo, $interest, $sellTier);
            } else {
                echo __( '页面安全密钥已过期，请重新打开编辑页面提交视频。' );
            }
        }
    } else if( isset($_GET[ "action" ]) ) {
        if($_GET[ "action" ] == 'new') {
            require_once(dirname(__FILE__)."/controllers/JMSCustomerController.php");
            $customerController = new JMSCustomerController();
            $customerController->showAddForm();
        } else if($_GET[ "action" ] == 'edit') {
            if(isset($_GET["id"])) {
                $customerID = trim($_GET["id"]);
                require_once(dirname(__FILE__)."/controllers/JMSCustomerController.php");
                $customerController = new JMSCustomerController();
                $customerController->showEditForm($customerID);
            } else {
                echo __('未找到制定的视频。', 'jms-customer-manager');
            }
        } else if($_GET[ "action" ] == 'delete') {
            if(isset($_GET["id"])) {
                $customerID = trim($_GET["id"]);
                if(isset($_GET["_wpnonce"]) && wp_verify_nonce( trim($_GET["_wpnonce"]), 'delete-customer-'.$customerID )) {
                    require_once(dirname(__FILE__)."/controllers/JMSCustomerController.php");
                    $customerController = new JMSCustomerController();
                    $customerController->deleteCustomer($customerID);
                } else {
                    echo __('页面安全密钥已过期，无法删除指定视频。', 'jms-customer-manager');
                }
            } else {
                echo __('未找到制定的视频。', 'jms-customer-manager');
            }
        }
    } else {
        //show list
        require_once(dirname(__FILE__)."/controllers/JMSCustomerController.php");
        $customerController = new JMSCustomerController();

        $searchTerm = "";
        if( isset($_GET[ "s" ]) ) {
            $searchTerm = trim($_GET["s"]);
        }

        $paged = 1;
        if( isset($_GET[ "paged" ]) ) {
            $paged = (int)trim($_GET["paged"]);
        }

        $customerController->showCustomerList($searchTerm, $paged);
    }
}

function jms_customer_ajax($wp) {
    if($_REQUEST["task"] == "search") {
        require_once(dirname(__FILE__)."/controllers/JMSCustomerController.php");
        $controller = new JMSCustomerController();
        $controller->search();
    }
}
?>