<b>Download WC3 maps. A majority of the maps listed are clean, no cheat or cheat removed.</b>
<?php
	$path = "C:\Program Files (x86)\Warcraft III\Maps\Download\\";
	if ($handle = opendir($path)) {
		while (false !== ($file = readdir($handle)))
			{
				if ($file != "." && $file != "..")
				{
				$files .= '<a href="'.$file.'">'.$file.'</a>';
				}
			}
		closedir($handle);
	}
?>