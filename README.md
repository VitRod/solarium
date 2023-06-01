# solarium

Original repository is  here https://github.com/solariumphp/solarium 

In the  version PHP 8.1 in some  files appeared the  following errors:  "Warning: Array to string conversion" . And  because of it  some output did not appear.

<h1> I  substituted the  following code in php file : </h1>
      // show documents using the resultset iterator
      
      foreach ($resultset as $document) {
         echo '<hr/><table>';
         echo '<tr><th>id</th><td>' . $document->id . '</td></tr>';
         echo '<tr><th>name</th><td>' . $document->name . '</td></tr>';
         echo '<tr><th>price</th><td>' . $document->price . '</td></tr>';
         echo '</table>';
      }

<h1> with this kind of code and the desired output appeared. </h1>
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







