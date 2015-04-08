<?php
require_once __DIR__ . '/../tree.php';

class treeTest extends PHPUnit_Framework_TestCase
{
    /**
     * 測試建構子(直接指令 root 節點)
     */
    public function test_construct()
    {
        $tree = new Tree('Hello');
        $result = $tree->get_tree();
        $this->assertEquals(array('node' => 'Hello'), $result);
    }

    /**
     * 基本的測試
     */
    public function test_get_tree()
    {
        $tree = new Tree();
        $tree->set_root('root');
        $result = $tree->get_tree();
        $this->assertEquals(array('node' => 'root'), $result);
    }

    /**
     * 增加子節點測試
     */
    public function test_seek_and_add_child()
    {
        $tree = new Tree('root');

        // 增加一個節點
        $tree->add_child("child1");
        $success_result =
        [
            'node' => 'root',
            'childs' =>
            [
                ['node' => 'child1']
            ]
        ];
        $result = $tree->get_tree();
        $this->assertEquals($success_result, $result);

        // 增加第二個節點
        $tree->add_child("child2");
        $success_result =
        [
            'node' => 'root',
            'childs' =>
            [
                ['node' => 'child1'],
                ['node' => 'child2']
            ]
        ];
        $result = $tree->get_tree();
        $this->assertEquals($success_result, $result);

        // 走訪到第一個子節點 (child1)
        $tree->seek_child(0);

        // 增加第三個節點
        $tree->add_child("child3");
        $success_result =
        [
            'node' => 'root',
            'childs' =>
            [
                [
                    'node' => 'child1',
                    'childs' =>
                    [
                        ['node' => 'child3']
                    ]
                ],
                ['node' => 'child2']
            ]
        ];
        $result = $tree->get_tree();
        $this->assertEquals($success_result, $result);

        // 走訪回父節點 (root)
        $tree->seek_parent();

        // 走訪到第二個節點 (child2)
        $tree->seek_child(1);

        // 增加第四個節點
        $tree->add_child("child4");
        $success_result =
        [
            'node' => 'root',
            'childs' =>
            [
                [
                    'node' => 'child1',
                    'childs' =>
                    [
                        ['node' => 'child3']
                    ]
                ],
                [
                    'node' => 'child2',
                    'childs' =>
                    [
                        ['node' => 'child4']
                    ]
                ]
            ]
        ];
        $result = $tree->get_tree();
        $this->assertEquals($success_result, $result);

        // 走訪到上層 (root)
        $tree->seek_parent();

        // 走訪到最後一個節點 (child2)
        $tree->seek_last_child();

        // 增加第五個節點
        $tree->add_child("child5");
        $success_result =
        [
            'node' => 'root',
            'childs' =>
            [
                [
                    'node' => 'child1',
                    'childs' =>
                    [
                        ['node' => 'child3']
                    ]
                ],
                [
                    'node' => 'child2',
                    'childs' =>
                    [
                        ['node' => 'child4'],
                        ['node' => 'child5']
                    ]
                ]
            ]
        ];
        $result = $tree->get_tree();
        $this->assertEquals($success_result, $result);

        // 測試數量
        $this->assertEquals(6, $tree->get_count());
    }
}
