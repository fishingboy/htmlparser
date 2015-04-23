<?php
include_once 'htmlparser.php';

$html = <<<HTML
<html>
    <haed>
        <title>Hello Title</title>
    </head>
    <body>
        abc
        <div style="color:red">Hello World!</div>
    </body>
</html>
HTML;


// $html = <<<HTML
// <html>
//     <haed>
//         <title>Hello Title</title>
//     </head>
//     <body>
//         <div>1</div>
//         <div>2</div>
//     </body>
// </html>
// HTML;

$html = "<div>Hello <span>World!</span> !!!!</div>";
$parser = new Htmlparser($html);
$dom = $parser->get_dom();
echo "<pre>dom = " . print_r($dom, TRUE). "</pre>";

