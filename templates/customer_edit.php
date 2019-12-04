<?php
    $action = "update-save";
?>
<div class="wrap">
<h1>
<?php
    echo __('编辑客户','jms-customer-manager');
?>
</h1>

<form method="post" novalidate="novalidate" enctype="multipart/form-data">
    <input type="hidden" name="action" value="<?php echo $action;?>">
    <?php wp_nonce_field( 'update_customer' ); ?>
    <input type="hidden" name="id" value="<?php echo $result[0]["id"]; ?>"/>
<table class="form-table">
    <tbody>
    <tr>
            <th scope="row"><label for="customer_name"><?php echo __('客户昵称','jms-customer-manager'); ?></label></th>
            <td>
                <input name="customer_name" type="text" id="customer_name" value="<?php echo stripslashes($result[0]["name"]); ?>" class="regular-text">
            </td>
        </tr>
        
        <tr>
            <th scope="row"><label for="wechat_id"><?php echo __('微信ID','jms-customer-manager'); ?></label></th>
            <td>
                <input name="wechat_id" type="text" id="wechat_id" value="<?php echo stripslashes($result[0]["wechat_id"]); ?>" class="regular-text">
                <p class="description" id="tagline-description"><?php echo __('微信账号，需要添加好友以后在微信中找到。','jms-customer-manager'); ?></p>
            </td>
        </tr>

        <tr>
            <th scope="row"><label for="customer_tier"><?php echo __('销售等级','jms-customer-manager'); ?></label></th>
            <td>
                <input name="customer_tier" type="text" id="customer_tier" value="<?php echo stripslashes($result[0]["tier"]); ?>" class="regular-text">
                <p class="description" id="tagline-description"><?php echo __('记录客户被销售的潜力，可以填写负数，正数，和0。','jms-customer-manager'); ?></p>
            </td>
        </tr>

        <tr>
            <th scope="row"><label for="customer_child"><?php echo __('子女信息','jms-customer-manager'); ?></label></th>
            <td>
                <textarea name="customer_child" id="customer_child" rows="5" cols="53"><?php echo stripslashes($result[0]["child_info"]); ?></textarea>
                <p class="description" id="tagline-description"><?php echo __('填写客户的子女信息，必须填写json格式。','jms-customer-manager'); ?></p>
            </td>
        </tr>

        <tr>
            <th scope="row"><label for="customer_interest"><?php echo __('客户喜好','jms-customer-manager'); ?></label></th>
            <td>
                <textarea name="customer_interest" id="customer_interest" rows="5" cols="53"><?php echo stripslashes($result[0]["interest"]); ?></textarea>
                <p class="description" id="tagline-description"><?php echo __('填写客户关注的内容，比如一年级的内容，单次短语等；必须填写json格式。','jms-customer-manager'); ?></p>
            </td>
        </tr>

        <tr>
            <th scope="row"><label for="customer_desc"><?php echo __('客户描述','jms-customer-manager'); ?></label></th>
            <td>
                <textarea name="customer_desc" id="customer_desc" rows="5" cols="53"><?php echo stripslashes($result[0]["desc"]); ?></textarea>
                <p class="description" id="tagline-description"><?php echo __('填写客户的描述和备注。','jms-customer-manager'); ?></p>
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