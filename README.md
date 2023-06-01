# solarium

Original repository is  here: https://github.com/solariumphp/solarium 

In order to work with examples folder in Solarium we need to create a core in Solr with data taken from Solr folders . Then import and index xml files using command line like it is done in this video: Solr Indexing Sample Docs to solr core and searching with various filter query options   https://www.youtube.com/watch?v=rxoS1p1TaFY&t=304s  

The command Line for CMD according to the video: java -Dc=music -jar post.jar *.xml

<h4> let assume file as dummy.xml under example/exampledocs directory.
Go to exampledocs directory using command prompt & execute -
java -jar post.jar dummy.xml

For multiple XML files use -
java -jar post.jar dummy.xml dummy1.xml

For all XML files present in working directory use-
java -jar post.jar *.xml  </h4>

<br>
<br>
<br>


Also in the  version PHP 8.1 in some php files of solarium project appeared  following errors:  "Warning: Array to string conversion" . And  because of them  some outputs did not appear.

<h1> I  substituted the  following code in php files : </h1>

      // show documents using the resultset iterator
      foreach ($resultset as $document) {
         echo '<hr/><table>';
         echo '<tr><th>id</th><td>' . $document->id . '</td></tr>';
         echo '<tr><th>name</th><td>' . $document->name . '</td></tr>';
         echo '<tr><th>price</th><td>' . $document->price . '</td></tr>';
         echo '</table>';
      }

<h1> with this kind of code and desired output appeared. </h1>

            // show documents using the resultset iterator
            foreach ($resultset as $document) {
                echo '<hr/><table>';
                echo '<tr><th>id</th><td>' . $document->id . '</td></tr>';

                // Handle "name" field
                $name = $document->name;
                if (is_array($name)) {
                    $name = implode(", ", $name);
                }
                echo '<tr><th>name</th><td>' . $name . '</td></tr>';

                // Handle "price" field
                $price = $document->price;
                if (is_array($price)) {
                    $price = implode(", ", $price);
                }
                echo '<tr><th>price</th><td>' . $price . '</td></tr>';

                echo '</table>';
            }







