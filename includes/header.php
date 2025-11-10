<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


session_start();
include("./config/connection.php");


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">    

    <title>Piyush Project</title>

    <!--Favicon-->
    <link rel="icon" href="assets/img/favicon.png">
    <!-- Bootstrap CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Line Awesome CSS -->
    <link href="assets/css/line-awesome.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="assets/css/fontAwesomePro.css" rel="stylesheet">
    <!-- Animate CSS-->
    <link href="assets/css/animate.css" rel="stylesheet">
    <!-- Bar Filler CSS -->
    <link href="assets/css/barfiller.css" rel="stylesheet">
    <!-- Magnific Popup Video -->
    <link href="assets/css/magnific-popup.css" rel="stylesheet">
    <!-- Flaticon CSS -->
    <link href="assets/css/flaticon.css" rel="stylesheet">
    <!-- Owl Carousel CSS -->
    <link href="assets/css/owl.carousel.css" rel="stylesheet">
    <!-- Slick Slider CSS -->
    <link href="assets/css/slick.css" rel="stylesheet">
    <!-- Nice Select  -->
    <link href="assets/css/nice-select.css" rel="stylesheet">
    <!-- Back to Top -->
    <link href="assets/css/backToTop.css" rel="stylesheet">
    <!-- Style CSS -->
    <link href="assets/css/style.css" rel="stylesheet">
    <!-- Responsive CSS -->
    <link href="assets/css/responsive.css" rel="stylesheet">
    

    <!-- jquery -->
    <script src="assets/js/jquery-1.12.4.min.js"></script>
    <style>
        @media only screen and (max-width: 767px) {
    /*	responsive menu start */

	.navbar-toggler {
		border: none;
		position: absolute;
        top: -62px;
		right: 90px;
		z-index: 99;
	}
	
	.navbar-brand img {
	    width:130px !important;
	}
	
	.header-right{
	    display:flex;
	    align-items:center;
	    justify-content:flex-end !important;
	}
	.header-right a{
	    margin-top:-88px!important;
	}
        }
    </style>

</head>

