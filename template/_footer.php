
<p id="footer">All content &copy; <?php echo $site['name']; ?> |
 Powered by <a href="<?php echo $app['site']; ?>">Studentware</a>
 <?php echo $app['ver']; ?>
 <?php if($app['queryCount']) { ?>
 <span id="queries"> | <?php echo $DB->queryCount; ?> queries</span>
 <?php } ?>
</p>

<script type="text/javascript" src="scripts/loader.js"></script>

<?php
if ($app['debug'])
	include('debug/debug.php');
?>

</body>
</html>
