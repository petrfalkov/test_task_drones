<?php
include('database.php');

// create DB
try {
    $db = new PDO($DB_DSN_GLOBAL, $DB_USER, $DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->query("CREATE DATABASE IF NOT EXISTS drone_assets");
} catch (PDOException $e) {
    echo "ERROR CREATING DB: " . $e->getMessage() . "\n";
}
// build DB structure
try {
    $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->query("CREATE TABLE IF NOT EXISTS photos (
	photo_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	photo_dscr TEXT,
	photo_name VARCHAR(255) NOT NULL,
	photo_content TEXT NOT NULL,
	photo_likes INT(6) DEFAULT '0',
	photo_time TIMESTAMP
	)");
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
//photos: id, description, meta_words, photo, likes(number), date_of_upload
?>