<?php
    global $wp;
    $currentURL = $wp->request."admin.php?page=jms-customer-manager-purchase";
?>

<div class="wrap">
<h1>
<?php
    echo __('客户购买记录','jms-customer-manager');
?></h1>


<form id="jms-patient-profile-filter" method="get" action="<?php echo $currentURL?>">

<p class="search-box">
	<label class="screen-reader-text" for="post-search-input">搜索:</label>
	<input type="search" id="post-search-input" name="s" value="<?php echo $searchTerm; ?>">
	<input type="submit" id="search-submit" class="button" value="搜索">
</p>

<input type="hidden" id="page" name="page" value="jms-customer-manager-purchase">

<div class="tablenav top">
    <div class="tablenav-pages">
        <span class="displaying-num"><?php echo $numberOfVideo."个客户购买记录"?></span>
        <span class="pagination-links">
        <?php
            if($paged == 1) {
                echo '<span class="tablenav-pages-navspan" aria-hidden="true">«</span>';
                echo '<span class="tablenav-pages-navspan" aria-hidden="true">‹</span>';
            } else {
                echo '<a class="next-page" href="'.$currentURL.'&paged=1">';
                echo '<span class="screen-reader-text">首页</span><span aria-hidden="true">«</span>';
                echo '</a>';

                echo '<a class="next-page" href="'.$currentURL.'&paged='.($paged - 1).'">';
                echo '<span class="screen-reader-text">上一页</span><span aria-hidden="true">‹</span>';
                echo '</a>';
            }
        ?>

<span class="paging-input">第<label for="current-page-selector" class="screen-reader-text">当前页</label>
<input class="current-page" id="current-page-selector" name="paged" value="<?php echo $paged; ?>" size="1" aria-describedby="table-paging" type="text">
<span class="tablenav-paging-text">页，共<span class="total-pages"><?php echo $totalPage; ?></span>页</span></span>

        <?php
            if($paged == $totalPage) {
                echo '<span class="tablenav-pages-navspan" aria-hidden="true">›</span>';
                echo '<span class="tablenav-pages-navspan" aria-hidden="true">»</span>';
            } else {
                echo '<a class="next-page" href="'.$currentURL.'&paged='.($paged + 1).'">';
                echo '<span class="screen-reader-text">下一页</span><span aria-hidden="true">›</span>';
                echo '</a>';

                echo '<a class="last-page" href="'.$currentURL.'&paged='.$totalPage.'">';
                echo '<span class="screen-reader-text">尾页</span><span aria-hidden="true">»</span>';
                echo '</a>';
            }
        ?>


</span>
</div>
<br class="clear">
</div>




<h2 class="screen-reader-text">购买记录列表</h2>

