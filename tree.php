<?php
/**
 * tree 實作
 *
 * @author Leo Kuo <et282523@hotmail.com>
 */
class Tree
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
     * 節點數量
     *
     * @var integer
     */
    private $_node_count = 0;

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
        $this->_node_count = 1;
    }

    /**
     * 在目前位置增加子節點
     *
     * @param mixed $value 子節點資料
     */
    public function add_child($value)
    {
        $this->_curr['childs'][] = $this->get_node_format($value);
        $this->_node_count++;
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
        $this->_parent_stack[$this->_curr_level] = & $this->_curr;
        $this->_curr = & $this->_curr['childs'][$index];
        $this->_curr_level++;
    }

    /**
     * 走訪子節點
     *
     * @param  integer $index 要走到第幾個子節點(從 0 開始)
     */
    public function seek_last_child()
    {
        $last_index = count($this->_curr['childs']);
        $this->seek_child($last_index - 1);
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
     * 取得節點數量
     *
     * @return integer 節點數量
     */
    public function get_count()
    {
        return $this->_node_count;
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

    /**
     * 取得目前節點的子節點
     * @return mixed 子節點資料
     */
    public function get_childs()
    {

        return $this->_curr['childs'];
    }

    /**
     * 移除目前節點的子節點
     * @return boolean 是否成功移除
     */
    public function remove_childs()
    {
        if (isset($this->_curr['childs']))
        {
            // TODO:COUNT 有問題，晚點處理
            $this->_node_count -= $this->get_childs_count();
            unset($this->_curr['childs']);
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    // TODO: 完成這個 METHOD
    public function get_childs_count($value='')
    {
        return 1;
    }
}
