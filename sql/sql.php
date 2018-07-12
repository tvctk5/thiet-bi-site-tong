<?php

include 'sql-function.php';

// Create connection
$conn = ConnectToSql();

// Create a new database
$sql = 'CREATE DATABASE IF NOT EXISTS ' . dbName .'';
if (mysqli_query($conn, $sql))
    echo "Database 'home' created successfully" . PHP_EOL;
else
    echo "Error creating database: " . mysqli_error($conn) . PHP_EOL;

// Select database
$sql = 'USE ' . dbName . '';
if ( !mysqli_query($conn, $sql))
    echo "Error use database: " . mysqli_error($conn) . PHP_EOL;

// sql to create table
//CreateTable($conn, "device");
//TaoBang($conn, "DieuKhien");

// Insert object to database
// ex ; InsertObject($conn,object-type,object-name,initial-state,color,amplitude,icon);
//InsertObject($conn,"obj-slider", "Living Room Light", 0, NULL, 30, "fa-lightbulb-o");
//InsertObject($conn,"obj-button", "Toilet Light", 0, "flavor-green", 30, "fa-lightbulb-o");
//InsertObject($conn,"obj-slider", "Bed Room Light", 0, "flavor-orange", 30, "fa-lightbulb-o");
//InsertObject($conn,"obj-button", "Font Door", 0, "flavor-violet", 0, "fa-wrench");

InsertObject($conn,"obj-vao", "Dien luoi", 0, "flavor-violet", 0, "fa-wrench");
InsertObject($conn,"obj-vao", "Dien may no", 0, "flavor-violet", 0, "fa-wrench");
InsertObject($conn,"obj-vao", "Dien tong dai", 0, "flavor-violet", 0, "fa-wrench");
InsertObject($conn,"obj-vao", "Nhiet do cao", 0, "flavor-violet", 0, "fa-wrench");
InsertObject($conn,"obj-vao", "Bao chay", 0, "flavor-violet", 0, "fa-wrench");

// them dong vao bang DieuKhien
//(donVi, tenTram, tenCanhBao, trangThai, ngayBD, gioBD, ngayKT, gioKT)
themDong($conn,"BGG", "Ke Sat", "Mat dien luoi", 1, DATE("d-m-yy"), "15:00","2018/2/24", "16:00" );


// Delete object to database
// DeleteObject($conn, "object-name");
//DeleteObject($conn, "Living Room Light");
//DeleteObject($conn, "Bed Room Light");

// Update object
// UpdateObject($conn,"object-name","name='value'");
//UpdateObject($conn,"Bed Room Light","amplitude='66'");



// Get object properties
// GetObject($conn);

CloseSql($conn);

?>
