<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
include 'db.php';

$id = $_GET['id'];
$conn->query("DELETE FROM products WHERE id = $id");

header("Location: admin.php");
