<?php
/* @var $channel Channelobj */
header("Content-type: text/xml;charset=UTF-8");
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>


<rss version="2.0">
	<channel>
		<title><?= $channel->title ?></title>
		<link><?= $channel->link ?></link>
		<description><?= $channel->description ?></description>
		<generator><?= $channel->generator ?></generator>
		<webMaster><?= $channel->web_master ?></webMaster>
		<?php foreach ($channel->items as $item) { ?>
			<item>
				<title><?= $item->title ?></title>
				<link><?= $item->link ?></link>
				<description><?= $item->description ?></description>
				<author><?= $item->author ?></author>
				<category><?= $item->category ?></category>
				<pubDate><?= $item->pub_date ?></pubDate>
				<guid isPermaLink="false"><?= $item->guid ?></guid>
			</item>
		<?php } ?>
	</channel>
</rss>