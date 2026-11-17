<?php if (empty($psType) || $psType == "fixed") { ?>
<div class="page-settings" id="page-settings">
<?php } ?>
	<div>
		<button id="page-settings-button" class="open-page-settings btn-strip" aria-label="page settings"
		onclick="pageSettings.toggle();">
			<i class="svg-icon svg-icon-solid" data-icon="gear-solid" alt="">
				<?php include $_SERVER["DOCUMENT_ROOT"]."/graphix/svg-icons/gear_solid.svg"; ?>
			</i>
		</button>
	</div>
	<div class="page-settings-contents hidden" id="page-settings-contents">
		<button id="page-settings-close-button" onclick="pageSettings.close();">close</button>
	</div>
	<script src="/codefiles/page-settings-new.js?fileversion=20261022"></script>
<?php if (empty($psType) || $psType == "fixed") { ?>
</div>
<?php } ?>