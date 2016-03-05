<?php /* Template_ 2.2.8 2016/03/05 12:43:55 D:\phpdev\workspace\media\public\_template\partials\filters.html 000001398 */ ?>
<div id="MediaManager-manager-filters">
	<h3 class="section">범주</h3>
	<ul class="nav nav-stacked selector-group">
		<li role="presentation"
			class="<?php if($TPL_VAR["currentFilter"]=='everything'){?>active<?php }?>"><a href="#"
			data-command="set-filter" data-filter="everything"> <i
				class="icon-recycle"></i> 모든 파일
		</a></li>
		<li role="presentation" class="<?php if($TPL_VAR["currentFilter"]=='image'){?>active<?php }?>">
			<a href="#" data-command="set-filter" data-filter="image"> <i
				class="icon-picture-o"></i> 이미지
		</a>
		</li>
		<li role="presentation" class="<?php if($TPL_VAR["currentFilter"]=='video'){?>active<?php }?>">
			<a href="#" data-command="set-filter" data-filter="video"> <i
				class="icon-video-camera"></i> 비디오
		</a>
		</li>
		<li role="presentation" class="<?php if($TPL_VAR["currentFilter"]=='audio'){?>active<?php }?>">
			<a href="#" data-command="set-filter" data-filter="audio"> <i
				class="icon-volume-up"></i> 오디오
		</a>
		</li>
		<li role="presentation"
			class="<?php if($TPL_VAR["currentFilter"]=='document'){?>active<?php }?>"><a href="#"
			data-command="set-filter" data-filter="document"> <i
				class="icon-file"></i> 문서
		</a></li>
	</ul>
</div>