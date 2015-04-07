<?php
require_once 'PHPUnit/Autoload.php';
require_once __DIR__ . '/../tree.php';

class treeTest extends PHPUnit_Framework_TestCase
{
    public function test_get_tree()
    {
        $tree = new Tree();
        $tree->set_root('root');
        $result = $tree->get_tree();
        $this->assertEquals(array('node' => 'root'), $result);
    }
}
