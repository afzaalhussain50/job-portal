<?php
include('Exp.php');
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
?>
