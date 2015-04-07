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
}
