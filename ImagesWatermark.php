<?php

if (!isset($argv[1]) OR !isset($argv[2]))
{
    echo "Missing arguments";
    exit;
}

$sourceDir = $argv[1];
$destDir = $argv[2];

echo "Source: $sourceDir\n";
echo "Destination: $destDir\n\n";

$sourceFiles = [];
$sourceHandle = opendir($sourceDir);
if ($sourceHandle)
{
    while (false !== ($sourceFile = readdir($sourceHandle)))
    {
        if ($sourceFile != "." && $sourceFile != "..")
        {
            $sourceFiles[] = $sourceFile;
            $sourceFilePath = $sourceDir . "/" . $sourceFile;
            $mt = mime_content_type($sourceFilePath);
            
            $destFilePath = $destDir . "/" . $sourceFile;
            if ($mt == 'image/jpeg') $image = imagecreatefromjpeg($sourceFilePath);
            elseif ($mt == 'image/png') $image = imagecreatefrompng($sourceFilePath);
            else {
                echo "❌ File is not an image:  $sourceFile\n";
                continue;
            }
            imagettftext($image, 90, 0, 20, 103, 0x000000, "fonts/arial.ttf", $sourceFile);
            imagettftext($image, 90, 0, 22, 105, 0xffff00, "fonts/arial.ttf", $sourceFile);
            if ($mt == 'image/jpeg') imagejpeg($image, $destFilePath);
            elseif ($mt == 'image/png') imagepng($image, $destFilePath);
            echo "✅ Watermark added to:    $sourceFile\n";
        }
    }
}
closedir($sourceHandle);