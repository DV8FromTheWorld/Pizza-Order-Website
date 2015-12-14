<?php

function retrieve_photos($directory) {
	foreach (glob("{$directory}/thumbs/{*.jpg,*.png,*.JPG}", GLOB_BRACE) as $pathToThumb) {
		$filename = basename($pathToThumb);
		$pathToLarge = $directory . "/" . $filename;
		echo "<a href='{$pathToLarge}'><img src='{$pathToThumb}' alt='{$filename}'/></a>\n";
	}
}


