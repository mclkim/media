<?php /* Template_ 2.2.8 2016/03/05 10:50:49 D:\phpdev\workspace\media\public\_template\partials\_list_list.html 000001874 */ 
$TPL_items_1=empty($TPL_VAR["items"])||!is_array($TPL_VAR["items"])?0:count($TPL_VAR["items"]);?>
<div class="panel no-padding padding-top">
	<input type="hidden" data-type="current-folder" value="/"> <input
		type="hidden" data-type="search-mode" value="false">
	<div class="list-container">

		<ul class="media-list list">
			<!-- <?php if($TPL_items_1){foreach($TPL_VAR["items"] as $TPL_V1){?> -->
			<li data-type="media-item" data-item-type="<?php echo $TPL_V1["item"]?>"
				data-path="<?php echo $TPL_V1["path"]?>/<?php echo $TPL_V1["name"]?>" data-title="<?php echo $TPL_V1["name"]?>" data-size="<?php echo $TPL_V1["byte"]?>"
				data-last-modified="<?php echo $TPL_V1["date"]?>" data-last-modified-ts="<?php echo $TPL_V1["date"]?>"
				data-public-url="" data-document-type="<?php echo $TPL_V1["type"]?>"
				data-folder="<?php echo $TPL_V1["path"]?>" tabindex="0">
				<div class="icon-container ">
					<div class="icon-wrapper">
						<i class="<?php echo $TPL_V1["icon"]?>"></i>
					</div>

				</div>
				<div class="info">
					<h4 title="<?php echo $TPL_V1["name"]?>">
						<?php echo $TPL_V1["name"]?> <a href="#" data-rename="" data-control="popup"
							data-z-index="1200"
							data-request-data="path: '<?php echo $TPL_V1["path"]?>/<?php echo $TPL_V1["name"]?>', listId: 'MediaManager-manager-item-list', type: '<?php echo $TPL_V1["item"]?>'"
							data-handler="manager::onLoadRenamePopup"><i
							data-rename-control="" class="icon-terminal"></i></a>
					</h4>
					<p class="size"><?php echo $TPL_V1["byte"]?></p>
				</div>
			</li>
			<!-- <?php }}else{?> -->
			<li class="no-data">요청한 파일을 찾을수 없습니다.</li>
			<!-- <?php }?> -->
		</ul>
	</div>
</div>