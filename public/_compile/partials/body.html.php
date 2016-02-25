<?php /* Template_ 2.2.8 2016/02/04 10:56:23 D:\phpdev\workspace\media\public\_template\partials\body.html 000002987 */ ?>
<form method="POST" action="http://localhost/media/public/"
	accept-charset="UTF-8" class="layout" onsubmit="return false">
	<!-- _token -->
	<input name="_token" type="hidden"
		value="Nibm3rLxyI9d5btuw5SaekuTOVWQnKKx9wL2lwdW">
	<!-- _session_key -->
	<input name="_session_key" type="hidden"
		value="3kOH57Z9G4pZdevjJMeGWeZBKVCnlTNB8mcgZA5B">
	<div data-control="media-manager" class="layout" data-alias="manager"
		data-unique-id="MediaManager-manager"
		data-delete-empty="삭제할 항목을 선택하세요."
		data-delete-confirm="정말로 선택된 파일 삭제 하시겠습니까?"
		data-move-empty="이동 항목을 선택하세요."
		data-select-single-image="하나의 이미지를 선택하세요."
		data-selection-not-image="선택한 항목이 이미지가 아닙니다."
		data-bottom-toolbar="false" data-crop-and-insert-button="false"
		tabindex="0">

		<!-- toolbar -->
<?php $this->print_("toolbar",$TPL_SCP,1);?>


		<!-- upload progress -->
<?php $this->print_("upload_progress",$TPL_SCP,1);?>


		<div class="layout-row whiteboard">
			<div class="layout">
				<div class="layout-row">
					<div class="layout-cell width-200 panel border-right"
						data-control="left-sidebar">
						<!-- Left sidebar -->
<?php $this->print_("left_sidebar",$TPL_SCP,1);?>

					</div>
					<div class="layout-cell">
						<div class="layout">

							<div class="layout-row min-size">
								<!-- Folder toolbar -->
<?php $this->print_("folder_toolbar",$TPL_SCP,1);?>

							</div>
							<div class="layout-row">
								<!-- Main area -->
								<div class="layout">
									<div class="layout-row">
										<div class="layout">
											<!-- Main area - list -->
											<div data-control="item-list">
												<div class="control-scrollpad">
													<div class="scroll-wrapper">
														<!-- This element is required for the scrollpad control -->
														<div id="MediaManager-manager-item-list">
<?php $this->print_("item_list",$TPL_SCP,1);?>

														</div>
													</div>
												</div>
											</div>

											<div
												class="layout-cell width-300 panel border-left no-padding "
												data-control="preview-sidebar">
												<!-- Right sidebar -->
<?php $this->print_("right_sidebar",$TPL_SCP,1);?>

											</div>

										</div>
									</div>

									<div class="layout-row min-size hide"
										data-control="bottom-toolbar">
										<!-- Bottom toolbar -->
<?php $this->print_("bottom_toolbar",$TPL_SCP,1);?>

									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>

		<script type="text/template" data-control="new-folder-template">
<?php $this->print_("new_folder_form",$TPL_SCP,1);?>

		</script>
	</div>
</form>