<?php /* Template_ 2.2.8 2016/03/05 12:31:24 D:\phpdev\workspace\media\public\_template\partials\toolbar.html 000001715 */ ?>
<div class="layout-row min-size">
	<div class="control-toolbar toolbar-padded">
		<div class="toolbar-item toolbar-primary">
			<div data-control="toolbar">
				<div class="btn-group offset-right">
					<button type="button" class="btn btn-primary oc-icon-upload"
						data-control="upload">업로드</button>
					<button type="button" class="btn btn-primary oc-icon-folder"
						data-command="create-folder">폴더 추가</button>
				</div>

				<button type="button"
					class="btn btn-default oc-icon-refresh empty offset-right"
					data-command="refresh"></button>

				<div class="btn-group offset-right">
					<button type="button" class="btn btn-default oc-icon-download"
						data-command="download">다운로드</button>
					<button type="button" class="btn btn-default oc-icon-reply-all"
						data-command="move">이동</button>
					<button type="button" class="btn btn-default oc-icon-trash"
						data-command="delete">삭제</button>
				</div>

				<div class="btn-group offset-right"
					id="MediaManager-manager-view-mode-buttons">
					<!-- view_mode_buttons -->
<?php $this->print_("view_mode_buttons",$TPL_SCP,1);?>

				</div>

			</div>
		</div>
		<div class="toolbar-item" data-calculate-width>
			<div class="relative loading-indicator-container size-input-text">
				<input type="text" name="search" value=""
					class="form-control icon search growable" placeholder="검색"
					data-control="search" autocomplete="off" data-load-indicator
					data-load-indicator-opaque />
			</div>
		</div>
	</div>
</div>