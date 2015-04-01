<?php
/**
 * tree 實作
 *
 * @author Leo Kuo <et282523@hotmail.com>
 */
class tree
{
    /**
     * 樹 - 資料
     *
     * @var array
     */
    private $_tree = array();

    /**
     * 當前節點
     *
     * @var array 參考
     */
    private $_curr;

    /**
     * 目前樹的深度
     *
     * @var integer
     */
    private $_curr_level = 0;

    /**
     * 父節點參考的推疊
     *
     * @var array
     */
    private $_parent_stack = array();

    /**
     * 建構子
     *
     * @param mixed $value 根節點資料
     */
    public function __construct($value="")
    {
        if ($value)
        {
            $this->set_root($value);
        }
    }

    /**
     * 設定根節點
     *
     * @param mixed $value 根節點資料
     */
    public function set_root($value)
    {
        $this->_tree = $this->get_node_format($value);
        $this->_curr = & $this->_tree;
        $this->_curr_level = 0;
        $this->_parent_stack = array();
    }

    /**
     * 在目前位置增加子節點
     *
     * @param mixed $value 子節點資料
     */
    public function add_child($value)
    {
        $this->_curr['childs'][] = $this->get_node_format($value);
    }

    /**
     * 走訪父節點
     */
    public function seek_parent()
    {
        $this->_curr_level--;
        $this->_curr = & $this->_parent_stack[$this->_curr_level];
    }

    /**
     * 走訪子節點
     *
     * @param  integer $index 要走到第幾個子節點(從 0 開始)
     */
    public function seek_child($index=0)
    {
        $this->_parent_stack[] = & $this->_curr;
        $this->_curr = & $this->_curr['childs'][$index];
        $this->_curr_level++;
    }

    /**
     * 取得整顆樹
     *
     * @return array 樹的資料
     */
    public function get_tree()
    {
        return $this->_tree;
    }

    /**
     * 取得節點的資料格式
     * @param  mixed $value 節點資料
     * @return array        節點資料格式
     */
    function get_node_format($value)
    {
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

echo "<pre>tree = " . print_r($tree, TRUE). "</pre>";
?>