<?php

error_reporting(E_ALL);
ini_set('display_errors',1);


session_start();
include("../config/connection.php");

if (!isset($_SESSION['email'])) {
    header("location: ../config/admin_login.php");
    exit();
}

?>
<!DOCTYPE HTML>
<html>
<head>
<title>Super Admin Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
 <link rel="icon" href="../assets/img/favicon.webp">
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
<!-- Custom Theme files -->
<link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
<!--js-->
<script src="js/jquery-2.1.1.min.js"></script> 
<!--icons-css-->
<link href="css/font-awesome.css" rel="stylesheet"> 
<!--Google Fonts-->
<link href='//fonts.googleapis.com/css?family=Carrois+Gothic' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Work+Sans:400,500,600' rel='stylesheet' type='text/css'>
<!--static chart-->
<script src="js/Chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<!--skycons-icons-->
<script src="js/skycons.js"></script>
<!--//skycons-icons-->
<style>
    .cke_notification_warning{
        display:none !important;
    }
    .table {
            border-top: 1px solid #ddd !important;
    border-bottom: 1px solid #ddd !important;
    border-left: 1px solid #ddd !important;
    }
    .table tbody tr td , .table thead tr th{
        border-right:1px solid #ddd !important;
    }
    .market-update-right i .fa .fa-phone-alt{
        transform:rotate(95deg) !important;
        color:red !important;
    }
    .market-update-block h3{
        font-size:35px !important;
        font-weight:normal !important;
    }
 
</style>
</head>
<body>