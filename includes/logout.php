<?php
require_once("../config.php");
session_start();
session_destroy();
header('location:' . GET_APP_URL() . '/login.php');
