<?php
include_once('tree.php');

// $html = <<<HTML
// <html>
//     <haed>
//         <title>Hello Title</title>
//     </head>
//     <body>
//         abc
//         <div style="color:red">Hello World!</div>
//     </body>
// </html>
// HTML;


$html = <<<HTML
<html>
    <haed>
        <title>Hello Title</title>
    </head>
    <body>
        <div>1</div>
        <div>2</div>
    </body>
</html>
HTML;

$html = "<div>Hello <span>World!</span> !!!!</div>";
// echo "html={$html}";
$parser = new Htmlparser($html);


// echo "tag = " . Htmlparser::get_tag_name("<div>");


/**
 * HTML PARSER
 *
 * @author Leo Kuo <et282523@hotmail.com>
 */
class Htmlparser
{
    /**
     * HTML
     *
     * @var string
     */
    private $_html;

    /**
     * DOM 元素
     *
     * @var array
     */
    private $_dom = array();

    /**
     * 建構子
     */
    public function __construct($html)
    {
        $this->_html = $html;
        $this->parse();
    }

    /**
     * HTML 解析
     * @param  string $html HTML
     * @return array        DOM 元素
     */
    public function parse()
    {
        $curr_pos = -1;
        $html_length = strlen($this->_html);
        $stack = array();

        $tree = new Tree();
        $tag_stack = array();
        while ($curr_pos < $html_length)
        {
            $lt_pos = strpos($this->_html, '<', $curr_pos+1);
            $gt_pos = strpos($this->_html, '>', $lt_pos);
            if ($lt_pos === FALSE)
            {
                break;
            }
            // echo "lt_pos={$lt_pos}, gt_pos={$gt_pos}<br>";
            // $text = substr($this->_html, $curr_pos+1, $lt_pos-$curr_pos+2);
            $tag = substr($this->_html, $lt_pos, $gt_pos-$lt_pos+1);
            // echo "tag=" . htmlspecialchars($tag, ENT_QUOTES);
            // echo "text=" . htmlspecialchars($text, ENT_QUOTES);
            $content = trim(substr($this->_html, $curr_pos+1, $lt_pos-$curr_pos-1));
            if ($content)
            {
                // echo "<pre>content = " . print_r($content, TRUE). "</pre>";
                $tree->add_child(array('content' => $content));
            }

            if ($this->is_end_tag($tag))
            {
                $tag_head = array_pop($tag_stack);
                // if ($tag_head)
                // {
                // }
                $tree->seek_parent();
            }
            else
            {
                $tag_name = $this->get_tag_name($tag);
                if ($tree->get_count() == 0)
                {
                    $tree->set_root(array('tag' => $this->get_tag_name($tag)));
                }
                else
                {
                    $tree->add_child(array('tag' => $this->get_tag_name($tag)));
                    $tree->seek_last_child();
                }

                $tag_stack[] = $tag_name;
            }
            $curr_pos = $gt_pos;
        }

        $this->_dom = $tree->get_tree();
        // echo "<pre>this->_dom = " . print_r($this->_dom, TRUE). "</pre>";
    }

    /**
     * 取得整個 dom 的結構
     *
     * @return mixed dom 的結構
     */
    public function get_dom()
    {
        return $this->_dom;
    }

    /**
     * 取得 TAG 名稱
     * @param  string $tag 完整的 TAG 字串
     * @return string      Tag 名稱(大寫)
     */
    public function get_tag_name($tag='')
    {
        preg_match("/^<([a-z]+)/i", $tag, $tmp);
        return strtoupper($tmp[1]);
    }

    /**
     * 判斷是否為結尾的 TAG
     * @param  string  $tag 完整 TAG 字串
     * @return boolean      是否為結尾的 TAG
     */
    public function is_end_tag($tag)
    {
        if ($tag[1] == '/')
        {
            return TRUE;
        }

        if ($tag[strlen($tag)-2] == '/')
        {
            return TRUE;
        }

        return FALSE;
    }
}
