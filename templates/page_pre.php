
<?php if ($page['page_count']>1){?>  
        <div class="page mtr10">
        <span class="page_item_total">共 <?php echo $page['item_count'];?> 项</span>
        <?php if ($page['prev_link']){?>  
         <a class="former"  href="<?php echo $page['prev_link']?>" title="转到上一页">上一页</a>
         <?php }else{?>
          <span class="formerNull"></span>
          <?php }?>
          <?php foreach($page['page_links'] as $key=>$link){?>
  <?php if($page['curr_page']==$key){?>
    <span class="page_hover" ><?php echo $key;?></span>
  <?php }else{?>
 <a  class="page_link"  href="<?php echo $link;?>" title="转到第<?php echo $key;?>页"><?php echo $key;?></a>
 <?php }}?>

   <a class="nonce"><?php echo $page['curr_page'];?>/<?php echo $page['page_count'];?></a>
   <?php if($page['next_link']){?>
  <a class="down" href="<?php echo $page['next_link']?>" title="转到下一页">下一页</a>
 <?php }else{?>
  <span class="downNull">最末页</span>
<?php }?>
 <span class="page_form"><form action="" method="get" onsubmit="return page_url();"><p class="page_text"> 到第 <input type="text" id="page_num" class="page_num" value="<?php echo $page['curr_page']?>" /> 页 </p><input type="submit" class="page_bnt" value="" /></form></span>
  <script type="text/javascript">
  function page_url()
  {
	var url_format = '?<?php echo $page['url_format']?>';
	var new_url = url_format+'&page='+document.getElementById('page_num').value;
	window.location.href = new_url;
	return false;
  }
  </script>      
</div>
<?php }?>  