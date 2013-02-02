<?php 
	header('Content-Type: text/xml');
	echo '<?xml version="1.0" encoding="UTF-8"?>
	<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
?>
<url>
<loc>http://www.socialdoor.it</loc>
		<lastmod><?php echo date("Y-m-d"); ?></lastmod>
		<changefreq>daily</changefreq>
		<priority>1.0</priority>
</url>

<url>
<loc>http://www.socialdoor.it/forgotpassword.php</loc>
		<lastmod><?php echo date("Y-m-d"); ?></lastmod>
		<changefreq>monthly</changefreq>
		<priority>0.5</priority>
</url>

<url>
<loc>http://www.socialdoor.it/login.php</loc>
		<lastmod><?php echo date("Y-m-d"); ?></lastmod>
		<changefreq>monthly</changefreq>
		<priority>0.5</priority>
</url>

<url>
<loc>http://www.socialdoor.it/signup.php</loc>
		<lastmod><?php echo date("Y-m-d"); ?></lastmod>
		<changefreq>monthly</changefreq>
		<priority>0.5</priority>
</url>

<url>
<loc>http://www.socialdoor.it/blog</loc>
		<lastmod><?php echo date("Y-m-d"); ?></lastmod>
		<changefreq>monthly</changefreq>
		<priority>0.5</priority>
</url>

<url>
<loc>http://www.socialdoor.it/readme.php</loc>
		<lastmod><?php echo date("Y-m-d"); ?></lastmod>
		<changefreq>monthly</changefreq>
		<priority>0.5</priority>
</url>

<?php
	include "./includes/mysqlclass.class.php";
	$mysql = new MySqlClass();
	$mysql->connect();
	$query = "SELECT idUser FROM users";
	$result = $mysql->query($query);
	while($user = mysql_fetch_array($result)){
		?>
	<url>
	<loc>http://www.socialdoor.it/room.php?id=<?php echo $user['idUser']; ?></loc>
		<lastmod><?php echo date("Y-m-d"); ?></lastmod>
		<changefreq>monthly</changefreq>
		<priority>0.5</priority>
	</url>
	<?php
	}
?>
</urlset>