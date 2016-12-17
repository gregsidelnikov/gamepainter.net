<?php /* Grigoriy Sidelnikov (greg.sidelnikov@gmail.com) Article Page */

  @include('../Migration/Composition.php');

  // Include the unique class that defines the data type for this page
  @include($FILESYSTEM . '/Classes/Page/class.Article.php');

  $Connection = new MysqlDatabase(); // Create the MySQL connection object, connect to the database and guarantee a successful connection

  if ($Connection->isReady())
  {
      $Article = MysqlDatabase::getTableData( "article", "`location`");

      $Blog    = MysqlDatabase::getTableData( "blog", "`location`");

      if ($Blog || $Article)
      {
          $BR = "\r\n";

          echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>$BR<urlset xmlns=\"http://www.google.com/schemas/sitemap/0.84\">$BR";

          for ($i=0;$i<count($Article);$i++)
              if ($Article[$i]['location'])
                  print "    <url><loc>http://localhost/authenticsociety.com/about/" . $Article[$i]['location'] . "</loc></url>" . $BR;

          for ($i=0;$i<count($Blog);$i++)
              if ($Blog[$i]['location'])
                  print "    <url><loc>http://localhost/authenticsociety.com/blog/" . $Blog[$i]['location'] . "</loc></url>" . $BR;

          print "</urlset>$BR";
      }
  }

?>