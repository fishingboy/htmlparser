<?php
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
        $html = <<<HTML
        <div>
            <span>Hello</span>
            <br/>
            <br>
            <p>World!</p>
            <p>World!</p>
        </div>
HTML;
        $parser = new Htmlparser($html);
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
                        ['node' => ['content' => 'Hello']],
                    ]
                ],
                [
                    'node' => ['tag' => 'BR']
                ],
                [
                    'node' => ['tag' => 'BR']
                ],
                [
                    'node' => ['tag' => 'P'],
                    'childs' =>
                    [
                        ['node' => ['content' => 'World!']]
                    ]
                ],
                [
                    'node' => ['tag' => 'P'],
                    'childs' =>
                    [
                        ['node' => ['content' => 'World!']]
                    ]
                ]
            ]
        ];

        $this->assertEquals($success_result, $dom);
    }

    /**
     * parse 測試
     */
    public function test_parse_no_foot_tag()
    {
        // 不允許沒有結尾的 TAG
        $html = <<<HTML
        <div>
            <span>Hello
            <span>World!</span>
        </div>
HTML;
        $parser = new Htmlparser($html);
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
                        ['node' => ['content' => 'Hello']],
                        [
                            'node' => ['tag' => 'SPAN'],
                            'childs' =>
                            [
                                ['node' => ['content' => 'World!']]
                            ]
                        ],
                    ]
                ]
            ]
        ];
        $this->assertEquals($success_result, $dom);

        // 不允許沒有結尾的 TAG
        $html = <<<HTML
        <div>
            <input type='checkout' value='1'>Hello
            <span>World!</span>
        </div>
HTML;
        $parser = new Htmlparser($html);
        $dom = $parser->get_dom();
        $success_result =
        [
            'node'   => ['tag' => 'DIV'],
            'childs' =>
            [
                [
                    'node' => ['tag' => 'INPUT'],
                ],
                ['node' => ['content' => 'Hello']],
                [
                    'node' => ['tag' => 'SPAN'],
                    'childs' =>
                    [
                        ['node' => ['content' => 'World!']]
                    ]
                ],
            ]
        ];

        // echo "<pre>dom = " . print_r($dom, TRUE). "</pre>";
        // echo "\n--------------------------------------------------\n";
        // echo "<pre>success_result = " . print_r($success_result, TRUE). "</pre>";

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
    public function test_get_tag_type()
    {
        $this->assertEquals(Htmlparser::HEAD_TAG,   Htmlparser::get_tag_type("<div>"));
        $this->assertEquals(Htmlparser::FOOT_TAG,   Htmlparser::get_tag_type("</div>"));
        $this->assertEquals(Htmlparser::SINGLE_TAG, Htmlparser::get_tag_type("<br />"));
        $this->assertEquals(Htmlparser::HEAD_TAG,   Htmlparser::get_tag_type("<br>"));
    }

    /**
     * get_tag 測試
     */
    public function test_get_end_tag()
    {
        $this->assertEquals("DIV", Htmlparser::get_end_tag_name("</div>"));
        $this->assertEquals("SPAN", Htmlparser::get_end_tag_name("</SpAn>"));
        $this->assertEquals("BR", Htmlparser::get_end_tag_name("<br/>"));
        $this->assertEquals("INPUT", Htmlparser::get_end_tag_name("<input type='button' value='ok'/>"));
    }

    /**
     * get_tag 測試
     */
    public function test_get_format_html()
    {
        $this->assertEquals("DIV", Htmlparser::get_format_html("<div>1</div>"));
    }
}
