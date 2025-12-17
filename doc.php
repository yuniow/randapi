<?php

// 模拟一个浏览器请求
$options = array(
    'http'=>array(
        'method'=>"GET",
        'header'=>"User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:100.0) Gecko/20100101 Firefox/100.0\r\n"
    )
);

$context = stream_context_create($options);

// 目标网页地址
$url = "https://docs.qq.com/doc/DUFVza0Fmc2FBcG5E";

// 获取页面内容
$page_content = file_get_contents($url, false, $context);

// 模拟滚动到底部，等待网页加载
echo "Scrolling to bottom...\n";
echo "Waiting for page to load...\n";
sleep(15); // 等待5秒钟

// 从页面内容中提取包含docs.qq.com的URL
preg_match_all('/(https?:\/\/(?:[^\s"]+)?docs\.qq\.com[^\s"]+)/', $page_content, $matches);

// 将匹配的URL写入文件
if (isset($matches[1])) {
    $fp = fopen("acc.log", "w");
    foreach ($matches[1] as $url) {
        fwrite($fp, $url."\n");
    }
    fclose($fp);
    echo "URLs written to acc.log file.\n";
} else {
    echo "No URLs found.\n";
}
