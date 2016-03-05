<?php /* Template_ 2.2.8 2016/03/05 10:51:05 D:\phpdev\workspace\media\public\_template\partials\_list_grid.html 000002056 */ 
$TPL_items_1=empty($TPL_VAR["items"])||!is_array($TPL_VAR["items"])?0:count($TPL_VAR["items"]);?>
<table class="table data">
	<col />
	<col width="130px" />
	<col width="130px" />

	<tbody class="icons clickable">
		<!-- <?php if(!$TPL_VAR["isRootFolder"]){?> -->
		<tr data-type="media-item" data-item-type="folder" data-root
			data-path="<?php echo dirname($TPL_VAR["currentFolder"])?>" tabindex="0">
			<td><i class="icon-folder"></i>..</td>
			<td></td>
			<td></td>
		</tr>
		<!-- <?php }?> -->
		<!-- <?php if($TPL_items_1){foreach($TPL_VAR["items"] as $TPL_V1){?> -->
		<tr data-type="media-item" data-item-type="<?php echo $TPL_V1["item"]?>"
			data-path="<?php echo $TPL_V1["path"]?>/<?php echo $TPL_V1["name"]?>" data-title="<?php echo $TPL_V1["name"]?>" data-size="<?php echo $TPL_V1["byte"]?>"
			data-last-modified="<?php echo $TPL_V1["date"]?>" data-last-modified-ts="<?php echo $TPL_V1["date"]?>"
			data-public-url="" data-document-type="<?php echo $TPL_V1["type"]?>" data-folder="<?php echo $TPL_V1["path"]?>"
			tabindex="0">
			<td>
				<div class="item-title no-wrap-text">
					<i class="<?php echo $TPL_V1["icon"]?>"></i> <?php echo $TPL_V1["name"]?> <a href="#" data-rename
						data-control="popup"
						data-request-data="path: '<?php echo $TPL_V1["path"]?>/<?php echo $TPL_V1["name"]?>', listId: 'MediaManager-manager-item-list', type: '<?php echo $TPL_V1["item"]?>'"
						data-handler="manager::onLoadRenamePopup" data-z-index="1200"><i
						data-rename-control class="icon-terminal"></i></a>
				</div>
			</td>
			<td><?php echo $TPL_V1["byte"]?></td>
			<td><?php echo date("y-m-d h:i A",$TPL_V1["modified"])?></td>
		</tr>
		<!-- <?php }}else{?> -->
		<div class="empty-library">미디어 라이브러리가 비어 있습니다. 파일을 업로드하거나 시작하는
			폴더를 만들 수 있습니다.</div>
		<!-- <?php }?> -->
	</tbody>
</table>