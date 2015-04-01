<?php
include_once("tree.php");

$tree = new tree(1);
$tree->add_child(2);
$tree->add_child(3);

$tree->seek_child(1);
$tree->add_child(4);
$tree->add_child(5);

$tree->seek_child(1);
$tree->add_child(6);
$tree->add_child(7);

$tree->seek_parent();
$tree->add_child(8);
$tree->add_child(9);

$result = $tree->get_tree();

echo "<pre>result = " . print_r($result, TRUE). "</pre>";
?>