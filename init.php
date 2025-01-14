<?php

session_start();
include_once "model/modelRoleSql.php";
include_once "model/modelItemSql.php";
include_once "model/modelUserSql.php";
include_once "model/modelSaleSql.php";
include_once "model/modelMemberSql.php";
include_once "model/modelCartSql.php";
//include_once "model/modelDetailSales.php";

// initiate
$modelRole = new modelRole();
$modelItem = new modelItem();
$modelUser = new modelUser();
$modelSale = new modelSaleSql();
$modelMember = new modelMember();
$modelCart = new modelCart();
//$modelDetailSale = new modelDetailSale();



?>