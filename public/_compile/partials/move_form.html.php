<?php /* Template_ 2.2.8 2016/03/04 18:26:01 D:\phpdev\workspace\media\public\_template\partials\move_form.html 000001487 */ 
$TPL_folders_1=empty($TPL_VAR["folders"])||!is_array($TPL_VAR["folders"])?0:count($TPL_VAR["folders"]);?>
<form method="POST" action="http://localhost/media/public/"
	accept-charset="UTF-8">
	<!-- _token -->
	<input name="_token" value="SrtTe2H2xbbxrNeAXsDbA9wvqm3qHrda9Iw8PDqk"
		type="hidden">
	<!-- _session_key -->
	<input name="_session_key"
		value="hWjVfd9FL2PhfnbcSoOiwdh2u9NcJdDwcp9TOdbW" type="hidden">
	<!-- modal-header -->
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="popup">&times;</button>
		<h4 class="modal-title">이동 파일 또는 폴더</h4>
	</div>
	<!-- modal-body -->
	<div class="modal-body">
		<div class="form-group">
			<label>대상 폴더</label>
			<!-- select -->
			<select class="form-control custom-select" name="dest"
				data-placeholder="선택">
				<option></option>
<?php if($TPL_folders_1){foreach($TPL_VAR["folders"] as $TPL_K1=>$TPL_V1){?>
				<option value="<?php echo $TPL_K1?>"><?php echo $TPL_V1?></option>
<?php }}?>
			</select>
			<!-- input -->
			<input name="originalPath" value="/" type="hidden">
		</div>
	</div>
	<!-- modal-footer -->
	<div class="modal-footer">
		<button type="submit" class="btn btn-primary">이동</button>
		<button type="button" class="btn btn-default" data-dismiss="popup">
			취소</button>
	</div>
</form>