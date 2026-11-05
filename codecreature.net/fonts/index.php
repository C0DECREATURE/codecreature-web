<?php
$fonts = [
	"body fonts"=>[
		["name"=>"Comic Sans MS", "credit"=>"microsoft"],
		["name"=>"Yet R", "credit"=>"human computers inc",
				"link"=>"https://old.ufonts.com/download/yet-r.html"],
		["name"=>"Janda Closer To Free", "credit"=>"kimberly geswein",
				"link"=>"https://www.dafont.com/janda-closer-to-free.font"],
		["name"=>"Halogen", "credit"=>"JLH Fonts",
				"link"=>"https://www.dafont.com/halogen.font"],
		["name"=>"Ad Lib", "credit"=>"Alan Carr",
				"link"=>"https://www.fontspace.com/adlib-font-f157"],
		["name"=>"Garfield", "credit"=>"zemin",
				"link"=>"https://www.cufonfonts.com/font/garfield"],
		["name"=>"Terminax Regular", "credit"=>"Monotype",
				"link"=>"https://www.onlinewebfonts.com/download/82403999bfc93275231a15d0cb4fe75f"],
		["name"=>"Letter-O-Matic", "credit"=>"Blambot",
				"link"=>"https://www.1001fonts.com/letteromatic-font.html"],
		["name"=>"Mabook", "credit"=>"Khurasan",
				"link"=>"https://www.dafont.com/mabook.font"],
	],
	"decorative"=>[
		["name"=>"Super Comic", "credit"=>"singlelinestudio",
				"link"=>"https://www.dafont.com/super-comic-3.font"],
		["name"=>"DS Digital", "credit"=>"dusit supasawat",
				"link"=>"https://www.dafont.com/ds-digital.font"],
		["name"=>"Crimes Times Six", "credit"=>"jshcreates",
				"link"=>"https://www.dafont.com/crimes-times-six.font"],
		["name"=>"Ghoulish Fright", "credit"=>"astigmatic typographic institute",
				"link"=>"https://www.dafont.com/ghoulish-fright-aoe.font"],
		["name"=>"My Imaginary Friend", "credit"=>"meanstreak",
				"link"=>"https://www.fontspace.com/my-imaginary-friend-font-f24689"],
		["name"=>"Kaiju Monster", "credit"=>"goma shin",
				"link"=>"https://www.dafont.com/kaiju-monster-g.font"],
		["name"=>"Alphabet_01", "credit"=>"Wen",
				"link"=>"https://www.ffonts.net/Alphabet_01.font"],
		["name"=>"Paint Hand", "credit"=>"Letters & Numbers",
				"link"=>"https://www.dafont.com/paint-hand.font"],
		["name"=>"Victorian Parlor", "credit"=>"Eric Kurniawan (burntilldead)",
				"link"=>"https://www.fontspace.com/victorian-parlor-font-f23362"],
		["name"=>"Matura Regular", "credit"=>"Imre Reiner",
				"link"=>"https://ufonts.com/fonts/matura-mt-std-regular-opentype-1-136938.html"],
	],
	"media inspired"=>[
		["name"=>"Hiveswap Alternian", "credit"=>"orangeypeels",
				"link"=>"https://www.deviantart.com/orangeypeels/art/Hiveswap-Alternian-Font-704876917",
				"unreadable"=>true],
		["name"=>"Splatoon 1", "credit"=>"nintendo",
				"link"=>"https://fontspark.com/splatoon-font/",
				"loadName"=>"Splatoon"],
		["name"=>"Splatoon 2", "credit"=>"nintendo",
				"link"=>"https://fontspark.com/splatoon-font/",
				"loadName"=>"Splatoon"],
		["name"=>"Pokemon Classic", "credit"=>"nintendo",
				"link"=>"https://www.dafont.com/pokemon-classic.font"],
		["name"=>"Unown", "credit"=>"elementcollector1",
				"link"=>"https://fontstruct.com/fontstructions/show/1787089/unown-37",
				"unreadable"=>true],
		["name"=>"Unown Light", "credit"=>"arien epic",
				"link"=>"https://www.dafont.com/unown.font",
				"unreadable"=>true],
	],
];
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<title>font credits</title>
		<meta name="description" content="Font credits for codecreature.net">
		<meta name="keywords" content="font, fonts, credit, credits">
		<meta name="author" content="codecreature">
		
		<!-- universal base javascript -->
		<script src="/codefiles/required.js?fileversion=20260410"></script>
		<!-- universal base css -->
		<link href="/codefiles/required.css?fileversion=20260410" rel="stylesheet" type="text/css"></link>
		
		<!-- page settings -->
		<script src="/codefiles/page-settings.min.js?fileversion=20260410"></script>
		
		<!-- fonts -->
		<?php
		// get list of font names to load
		$loadNames = [];
		foreach ($fonts as $category => $list) { foreach ($list as $f) {
			$loadNames[] = !empty($f["loadName"]) ? $f["loadName"] : $f["name"];
		}}
		// delete duplicates
		$loadNames = array_unique($loadNames);
		echo "<script>fonts.load('".implode("','",$loadNames)."');</script>";
		?>
		
		<!--base stylesheet-->
		<link href="/style.css?fileversion=20261104" rel="stylesheet" type="text/css" media="all">
		
		<!-- typing quirk alt text -->
		<script src="/codefiles/typing-quirks.min.js?fileversion=20260410"></script>
		<!-- page settings -->
		<script src="/codefiles/page-settings.min.js?fileversion=20260410"></script>
		<!-- svg icons -->
		<script src="/graphix/svg-icons/svg-icons.js?fileversion=20260410" id="svg-icons-js"></script>
		
		<!--this page's stylesheet-->
		<link href="style.css?fileversion=20261104" rel="stylesheet" type="text/css" media="all">
	</head>
	
	<!-----------BODY------------------->
	<body>
		<main id="main">
			<?php			
			foreach ($fonts as $category => $list) { ?>
				<h2>
					<img src="/graphix/deco/spinning-disc.gif" alt="">
					<?php echo "<span>$category</span>"; ?>
					<img src="/graphix/deco/spinning-disc.gif" alt="">
				</h2>
				<?php
				foreach ($list as $f) {
					$class = strtolower(str_replace([" ","-","'"],"",$f["name"]));
					echo "<div class='font'>".(!empty($f["link"]) ? "<a href=\"".$f["link"]."\">" : "");
					?>
					<span class="fontname"><?php
						echo "<span class='display txt-$class'>".$f["name"]."</span>";
						if (!empty($f["unreadable"])) echo "<div class='tooltip' aria-hidden='true'>".$f["name"]."</div>";
						?>
					</span>
					<?php
					echo !empty($f["credit"]) ? "<p class='credit'>by ".$f["credit"]."</p>" : "";
					echo !empty($f["link"]) ? "</a>" : "";
					echo "</div>";
				} ?>
				<img src="/graphix/dividers/rainbow-squiggle.gif" alt="">
				<?php
			}
			?>
			
			<br>
			<br>
			<a class="btn btn-green" href="/">home</a>
			<br>
		</main>
	</body>
	<!--------------END BODY------------->
	<script>tqFormatElement(document.getElementById('main'))</script>
</html>
