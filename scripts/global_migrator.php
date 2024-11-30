<?php

// Variables for file URL and database table name
$fileUrl = 'https://raw.githubusercontent.com/spazacomm/KCB-Content/refs/heads/main/uganda_teams.json';
$tableName = 'global_sets';

// Fetch and decode JSON data
$jsonData = file_get_contents($fileUrl);
$pagesData = json_decode($jsonData, true);

DB::transaction(function () use ($pagesData, $tableName) {
    foreach ($pagesData as $pageData) {
        DB::table($tableName)->updateOrInsert(
            ['id' => $pageData['id']], // Match condition
            $pageData // Use all fields dynamically
        );
    }
});

echo "Migrated data into the {$tableName} table";

