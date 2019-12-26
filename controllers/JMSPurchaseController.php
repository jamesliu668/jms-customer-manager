<?php
    require_once(dirname(__FILE__)."/../models/JMSPurchaseModel.php");
    class JMSPurchaseController {
        private $model;

        function __construct() {
            $this->model = new JMSPurchaseModel();
        }

        function showPurchaseList($searchTerm, $paged) {
            global $wpdb;

            $numberOfRecord = 10;
            $numberOfPurchase = $this->model->numberOfPurchase($searchTerm);
            $totalPage = ceil($numberOfPurchase / $numberOfRecord) ;
    
            if($paged > $totalPage) {
                $paged = $totalPage > 0 ? $totalPage : 1;
            } else if($paged < 1) {
                $paged = 1;
            }

            $result = $this->model->getPurchaseList($paged, $numberOfRecord, $searchTerm);
            require_once(dirname(__FILE__)."/../templates/purchase_list.php");
        }

        function showAddForm($uid, $name) {
            require_once(dirname(__FILE__)."/../templates/purchase_new.php");
        }

        function showEditForm($purchaseID, $name) {
            if(empty($purchaseID)) {
                echo __('未找到指定的购买记录', 'jms-customer-manager');
            } else {
                $result = $this->model->getPurchaseByID($purchaseID);
                require_once(dirname(__FILE__)."/../templates/purchase_edit.php");
            }
        }
        
        function addPurchase($uid, $amount, $duration, $note) {
            if(empty($uid)) {
                echo __('用户ID不能为空', 'jms-customer-manager');
            } else {
                $currentDate = current_time('mysql', 0); //show local time
                $expiredDate = date('Y-m-d H:i:s', strtotime("+".$duration. " months", strtotime($currentDate)));
                $result = $this->model->addPurchase($uid, $amount, $currentDate, $expiredDate, $duration, $note);
                if($result !== false) {
                    $message = sprintf(__('购买记录添加成功! <a href="%s">返回购买记录列表</a>', 'jms-customer-manager'), $wp->request."admin.php?page=jms-customer-manager-purchase");
                    echo "<h1>".$message."</h1>";
                } else {
                    echo __('购买记录添加失败, 数据库操作失败!', 'jms-customer-manager');
                }
            }
        }

        function updatePurchase($id, $amount, $duration, $note, $paidDate) {
            $currentDate = current_time('mysql', 0); //show local time
            $result = $this->model->getPurchaseByID($id);
            if(count($result) > 0) {
                if($paidDate == NULL) {
                    $paidDate = current_time('mysql', 0); //show local time
                }

                $expiredDate = date('Y-m-d H:i:s', strtotime("+".$duration. " months", strtotime($paidDate)));

                $result = $this->model->updatePurchase($id, $result[0]['uid'], $amount, $paidDate, $expiredDate, $duration, $note);
                if($result !== false) {
                    $message = sprintf(__('购买记录更新成功! <a href="%s">返回购买记录列表</a>', 'jms-customer-manager'), $wp->request."admin.php?page=jms-customer-manager-purchase");
                    echo "<h1>".$message."</h1>";
                } else {
                    echo __('购买记录更新失败, 数据库操作失败!', 'jms-customer-manager');
                }
            } else {
                echo __('购买记录更新失败, 数据库操作失败!', 'jms-customer-manager');
            }
        }

        function deletePurchase($purchaseID) {
            $result = $this->model->getPurchaseByID($purchaseID);
            if(count($result) > 0) {
                $result = $this->model->deletePurchaseByID($purchaseID);
                if($result !== false) {
                    $message = sprintf(__('购买记录删除成功! <a href="%s">返回购买记录列表</a>', 'jms-customer-manager'), $wp->request."admin.php?page=jms-customer-manager-purchase");
                    echo "<h1>".$message."</h1>";
                } else {
                    echo __('购买记录删除失败，找不到指定购买记录!', 'jms-customer-manager');
                }
            } else {
                echo __('购买记录删除失败，找不到指定购买记录!', 'jms-customer-manager');
            }
        }

        function search() {
            $query = trim($_REQUEST['q']);
            $start = trim($_REQUEST['start']);
            $count = 10; # search for 10 items

            $result = $this->model->search($query, $start, $count);
            if(count($result) > 0) {
                foreach ($result as $k => $value) {
                    $result[$k]['thumb'] = plugins_url( '/../thumb/'.$value['thumb'], __FILE__ );
                }
            }
            echo wp_json_encode($result);
        }
    }
?>