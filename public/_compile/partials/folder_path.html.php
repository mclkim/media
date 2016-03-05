<?php /* Template_ 2.2.8 2016/03/05 14:04:20 D:\phpdev\workspace\media\public\_template\partials\folder_path.html 000000813 */ 
$TPL_pathSegments_1=empty($TPL_VAR["pathSegments"])||!is_array($TPL_VAR["pathSegments"])?0:count($TPL_VAR["pathSegments"]);?>
<ul class="tree-path">
	<li class="root"><a href="#" data-type="media-item"
		data-item-type="folder" data-path="/" data-clear-search="true">Home</a></li>
<?php if(!$TPL_VAR["searchMode"]){?>		
<?php if($TPL_pathSegments_1){foreach($TPL_VAR["pathSegments"] as $TPL_K1=>$TPL_V1){?>		
<?php if($TPL_V1!=''){?>		
	<li><a href="#" data-type="media-item" data-item-type="folder"
		data-path="<?php echo $TPL_V1?>"><?php echo $TPL_K1?></a></li>
<?php }?>
<?php }}?>
<?php }else{?>
	<li><a href="#" data-type="media-item">Home</a></li>
<?php }?>
</ul>