<?php /* Template_ 2.2.8 2016/01/28 09:47:06 D:\phpdev\workspace\media\public\_template\partials\left_sidebar.html 000001281 */ ?>
<div id="MediaManager-manager-filters">
	<h3 class="section">디스플레이</h3>

	<ul class="nav nav-stacked selector-group">
		<li role="presentation" class="active"><a href="#"
			data-command="set-filter" data-filter="everything"> <i
				class="icon-recycle"></i> 모든 파일
		</a></li>
		<li role="presentation"><a href="#" data-command="set-filter"
			data-filter="image"> <i class="icon-picture-o"></i> 이미지
		</a></li>
		<li role="presentation"><a href="#" data-command="set-filter"
			data-filter="video"> <i class="icon-video-camera"></i> 비디오
		</a></li>
		<li role="presentation"><a href="#" data-command="set-filter"
			data-filter="audio"> <i class="icon-volume-up"></i> 오디오
		</a></li>
		<li role="presentation"><a href="#" data-command="set-filter"
			data-filter="document"> <i class="icon-file"></i> 문서
		</a></li>
	</ul>
</div>


<h3 class="section">정렬순서</h3>

<select name="sorting" class="form-control custom-select"
	data-control="sorting">
	<option selected="selected" value="title">제목</option>
	<option value="size">크기</option>
	<option value="modified">최종 수정</option>
</select>