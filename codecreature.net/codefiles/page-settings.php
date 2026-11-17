<div class="page-settings <?php echo !empty($psType) ? $psType : "fixed"; ?>" id="page-settings">
		<button id="page-settings-button" class="open-page-settings btn-strip" aria-label="page settings"
		onclick="pageSettings.toggle();">
			<i class="svg-icon svg-icon-solid" data-icon="gear-solid" alt="">
				<?php include $_SERVER["DOCUMENT_ROOT"]."/graphix/svg-icons/gear_solid.svg"; ?>
			</i>
		</button>
	<div class="page-settings-contents hidden" id="page-settings-contents">
		<button id="page-settings-close-button" onclick="pageSettings.close();">close</button>
	</div>
	<script src="/codefiles/page-settings-new.js?fileversion=20261117"></script>
</div>