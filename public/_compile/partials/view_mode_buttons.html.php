<?php /* Template_ 2.2.8 2016/03/05 12:35:02 D:\phpdev\workspace\media\public\_template\partials\view_mode_buttons.html 000000679 */ ?>
<button type="button"
	class="btn btn-default oc-icon-align-justify empty <?php if($TPL_VAR["viewMode"]=='grid'){?>on<?php }?>"
	data-command="change-view" data-view="grid"></button>
<button type="button"
	class="btn btn-default oc-icon-th empty <?php if($TPL_VAR["viewMode"]=='list'){?>on<?php }?>"
	data-command="change-view" data-view="list"></button>
<button type="button"
	class="btn btn-default oc-icon-th-large empty <?php if($TPL_VAR["viewMode"]=='tiles'){?>on<?php }?>"
	data-command="change-view" data-view="tiles"></button>