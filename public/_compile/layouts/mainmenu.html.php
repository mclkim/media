<?php /* Template_ 2.2.8 2016/02/01 16:10:10 D:\phpdev\workspace\media\public\_template\layouts\mainmenu.html 000002525 */ ?>
<nav class="navbar control-toolbar" id="layout-mainmenu"
	role="navigation">
	<div class="toolbar-item toolbar-primary">
		<div data-control="toolbar">
			<a class="menu-toggle" href="javascript:;"> <i class="icon-bars"></i>
				미디어
			</a>
<?php if(false){?>
			<ul class="nav">
				<li class=""><a href="http://localhost/october/backend/backend">
						<i class="icon-dashboard"></i>대시 보드
				</a></li>
				<li class=""><a href="http://localhost/october/backend/cms">
						<i class="icon-magic"></i>CMS
				</a></li>
				<li class=""><a
					href="http://localhost/october/backend/rainlab/pages"> <i
						class="icon-files-o"></i>페이지
				</a></li>
				<li class="active"><a
					href="http://localhost/october/backend/cms/media"> <i
						class="icon-folder"></i>미디어
				</a></li>
				<li class=""><a
					href="http://localhost/october/backend/rainlab/user/users"> <i
						class="icon-user"></i>사용자
				</a></li>
				<li class=""><a
					href="http://localhost/october/backend/rainlab/blog/posts"> <i
						class="icon-pencil"></i>블로그
				</a></li>
				<li class=""><a
					href="http://localhost/october/backend/system/settings"> <i
						class="icon-cog"></i>설정
				</a></li>
			</ul>
<?php }?>			
		</div>
	</div>
	<div class="toolbar-item" data-calculate-width>
		<ul>
			<li class="icon preview with-tooltip"><a
				href="http://localhost/october" target="_blank" title="웹 사이트 미리보기">
					<i class="icon-crosshairs"></i>
			</a></li>
			<li class="highlight account"><a href="javascript:;"
				onclick="$.oc.layout.toggleAccountMenu(this)"> <img
					src="//www.gravatar.com/avatar/2d6826023f031865b164c14f78254c0e?s=50&d=mm">
					<span class="hidden-xs"> Admin Person </span>
			</a>
				<div class="mainmenu-accountmenu">
					<ul>
						<li><a
							href="http://localhost/october/backend/backend/users/myaccount">
								계정 </a></li>
						<li><a
							href="http://localhost/october/backend/system/settings/update/october/backend/backend_preferences">
								백엔드 환경설정 </a></li>
						<li><a
							href="http://localhost/october/backend/backend/editorpreferences">
								편집기 환경설정 </a></li>
						<li class="divider"></li>

						<li><a
							href="http://localhost/october/backend/backend/auth/signout">
								로그 아웃 </a></li>
					</ul>
				</div></li>
		</ul>
	</div>
</nav>