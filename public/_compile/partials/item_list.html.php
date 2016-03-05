<?php /* Template_ 2.2.8 2016/03/05 12:09:45 D:\phpdev\workspace\media\public\_template\partials\item_list.html 000004443 */ 
$TPL_items_1=empty($TPL_VAR["items"])||!is_array($TPL_VAR["items"])?0:count($TPL_VAR["items"]);?>
<div class="panel no-padding padding-top">
	<input type="hidden" data-type="current-folder" value="<?php echo $TPL_VAR["currentFolder"]?>" />
	<input type="hidden" data-type="search-mode"
		value="<?php if($TPL_VAR["searchMode"]){?>'true'<?php }else{?>'false'<?php }?>" />
	<div class="list-container">
		<!-- <?php if($TPL_VAR["viewMode"]=='grid'){?> -->
		<table class="table data">
			<col />
			<col width="130px" />
			<col width="130px" />

			<tbody class="icons clickable">
				<!-- <?php if(!$TPL_VAR["isRootFolder"]&&!$TPL_VAR["searchMode"]){?> -->
				<tr data-type="media-item" data-item-type="folder" data-root=""
					data-path="<?php echo dirname($TPL_VAR["currentFolder"])?>" tabindex="0">
					<td><i class="icon-folder"></i>..</td>
					<td></td>
					<td></td>
				</tr>
				<!-- <?php }?> -->
				<!-- <?php if($TPL_items_1){foreach($TPL_VAR["items"] as $TPL_V1){?> -->
				<tr data-type="media-item" data-item-type="<?php echo $TPL_V1["item"]?>"
					data-path="<?php echo $TPL_V1["path"]?>/<?php echo $TPL_V1["name"]?>" data-title="<?php echo $TPL_V1["name"]?>"
					data-size="<?php echo $TPL_V1["byte"]?>" data-last-modified="<?php echo $TPL_V1["date"]?>"
					data-last-modified-ts="<?php echo $TPL_V1["date"]?>" data-public-url=""
					data-document-type="<?php echo $TPL_V1["type"]?>" data-folder="<?php echo $TPL_V1["path"]?>" tabindex="0">
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
				<p class="no-data">요청한 파일을 찾을수 없습니다.</p>
				<!-- <?php }?> -->
			</tbody>
		</table>
		<!-- <?php }else{?> -->
		<ul class="media-list <?php echo $TPL_VAR["viewMode"]?>">
			<!-- <?php if(!$TPL_VAR["isRootFolder"]&&!$TPL_VAR["searchMode"]){?> -->
			<li tabindex="0" data-type="media-item" data-item-type="folder"
				data-root="" data-path="<?php echo dirname($TPL_VAR["currentFolder"])?>">
				<div class="icon-container folder">
					<div class="icon-wrapper">
						<i class="icon-folder"></i>
					</div>
				</div>
				<div class="info">
					<h4 title="상위 폴더로 돌아 가기">상위 폴더...</h4>
				</div>
			</li>
			<!-- <?php }?> -->
			<!-- <?php if($TPL_items_1){foreach($TPL_VAR["items"] as $TPL_V1){?> -->
			<li data-type="media-item" data-item-type="<?php echo $TPL_V1["item"]?>"
				data-path="<?php echo $TPL_V1["path"]?>/<?php echo $TPL_V1["name"]?>" data-title="<?php echo $TPL_V1["name"]?>" data-size="<?php echo $TPL_V1["byte"]?>"
				data-last-modified="<?php echo $TPL_V1["date"]?>" data-last-modified-ts="<?php echo $TPL_V1["date"]?>"
				data-public-url="" data-document-type="<?php echo $TPL_V1["type"]?>"
				data-folder="<?php echo $TPL_V1["path"]?>" tabindex="0">
				<div class="icon-container">
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
		<!-- <?php }?> -->
	</div>
</div>