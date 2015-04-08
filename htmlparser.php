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
    // 開頭 TAG
    const HEAD_TAG   = 1;
    // 結尾 TAG
    const FOOT_TAG   = 2;
    // 單一 TAG (如 <br />)
    const SINGLE_TAG = 3;

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
        $i=0;
        while ($curr_pos < $html_length)
        {
            // 找下一個 TAG
            $lt_pos = strpos($this->_html, '<', $curr_pos+1);
            $gt_pos = strpos($this->_html, '>', $lt_pos);
            if ($lt_pos === FALSE)
            {
                break;
            }
            $tag = substr($this->_html, $lt_pos, $gt_pos-$lt_pos+1);

            // 取得文字內容
            $content = trim(substr($this->_html, $curr_pos+1, $lt_pos-$curr_pos-1));
            if ($content)
            {
                $tree->add_child(array('content' => $content));
            }

            // TAG 處理
            $tag_type = $this->get_tag_type($tag);
            switch ($tag_type)
            {
                // 開頭 TAG
                case SELF::HEAD_TAG :
                    $tag_name = $this->get_tag_name($tag);
                    if ($tree->get_count() == 0)
                    {
                        $tree->set_root(['tag' => $this->get_tag_name($tag)]);
                    }
                    else
                    {
                        $tree->add_child(['tag' => $this->get_tag_name($tag)]);
                        $tree->seek_last_child();
                    }

                    // 加入未結尾 TAG 的堆疊
                    $tag_stack[] = $tag_name;
                    break;

                // 結尾 TAG
                case SELF::FOOT_TAG :
                    $tag_head = array_pop($tag_stack);
                    $tag_name = $this->get_end_tag_name($tag);
                    if ($tag_head != $tag_name)
                    {
                        // echo "[$tag_head] ==> [$tag_name]\n";
                        // TODO: 將該節點底下的子節點，移到跟該節點同一層的地方
                    }
                    $tree->seek_parent();
                    break;

                // 單一 TAG
                case SELF::SINGLE_TAG :
                    // 直接將節點加入
                    $tag_name = $this->get_end_tag_name($tag);
                    $tree->add_child(['tag' => $this->get_tag_name($tag)]);
                    break;
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
     * 取得結尾 TAG 名稱
     * @param  string $tag 完整的 TAG 字串
     * @return string      Tag 名稱(大寫)
     */
    public function get_end_tag_name($tag='')
    {
        preg_match("/^<(\/)?([a-z]+)/i", $tag, $tmp);
        return strtoupper($tmp[2]);
    }

    /**
     * 判斷是否為結尾的 TAG
     * @param  string  $tag 完整 TAG 字串
     * @return integer      Tag 的類型
     */
    public function get_tag_type($tag)
    {
        // 結尾 TAG
        if ($tag[1] == '/')
        {
            return Htmlparser::FOOT_TAG;
        }

        // 單一結尾 TAG
        if ($tag[strlen($tag)-2] == '/')
        {
            return Htmlparser::SINGLE_TAG;
        }

        // 開頭 TAG
        return Htmlparser::HEAD_TAG;
    }
}
