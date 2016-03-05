<?php /* Template_ 2.2.8 2016/03/05 15:21:31 D:\phpdev\workspace\media\public\_template\partials\rename_form.html 000002080 */ ?>
<div class="modal-content">
	<form method="POST" action="http://localhost/october/backend/cms/media"
		accept-charset="UTF-8" data-request="manager::onApplyName"
		data-stripe-load-indicator="1" id="media-rename-popup-form"
		data-request-success="$el.trigger('close.oc.popup'); $('#MediaManager-manager-item-list').trigger('mediarefresh');">
		<input name="_token" type="hidden"
			value="AmqTMmAtSG8jP7KkIdq88AlFt3gX1Jan3EcnS2kW"><input
			name="_session_key" type="hidden"
			value="51yBkl3CNj1lu3YwzV8w88MnvtD7cY3DpDh0csVW">

		<div class="modal-header">
			<button type="button" class="close" data-dismiss="popup">&times;</button>
			<h4 class="modal-title">이름 변경</h4>
		</div>

		<div class="modal-body">
			<div class="form-group">
				<label>새 이름</label> <input type="text" class="form-control"
					name="name" value="<?php echo $TPL_VAR["name"]?>"> <input type="hidden"
					name="originalName" value="<?php echo $TPL_VAR["originalName"]?>"> <input type="hidden"
					name="type" value="<?php echo $TPL_VAR["folder"]?>">
			</div>

			<input type="hidden" name="originalPath" value="<?php echo $TPL_VAR["originalPath"]?>">
		</div>
		
		<div class="modal-footer">
			<button type="submit" class="btn btn-primary">적용</button>
			<button type="button" class="btn btn-default" data-dismiss="popup">
				취소</button>
		</div>
		
		<script>
			setTimeout(function() {
				$('#media-rename-popup-form input.form-control').focus()
			}, 310)

			$('#media-rename-popup-form').on(
					'oc.beforeRequest',
					function(ev) {
						var originalName = $(
								'#media-rename-popup-form [name=originalName]')
								.val(), newName = $.trim($(
								'#media-rename-popup-form [name=name]').val())

						if (originalName == newName || newName.length == 0) {
							alert('Please enter a new name')

							ev.preventDefault()
						}
					})
		</script>
	</form>
</div>