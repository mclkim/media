<?php /* Template_ 2.2.8 2016/02/25 20:34:07 D:\phpdev\workspace\media\public\_template\partials\folder_path.html 000000817 */ 
$TPL_breadcrumb_1=empty($TPL_VAR["breadcrumb"])||!is_array($TPL_VAR["breadcrumb"])?0:count($TPL_VAR["breadcrumb"]);?>
<ul class="tree-path">
	<li class="root"><a href="#" data-type="media-item"
		data-item-type="folder" data-path="/" data-clear-search="true">Home</a></li>
<?php if(!$TPL_VAR["searchMode"]){?>		
<?php if($TPL_breadcrumb_1){foreach($TPL_VAR["breadcrumb"] as $TPL_V1){?>		
<?php if($TPL_V1["dir"]!=''){?>		
	<li><a href="#" data-type="media-item" data-item-type="folder"
		data-path="<?php echo $TPL_V1["dir"]?>"><?php echo $TPL_V1["content"]?></a></li>
<?php }?>
<?php }}?>
<?php }else{?>
	<li><a href="#" data-type="media-item">Home</a></li>
<?php }?>
</ul>