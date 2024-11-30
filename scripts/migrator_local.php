<?php

// Variables for file path and database table name
$filePath = '/var/www/kcb-content/kenya/global_sets.json';
$tableName = 'global_sets';

// Fetch and decode JSON data
if (!file_exists($filePath)) {
    die("File not found: {$filePath}");
}

$jsonData = file_get_contents($filePath);
$pagesData = json_decode($jsonData, true);

if ($pagesData === null) {
    die("Failed to decode JSON from: {$filePath}");
}

DB::transaction(function () use ($pagesData, $tableName) {
    foreach ($pagesData as $pageData) {
        DB::table($tableName)->updateOrInsert(
            ['id' => $pageData['id']], // Match condition
            $pageData // Use all fields dynamically
        );
    }
});

echo "Migrated data into the {$tableName} table";
