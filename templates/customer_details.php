<div class="wrap">
<h1>
<?php
    echo __('客户详情','jms-customer-manager');
?>
</h1>

<table class="form-table">
    <tbody>
    <tr>
        <th scope="row"><label for="customer_name"><?php echo __('客户ID','jms-customer-manager'); ?></label></th>
            <td>
            <?php echo $result[0]["id"]; ?>
            </td>
        </tr>

        <tr>
            <th scope="row"><label for="customer_name"><?php echo __('客户昵称','jms-customer-manager'); ?></label></th>
            <td>
                <?php echo stripslashes($result[0]["name"]); ?> （
                <?php 
                    if ($result[0]["gender"] == '1') { 
                        echo "爸爸";
                    } else { 
                        echo "妈妈";
                    }?>）
            </td>
        </tr>
        
        <tr>
            <th scope="row"><label for="wechat_id"><?php echo __('微信ID','jms-customer-manager'); ?></label></th>
            <td>
                <?php echo stripslashes($result[0]["wechat_id"]); ?>
            </td>
        </tr>
        
        <tr>
            <th scope="row"><label for="wechat_id"><?php echo __('密钥','jms-customer-manager'); ?></label></th>
            <td>
                <?php echo stripslashes($result[0]["sign"]); ?>
                <p>https://jmsliu.cn/wechat/yangguang_register.php?w=<?php echo stripslashes($result[0]["sign"]); ?></p>
            </td>
        </tr>

        <tr>
            <th scope="row"><label for="customer_tier"><?php echo __('销售等级','jms-customer-manager'); ?></label></th>
            <td>
                <?php echo stripslashes($result[0]["tier"]); ?>
            </td>
        </tr>

        <tr>
            <th scope="row"><label for="customer_child"><?php echo __('子女信息','jms-customer-manager'); ?></label></th>
            <td>
            <?php echo stripslashes($result[0]["child_info"]); ?>
            </td>
        </tr>

        <tr>
            <th scope="row"><label for="customer_interest"><?php echo __('客户喜好','jms-customer-manager'); ?></label></th>
            <td>
            <?php echo stripslashes($result[0]["interest"]); ?>
            </td>
        </tr>

        <tr>
            <th scope="row"><label for="customer_desc"><?php echo __('客户描述','jms-customer-manager'); ?></label></th>
            <td>
                <?php echo stripslashes($result[0]["desc"]); ?>
            </td>
        </tr>
	</tbody>
</table>

</div>