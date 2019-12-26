<?php
    $action = "update-save";
?>
<div class="wrap">
<h1>
<?php
    echo __('编辑客户购买记录','jms-customer-manager');
?>
</h1>

<form method="post" novalidate="novalidate" enctype="multipart/form-data">
    <input type="hidden" name="action" value="<?php echo $action;?>">
    <?php wp_nonce_field( 'update_purchase' ); ?>
    <input type="hidden" name="id" value="<?php echo $result[0]["id"]; ?>"/>
<table class="form-table">
    <tbody>
        <tr>
            <th scope="row"><label for="customer_name"><?php echo __('客户昵称','jms-customer-manager'); ?></label></th>
            <td>
                <p><?php echo $name; ?></p>
            </td>
        </tr>
        
        <tr>
            <th scope="row"><label for="amount"><?php echo __('支付金额','jms-customer-manager'); ?></label></th>
            <td>
                <input name="amount" type="text" id="amount" value="<?php echo stripslashes($result[0]["amount"]); ?>" class="regular-text">
                <p class="description" id="tagline-description"><?php echo __('支付金额，格式为99.99。','jms-customer-manager'); ?></p>
            </td>
        </tr>

        <tr>
            <th scope="row"><label for="paid-date"><?php echo __('支付时间','jms-customer-manager'); ?></label></th>
            <td>
                <input name="paid-date" type="text" id="paid-date" value="<?php echo stripslashes($result[0]["paid_date"]); ?>" class="regular-text">
                <p class="description" id="tagline-description"><?php echo __('支付时间。如果为空，按当前时间计算。','jms-customer-manager'); ?></p>
            </td>
        </tr>

        <tr>
            <th scope="row"><label for="duration"><?php echo __('购买时长','jms-customer-manager'); ?></label></th>
            <td>
                <select class="" name="duration" id="duration">
                    <?php
                        for($i=1; $i<=12; $i++) {
                            if($i == $result[0]["amount"]) {
                                echo "<option selected value=\"$i\">".$i."个月</option>";
                            } else {
                                echo "<option value=\"$i\">".$i."个月</option>";
                            }
                        }
                    ?>
                    <option selected value="12" >12个月</option>
                </select>

                <p class="description" id="tagline-description"><?php echo __('用户购买时长，以月为单位。','jms-customer-manager'); ?></p>
            </td>
        </tr>

        <tr>
            <th scope="row"><label for="note"><?php echo __('备注','jms-customer-manager'); ?></label></th>
            <td>
                <textarea name="note" id="note" rows="5" cols="50"><?php echo stripslashes($result[0]["note"]); ?></textarea>
                <p class="description" id="tagline-description"><?php echo __('填写活动信息和单价。例如：小区内推广优惠5折，每年99元。','jms-customer-manager'); ?></p>
            </td>
        </tr>
	</tbody>
</table>
<p class="submit">
<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo __('保存','jms-customer-manager');?>">
<a class="button" style="margin-left: 10px;" onclick="window.history.back();"><?php echo __('取消','jms-customer-manager');?></a>
</p>

</form>

</div>