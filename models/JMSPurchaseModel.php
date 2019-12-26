<?php
    class JMSPurchaseModel {
        private $tableName = "jms_customer_purchase";
        private $userTableName = "jms_customer";

        function numberOfPurchase($searchTerm) {
            global $wpdb;
            $table_name = $wpdb->prefix . $this->tableName;
            $userTableName = $wpdb->prefix . $this->userTableName;
            $wpdb->show_errors( true );

            $sql = "SELECT count(*) AS total FROM $table_name as a LEFT JOIN $userTableName as b ON a.uid = b.id";
            if($searchTerm != "") {
                $sql = "SELECT count(*) AS total FROM $table_name as a LEFT JOIN $userTableName as b ON a.uid = b.id WHERE `name` LIKE '%".$searchTerm."%' or `wechat_id` LIKE '%".$searchTerm."%'";
            }
            $totalNumber = $wpdb->get_results($sql, OBJECT);
            return $totalNumber[0]->total;
        }

        function getPurchaseList($paged, $numberOfRecord, $searchTerm) {
            global $wpdb;
            $table_name = $wpdb->prefix . $this->tableName;
            $userTableName = $wpdb->prefix . $this->userTableName;
            $wpdb->show_errors( true );

            $startIndex = ($paged - 1) * $numberOfRecord;
            $sql = "SELECT a.id, amount, paid_date, expired_date, note, wechat_id, `name` FROM $table_name as a LEFT JOIN $userTableName as b ON a.uid = b.id ORDER BY a.id ASC LIMIT $startIndex, $numberOfRecord";

            if($searchTerm != "") {
                $sql = "SELECT a.id, amount, paid_date, expired_date, note, wechat_id, `name` FROM $table_name as a LEFT JOIN $userTableName as b ON a.uid = b.id WHERE `name` LIKE '%".$searchTerm."%' or `wechat_id` LIKE '%".$searchTerm."%' ORDER BY a.id ASC LIMIT $startIndex,$numberOfRecord";
            }
            $result = $wpdb->get_results($sql, ARRAY_A);
            return $result;
        }

        function addPurchase($uid, $amount, $paidDate, $expiredDate, $duration, $note) {
            global $wpdb;
            $table_name = $wpdb->prefix . $this->tableName;
            $wpdb->show_errors( true );

            //insert
            $query = $wpdb->prepare(
                "INSERT INTO $table_name (`uid`, amount, `paid_date`, expired_date, duration, `note`)
                    VALUES (%d, %f, %s, %s, %d, %s)",
                array(
                    $uid,
                    $amount,
                    $paidDate,
                    $expiredDate,
                    $duration,
                    $note
                    )
            );

            $result = $wpdb->query($query);
            return $result;
        }

        function updatePurchase($id, $uid, $amount, $paidDate, $expiredDate, $duration, $note) {
            global $wpdb;
            $table_name = $wpdb->prefix . $this->tableName;
            $wpdb->show_errors( true );

            $query = $wpdb->prepare(
                "UPDATE $table_name SET `uid`=\"%d\", amount=\"%f\", `paid_date`=\"%s\", expired_date=\"%s\",  duration=%d, note=\"%s\" WHERE id = %d",
                array(
                    $uid,
                    $amount,
                    $paidDate,
                    $expiredDate,
                    $duration,
                    $note,
                    $id
                    )
            );
            $result = $wpdb->query($query);

            return $result; //true or false
        }



        function getPurchaseByID($id) {
            global $wpdb;
            $table_name = $wpdb->prefix . $this->tableName;
            $wpdb->show_errors( true );
            return $wpdb->get_results("SELECT * FROM $table_name WHERE id=".(int)$id, ARRAY_A);
        }

        function getPurchaseByWechatID($wid) {
            global $wpdb;
            $table_name = $wpdb->prefix . $this->tableName;
            $wpdb->show_errors( true );
            $query = $wpdb->prepare(
                "SELECT * FROM $table_name WHERE wechat_id=\"%s\"",
                array($wid)
            );
            return $wpdb->get_results($query, ARRAY_A);
        }

        function getPurchaseBySign($sign) {
            global $wpdb;
            $table_name = $wpdb->prefix . $this->tableName;
            $wpdb->show_errors( true );
            $query = $wpdb->prepare(
                "SELECT * FROM $table_name WHERE sign=\"%s\"",
                array($sign)
            );
            return $wpdb->get_results($query, ARRAY_A);
        }

        function deletePurchaseByID($id) {
            global $wpdb;
            $table_name = $wpdb->prefix . $this->tableName;
            $wpdb->show_errors( true );
            $result = $wpdb->query($wpdb->prepare(
                "DELETE FROM $table_name WHERE `id` = %d",
                array($id)
            ));

            return $result;
        }

        function search($query, $start, $count) {
            global $wpdb;
            $table_name = $wpdb->prefix . $this->tableName;
            $wpdb->show_errors( true );

            if(empty($start)) {
                $start = 0;
            }

            if(empty($query)) {
                return $wpdb->get_results("SELECT id, title, description, update_date, vid, thumb FROM $table_name WHERE published=1 ORDER BY id DESC LIMIT $start, $count", ARRAY_A);
            } else {
                return $wpdb->get_results("SELECT id, title, description, update_date, vid, thumb FROM $table_name WHERE published=1 AND `title` LIKE '%".$query."%' ORDER BY id DESC LIMIT $start, $count", ARRAY_A);
            }
        }
    }
?>