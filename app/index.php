<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

if (!isset($_SESSION["nombre"])) header('location: ./auth?m=5');
if (!$_SESSION["role"] == 'admin') {
    header('location: ./auth/?error=401');
} else {
    header('location: ./game/');
}
