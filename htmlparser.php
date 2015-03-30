<?php
$html = <<<HTML
<html>
    <haed>
    <title>Hello Title</title>
    </head>
    <body>
    abc
    <div style="color:red">Hello World!</div><br />
    </body>
</html>
HTML;

// $html = "<div>Hello World!</div>";
echo "html={$html}";
$parser = new Htmlparser($html);


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
        $curr_tag = "";
        $curr_dom = & $this->_dom;
        $curr_level = 0;
        $curr_count = array();
        $prev_tag = "";
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
            echo "tag=" . htmlspecialchars($tag, ENT_QUOTES);
            // echo "text=" . htmlspecialchars($text, ENT_QUOTES);
            if ($this->_is_end_tag($tag))
            {
                $curr_level--;
                echo "end tag = " . htmlspecialchars($tag, ENT_QUOTES) . "<br>";
            }
            else
            {
                $curr_level++;
                // $curr_dom = & $curr_dom['childs'][] = array();
                // array_push($curr_dom, $tag);
            }
            $content = substr($this->_html, $curr_pos+1, $lt_pos-$curr_pos-1);
            echo "content = " . htmlspecialchars($content, ENT_QUOTES) . "<br>";
            $curr_pos = $gt_pos;
        }

        echo "<pre>this->_dom = " . print_r($this->_dom, TRUE). "</pre>";
    }

    public function get_dom()
    {
        return $this->_dom;
    }

    private function _is_end_tag($tag)
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
