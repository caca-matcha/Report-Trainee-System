<?php
$file = "d:/laragon/www/Report-trainee-system/resources/views/admin/master/trainings/create.blade.php";
$content = file_get_contents($file);

// Find trainers html block
$startT = strpos($content, "<div class=\"col-span-full pt-4 border-t border-gray-200 dark:border-gray-700 space-y-4\">");
$endT = strpos($content, "</div>", strpos($content, "id=\"no-trainers\""));
$endT = strpos($content, "</div>", $endT + 6) + 6; // Get closing tag of wrapper

$trainersHtml = substr($content, $startT, $endT - $startT);

// Find trainer script block
$startS = strpos($content, "// Script for Trainers");
$endS = strpos($content, "// Function to update participant display");
$trainersScript = substr($content, $startS, $endS - $startS);

$picHtml = str_replace(
    ["Daftar Trainer / Instruktur", "trainer", "Trainer", "TRAINER", "mengajar"],
    ["Daftar PIC", "pic", "PIC", "PIC", "bertanggung jawab pada"],
    $trainersHtml
);

$picScript = str_replace(
    ["trainer", "Trainer", "TRAINER"],
    ["pic", "PIC", "PIC"],
    $trainersScript
);

$newContent = substr_replace($content, $trainersHtml . "\n\n" . $picHtml, $startT, strlen($trainersHtml));

$startSNew = strpos($newContent, "// Script for Trainers");
$newContent = substr_replace($newContent, $trainersScript . "\n\n" . $picScript, $startSNew, strlen($trainersScript));

file_put_contents($file, $newContent);
echo "SUCCESS: create.blade.php\n";

// Same for Edit
$fileEdit = "d:/laragon/www/Report-trainee-system/resources/views/admin/master/trainings/edit.blade.php";
$contentE = file_get_contents($fileEdit);

$startTE = strpos($contentE, "<div class=\"col-span-full pt-4 border-t border-gray-200 dark:border-gray-700 space-y-4\">");
$endTE = strpos($contentE, "</div>", strpos($contentE, "id=\"no-trainers\""));
$endTE = strpos($contentE, "</div>", $endTE + 6) + 6;

$trainersHtmlE = substr($contentE, $startTE, $endTE - $startTE);

$startSE = strpos($contentE, "// Script for Trainers");
$endSE = strpos($contentE, "// Function to update participant display");
$trainersScriptE = substr($contentE, $startSE, $endSE - $startSE);

$picHtmlE = str_replace(
    ["Daftar Trainer / Instruktur", "trainer", "Trainer", "TRAINER", "mengajar"],
    ["Daftar PIC", "pic", "PIC", "PIC", "bertanggung jawab pada"],
    $trainersHtmlE
);

$picScriptE = str_replace(
    ["trainer", "Trainer", "TRAINER"],
    ["pic", "PIC", "PIC"],
    $trainersScriptE
);

$newContentE = substr_replace($contentE, $trainersHtmlE . "\n\n" . $picHtmlE, $startTE, strlen($trainersHtmlE));

$startSENew = strpos($newContentE, "// Script for Trainers");
$newContentE = substr_replace($newContentE, $trainersScriptE . "\n\n" . $picScriptE, $startSENew, strlen($trainersScriptE));

file_put_contents($fileEdit, $newContentE);
echo "SUCCESS: edit.blade.php\n";

