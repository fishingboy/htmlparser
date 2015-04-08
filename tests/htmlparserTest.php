<?php
require_once 'PHPUnit/Autoload.php';
require_once __DIR__ . '/../htmlparser.php';

class htmlparserTest extends PHPUnit_Framework_TestCase
{
    /**
     * 基本的測試
     */
    public function test_get_dom()
    {
        $parser = new Htmlparser("<span>Hello</span>");
        $dom = $parser->get_dom();
        $success_result =
        [
            'node' => ['tag' => 'SPAN'],
            'childs' =>
            [
                ['node' => ['content' => 'Hello']]
            ]
        ];
        $this->assertEquals($success_result, $dom);
    }

    /**
     * parse 測試
     */
    public function test_parse()
    {
        $parser = new Htmlparser("<div><span>Hello</span></div>");
        $dom = $parser->get_dom();
        $success_result =
        [
            'node'   => ['tag' => 'DIV'],
            'childs' =>
            [
                [
                    'node' => ['tag' => 'SPAN'],
                    'childs' =>
                    [
                        ['node' => ['content' => 'Hello']]
                    ]
                ]
            ]
        ];
        $this->assertEquals($success_result, $dom);
    }

    /**
     * get_tag 測試
     */
    public function test_get_tag()
    {
        $this->assertEquals("DIV", Htmlparser::get_tag_name("<div>"));
        $this->assertEquals("SPAN", Htmlparser::get_tag_name("<SpAn style='color:red'>"));
    }

    /**
     * is_end_tag 測試
     */
    public function test_is_end_tag()
    {
        $this->assertEquals(FALSE, Htmlparser::is_end_tag("<div>"));
        $this->assertEquals(TRUE, Htmlparser::is_end_tag("</div>"));
        $this->assertEquals(TRUE, Htmlparser::is_end_tag("<br />"));
        $this->assertEquals(FALSE, Htmlparser::is_end_tag("<br>"));
    }
}
