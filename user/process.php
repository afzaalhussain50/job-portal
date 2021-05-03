<?php
require('config.php');
include('Exp.php');
include('Education.php');
include('Certification.php');
$emp = new Exp();
if(!empty($_POST['action']) && $_POST['action'] == 'listExp') {
    $emp->expList();
}
if(!empty($_POST['action']) && $_POST['action'] == 'addExp') {
    $emp->addExp();
}
if(!empty($_POST['action']) && $_POST['action'] == 'getExp') {
    $emp->getExp();
}
if(!empty($_POST['action']) && $_POST['action'] == 'updateExp') {
    $emp->updateExp();
}
if(!empty($_POST['action']) && $_POST['action'] == 'deleteExp') {
    $emp->deleteExp();
}

$edu = new Education();
if(!empty($_POST['action']) && $_POST['action'] == 'listEdu') {
    $edu->eduList();
}
if(!empty($_POST['action']) && $_POST['action'] == 'addEdu') {
    $edu->addEdu();
}
if(!empty($_POST['action']) && $_POST['action'] == 'getEdu') {
    $edu->getEdu();
}
if(!empty($_POST['action']) && $_POST['action'] == 'updateEdu') {
    $edu->updateEdu();
}
if(!empty($_POST['action']) && $_POST['action'] == 'deleteEdu') {
    $edu->deleteEdu();
}


$cer = new Certification();
if(!empty($_POST['action']) && $_POST['action'] == 'listCer') {
    $cer->cerList();
}
if(!empty($_POST['action']) && $_POST['action'] == 'addCer') {
    $cer->addCer();
}
if(!empty($_POST['action']) && $_POST['action'] == 'getCer') {
    $cer->getCer();
}
if(!empty($_POST['action']) && $_POST['action'] == 'updateCer') {
    $cer->updateCer();
}
if(!empty($_POST['action']) && $_POST['action'] == 'deleteCer') {
    $cer->deleteCer();
}



?>
