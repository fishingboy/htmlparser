<?php
class tree
{
    private $_tree = array();
    private $_curr;
    private $_curr_level = 0;
    private $_parent_stack = array();

    public function __construct($value="")
    {
        if ($value)
        {
            $this->set_root($value);
        }
    }

    public function set_root($value)
    {
        $this->_tree = $this->get_node($value);
        $this->_curr = & $this->_tree;
        $this->_curr_level = 0;
        $this->_parent_stack = array();
    }

    public function add_child($value)
    {
        $this->_curr['childs'][] = $this->get_node($value);
    }

    public function seek_parent()
    {
        // $this->_curr = & array_pop($this->_parent_stack);
        $this->_curr_level--;
        $this->_curr = & $this->_parent_stack[$this->_curr_level];
    }

    public function seek_child($index=0)
    {
        $this->_parent_stack[] = & $this->_curr;
        $this->_curr = & $this->_curr['childs'][$index];
        $this->_curr_level++;
    }

    public function get_tree()
    {
        return $this->_tree;
    }

    function get_node($value)
    {
        static $n;
        $n++;
        return array('node' => $value);
    }

}

$tree = new tree(1);
// $tree->set_root(1);
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


// function get_node($tag)
// {
//     static $n;
//     $n++;
//     return array('node' => $tag);
// }

// // html
// $parent = "";
// $tree = get_node("html");
// $curr = & $tree;

// // head
// $parent = & $curr;
// $curr = & $curr['childs'];
// $curr = (is_array($curr)) ? $curr : [];
// array_push($curr, get_node("head"));

// // head
// $parent = & $curr;
// $curr = & $curr['childs'];
// $curr = (is_array($curr)) ? $curr : [];
// array_push($curr, get_node("title"));

// array_push($curr, get_node());
// array_push($curr, get_node());

// $parent = & $curr;
// $curr = & $curr['childs'];
// $curr = array();
// array_push($curr, get_node());
// array_push($curr, get_node());
// array_push($curr, get_node());

// $curr = & $parent;
// array_push($curr, get_node());
// array_push($curr, get_node());
// array_push($curr, get_node());


// $tree = array
// (
//     'node'   => 'html',
//     'childs' => array
//     (
//         array
//         (
//             'node'   => 'head',
//             'childs' => array
//             (
//                 'node' => 'title',
//                 'value' => 'Hello World!'
//             )
//         ),
//         array
//         (
//             'node'   => 'body',
//             'childs' => array
//             (
//                 'node' => 'div',
//                 'value' => '....'
//             )
//         )
//     )
// );

echo "<pre>tree = " . print_r($tree, TRUE). "</pre>";




?>