<table class="wp-list-table widefat fixed striped posts">
	<thead>
	<tr>
		<td id="cb" class="manage-column column-cb check-column">
            <label class="screen-reader-text" for="cb-select-all-1">全选</label>
            <!--<input id="cb-select-all-1" type="checkbox">-->
        </td>
        <th scope="col" id="title" class="manage-column column-title column-primary" style="width:20px;">
            <?php echo __('ID','jms-customer-manager');?>
        </th>
        <th scope="col" id="title" class="manage-column column-categories">
            <?php echo __('微信号','jms-customer-manager');?>
        </th>
        <th scope="col" id="author" class="manage-column column-categories">
            <?php echo __('昵称','jms-customer-manager');?>
        </th>
        <th scope="col" id="author" class="manage-column column-categories">
            <?php echo __('金额','jms-customer-manager');?>
        </th>
        <th scope="col" id="categories" class="manage-column column-categories">
            <?php echo __('付款时间','jms-customer-manager');?>
        </th>
        <th scope="col" id="categories" class="manage-column column-categories">
            <?php echo __('过期时间','jms-customer-manager');?>
        </th>
        <th scope="col" id="categories" class="manage-column column-categories">
            <?php echo __('描述','jms-customer-manager');?>
        </th>
    </tr>
	</thead>

	<tbody id="the-list">
    <?php
    if(isset($result)) {
        foreach($result as $data) {
    ?>
		<tr id="post-20" class="iedit author-self level-0 post-20 type-post status-publish format-standard hentry category-uncategorized">
			<th scope="row" class="check-column">
                <label class="screen-reader-text" for="cb-select-20">选择客户</label>
                <!--<input id="cb-select-20" type="checkbox" name="post[]" value="20">-->
                <div class="locked-indicator"></div>
            </th>
            <td class="title column-title has-row-actions column-primary page-title">
                <strong>
                    <?php echo $data["id"]; ?>
                </strong>
            </td>
            
            <td class="categories column-categories">
                <?php
                    echo $data["wechat_id"];
                ?>
                
                <div class="row-actions">
                    <span class="edit"><a href="<?php echo $wp->request; ?>admin.php?page=jms-customer-manager-purchase&id=<?php echo $data["id"];?>&name=<?php echo $data["name"]; ?>&action=edit">
                    <?php echo __('Edit','jms-customer-manager'); ?>
                    </a> | </span>
                    <span class="trash"><a href="<?php echo $wp->request; ?>admin.php?page=jms-customer-manager-purchase&id=<?php echo $data["id"];?>&action=delete&_wpnonce=<?php echo wp_create_nonce( 'delete-purchase-'.$data["id"] );?>" class="submitdelete">移至回收站</a> | </span>
                </div>
            </td>
            
            <td class="categories column-categories">
                <?php
                    echo $data["name"];
                ?>
            </td>
            
            <td class="categories column-categories">
                <?php
                    echo $data["amount"];
                ?>
            </td>
            
            <td class="date column-date" data-colname="日期">
                <abbr title="<?php echo $data["paid_date"]; ?>">
                    <?php echo $data["paid_date"]; ?>
                </abbr>
            </td>
            
            <td class="date column-date" data-colname="日期">
                <abbr title="<?php echo $data["expired_date"]; ?>">
                    <?php echo $data["expired_date"]; ?>
                </abbr>
            </td>
            
            <td class="categories column-categories">
                <?php
                    echo $data["note"];
                ?>
            </td>
        </tr>
    <?php
        }
    }
    ?>
	</tbody>

	<tfoot>
   	</tfoot>
</table>

<div class="tablenav bottom">
    <div class="tablenav-pages">
        <span class="displaying-num"><?php echo $numberOfVideo."个客户"?></span>
        <span class="pagination-links">
        <?php
            if($paged == 1) {
                echo '<span class="tablenav-pages-navspan" aria-hidden="true">«</span>';
                echo '<span class="tablenav-pages-navspan" aria-hidden="true">‹</span>';
            } else {
                echo '<a class="next-page" href="'.$currentURL.'&paged=1">';
                echo '<span class="screen-reader-text">首页</span><span aria-hidden="true">«</span>';
                echo '</a>';

                echo '<a class="next-page" href="'.$currentURL.'&paged='.($paged - 1).'">';
                echo '<span class="screen-reader-text">上一页</span><span aria-hidden="true">‹</span>';
                echo '</a>';
            }
        ?>

<span class="paging-input">第<label for="current-page-selector" class="screen-reader-text">当前页</label>
<input class="current-page" id="current-page-selector" name="paged" value="<?php echo $paged; ?>" size="1" aria-describedby="table-paging" type="text">
<span class="tablenav-paging-text">页，共<span class="total-pages"><?php echo $totalPage; ?></span>页</span></span>

        <?php
            if($paged == $totalPage) {
                echo '<span class="tablenav-pages-navspan" aria-hidden="true">›</span>';
                echo '<span class="tablenav-pages-navspan" aria-hidden="true">»</span>';
            } else {
                echo '<a class="next-page" href="'.$currentURL.'&paged='.($paged + 1).'">';
                echo '<span class="screen-reader-text">下一页</span><span aria-hidden="true">›</span>';
                echo '</a>';

                echo '<a class="last-page" href="'.$currentURL.'&paged='.$totalPage.'">';
                echo '<span class="screen-reader-text">尾页</span><span aria-hidden="true">»</span>';
                echo '</a>';
            }
        ?>


</span>
</div>
<br class="clear">
</div>

</form>
<br class="clear">
</div>