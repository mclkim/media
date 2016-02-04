<?php /* Template_ 2.2.8 2016/01/29 18:35:34 D:\phpdev\workspace\media\public\_template\layouts\default.html 000001999 */ ?>
<!DOCTYPE html>
<html lang="ko" class="no-js webkit safari chrome win">
<head>
<!-- head -->
<?php $this->print_("head",$TPL_SCP,1);?>

</head>
<body class="compact-container">
	<div id="layout-canvas">
		<div class="layout">

			<!-- Main Menu -->
			<div class="layout-row min-size">
				<!-- mainmenu -->
<?php $this->print_("mainmenu",$TPL_SCP,1);?>

				<!-- /mainmenu -->
			</div>

			<!-- flyoutContent -->
<?php $this->print_("sidepanel_flyout",$TPL_SCP,1);?>


			<div class="layout-row">
<?php if($TPL_VAR["flyoutContent"]){?>
				<div class="layout flyout-container" data-control="flyout"
					data-flyout-width="400" data-flyout-toggle="#layout-sidenav">

					<div class="layout-cell flyout"><?php echo $TPL_VAR["flyoutContent"]?></div>
<?php }else{?>
					<div class="layout flyout-container">
<?php }?>

						<!-- Side Navigation -->
<?php $this->print_("sidenavi",$TPL_SCP,1);?>


						<!-- Side panel -->
<?php if($TPL_VAR["sidePanelContent"]){?>
						<div class="layout-cell width-300 hide-on-small"
							id="layout-side-panel" data-control="layout-sidepanel">
							<?php echo $TPL_VAR["sidePanelContent"]?></div>
<?php }?>

						<!-- Content Body -->
						<div class="layout-cell layout-container" id="layout-body">
							<div class="layout-relative">

								<div class="layout">
									<!-- Breadcrumb -->
<?php if($TPL_VAR["breadcrumbContent"]){?>
									<div class="control-breadcrumb"><?php echo $TPL_VAR["breadcrumbContent"]?></div>
<?php }?>

									<!-- Content -->
									<div class="layout-row">
										<!-- body -->
<?php $this->print_("body",$TPL_SCP,1);?>

										<!-- /body -->
									</div>
								</div>

							</div>
						</div>

					</div>
				</div>

			</div>
		</div>

		<!-- Flash Messages -->
		<div id="layout-flash-messages"><?php $this->print_("flash_messages",$TPL_SCP,1);?></div>
</body>
</html>