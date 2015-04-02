<?php
include_once("tree.php");

$tree = new tree();

// =============================
$tree->set_root("html");

// =============================
$tree->add_child("head");
$tree->seek_last_child();

// =============================
$tree->add_child("title");
$tree->seek_last_child();

// =============================
$tree->seek_parent();

// =============================
$tree->seek_parent();

// =============================
$tree->add_child('body');
$tree->seek_last_child();

// =============================
$tree->add_child('div');
$tree->seek_last_child();

// =============================
$tree->seek_parent();

// =============================
$tree->add_child('div');
$tree->seek_last_child();

// =============================
$tree->seek_parent();


$result = $tree->get_tree();

echo "<pre>result = " . print_r($result, TRUE). "</pre>";
echo "<hr>";
echo "<pre>tree = " . print_r($tree, TRUE). "</pre>";
?>