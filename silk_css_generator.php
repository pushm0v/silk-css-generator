<?php
//path to directory to scan
$directory = dirname(__FILE__) . "/icons/";
$cssFile = dirname(__FILE__)  . "/silk.css";

// Create recursive dir iterator which skips dot folders
$dir = new RecursiveDirectoryIterator($directory,
    FilesystemIterator::SKIP_DOTS);

// Flatten the recursive iterator, folders come before their files
$it  = new RecursiveIteratorIterator($dir,
    RecursiveIteratorIterator::SELF_FIRST);

// Maximum depth is 1 level deeper than the base folder
$it->setMaxDepth(1);

$cssCore = "
/**
* this css is for the free \"silk\" icon library
* http://www.famfamfam.com
*
*/
.icon-32 { height:32px; width:32px}
.icon-24 { height:24px; width:24px}
\n\n
";

$cssLine = ".%s { background-image: url(icons/%s) !important; background-repeat: no-repeat; }";

// Basic loop displaying different messages based on file or folder
foreach ($it as $fileinfo) {
    if ($fileinfo->isFile()) {
        $fname = $fileinfo->getFilename();
        $css = str_replace("_", "-", current(explode(".",$fname)));

        //Just append the string
        $cssCore .= sprintf($cssLine,"silk-".$css,$fname) . "\n";
    }
}

//Write into file, OVERWRITE mode... refer to http://php.net/file_put_contents for APPEND mode
file_put_contents($cssFile, $cssCore);
?>