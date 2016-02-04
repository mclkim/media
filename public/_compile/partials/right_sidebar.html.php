<?php /* Template_ 2.2.8 2016/01/28 10:42:52 D:\phpdev\workspace\media\public\_template\partials\right_sidebar.html 000002757 */ ?>
<div data-control="media-preview-container"></div>

<script type="text/template" data-control="audio-template">
    <div class="panel no-padding-bottom">
        <audio src="<?php echo $TPL_VAR["src"]?>" controls>
            <div class="media-player-fallback panel-embedded">Your browser doesn't support HTML5 audio.</div>
        </audio>
    </div>
</script>

<script type="text/template" data-control="video-template">
    <video src="<?php echo $TPL_VAR["src"]?>" controls poster="http://localhost/october/modules/cms/widgets/mediamanager/assets/images/video-poster.png">
        <div class="panel media-player-fallback">Your browser doesn't support HTML5 video.</div>
    </video>
</script>

<script type="text/template" data-control="image-template">
    <div class="sidebar-image-placeholder-container"><div class="sidebar-image-placeholder" data-path="<?php echo $TPL_VAR["path"]?>" data-last-modified="<?php echo $TPL_VAR["last"]-$TPL_VAR["modified"]?>" data-loading="true" data-control="sidebar-thumbnail"></div></div>
</script>

<script type="text/template" data-control="no-selection-template">
    <div class="sidebar-image-placeholder-container">
        <div class="sidebar-image-placeholder no-border">
            <i class="icon-crop"></i>
            <p>아무 것도 선택하지 않습니다.</p>
        </div>
    </div>
</script>

<script type="text/template" data-control="multi-selection-template">
    <div class="sidebar-image-placeholder-container">
        <div class="sidebar-image-placeholder no-border">
            <i class="icon-asterisk"></i>
            <p>여러 항목을 선택하였습니다.</p>
        </div>
    </div>
</script>

<script type="text/template" data-control="go-up">
    <div class="sidebar-image-placeholder-container">
        <div class="sidebar-image-placeholder no-border">
            <i class="icon-level-up"></i>
            <p>상위 폴더로 돌아 가기</p>
        </div>
    </div>
</script>
<div class="panel hide" data-control="sidebar-labels">
	<label>제목</label>
	<p data-label="title"></p>

	<table class="name-value-list">
		<tr>
			<th>크기</th>
			<td data-label="size"></td>
		</tr>
		<tr>
			<th>공개 URL</th>
			<td><a href="#" data-label="public-url" target="_blank">여기를
					클릭</a></td>
		</tr>
		<tr data-control="last-modified">
			<th>최종 수정</th>
			<td data-label="last-modified"></td>
		</tr>

		<tr data-control="item-folder" class="hide">
			<th>폴더</th>
			<td><a href="#" data-type="media-item" data-item-type="folder"
				data-label="folder" data-clear-search="true"></a></td>
		</tr>
	</table>
</div>