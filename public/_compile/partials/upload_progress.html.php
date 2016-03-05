<?php /* Template_ 2.2.8 2016/03/05 12:57:17 D:\phpdev\workspace\media\public\_template\partials\upload_progress.html 000000983 */ ?>
<div class="layout-row min-size hide" data-control="upload-ui">
	<div class="layout">
		<div class="upload-progress">
			<h5 data-label="file-number-and-progress"
				data-message-template="업로딩  :number 파일... <span>:percents</span>"
				data-success-template="업로드 완료" data-error-template="업로드에 실패했습니다"></h5>

			<div class="progress-controls">
				<div class="progress">
					<div class="progress-bar" role="progressbar" style="width: 0;"
						data-control="upload-progress-bar"></div>
				</div>

				<div class="controls">
					<a href="#" data-command="cancel-uploading"><i
						class="icon-times-circle" title=""></i></a> <a class="hide" href="#"
						data-command="close-uploader"><i class="icon-check-circle"
						title=""></i></a>
				</div>
			</div>
		</div>
	</div>
</div>