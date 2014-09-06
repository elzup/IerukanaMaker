<?php
/* @var $item
header("Content-type: text/xml;charset=utf-8"); 
echo '<?xml version="1.0" encoding="UTF-8"?>'; 

echo '
<rss version="2.0">
<channel>
<title>Title</title>
<link>http://website.com</link>
<description>Description</description>
<category>rss, feeds, in, php</category>
<generator>me :-)</generator>
<webMaster>my@email.com</webMaster>
';

// ループ部分は適宜内容を書き換えてください
for( ..looping..through..your..content.. )
{
echo '
<item>
<title>'.$item-title-var.'</title>
<link>'.$item-link-var.'</link>
<description>'.$item-description-var.'</description>
<author>'.$item-author-var.'</author>
<category>'.$item-category-var.'</category>
</item>
';
}

echo '
</channel>
</rss>
'; 