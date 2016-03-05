<?php /* Template_ 2.2.8 2016/03/03 05:39:40 D:\phpdev\workspace\media\public\_template\partials\_sorting.html 000000787 */ ?>
<h3 class="section">정렬순서</h3>

<select name="sorting" class="form-control custom-select"
	data-control="sorting">
<?php if($TPL_VAR["sortBy"]=='name'){?>
	<option selected="selected" value="name">제목</option>
<?php }else{?>
	<option value="name">제목</option>
<?php }?>
<?php if($TPL_VAR["sortBy"]=='size'){?>
	<option selected="selected" value="size">크기</option>
<?php }else{?>
	<option value="size">크기</option>
<?php }?>
<?php if($TPL_VAR["sortBy"]=='modified'){?>
	<option selected="selected" value="modified">최종 수정</option>
<?php }else{?>
	<option value="modified">최종 수정</option>
<?php }?>
</select>