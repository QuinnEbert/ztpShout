#!/usr/local/bin/php
<?php require_once('Connections/settings.php');
// Add this to cron to reset the shoutbox whenever you would like
mysql_query('DELETE FROM `ztpShout`');
mysql_close($settings);