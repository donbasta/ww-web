<?php 
  if (!isset($_COOKIE['currentUsername'])) {
    header('Location: ./php/login.php');
  }

  // $checkTokenExpiry = include('checkTokenExpiryTime.php');
  // $isTokenAvailable = $checkTokenExpiry($_COOKIE['currentUsername']);
  // if (!$isTokenAvailable) {
  //   return header('Location: logout.php');
  // }
  
  header('Location: ./php/dashboard.php');
?>