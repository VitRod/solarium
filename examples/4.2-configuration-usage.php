<?php

require_once(__DIR__.'/init.php');
htmlHeader();


// In this case an array is used for configuration to keep the example simple.
// For an easier to use config file you are probably better of with another format, like Zend_Config_Ini
// See the documentation for more info about this.
$select = array(
    'query'         => '*:*',
    'start'         => 2,
    'rows'          => 20,
    'fields'        => array('id','name','price'),
    'sort'          => array('price' => 'asc'),
    'filterquery' => array(
        'maxprice' => array(
            'query' => 'price:[1 TO 300]'
        ),
    ),
    'component' => array(
        'facetset' => array(
            'facet' => array(
                // notice this config uses an inline key value under 'local_key', instead of array key like the filterquery
                array('type' => 'field', 'local_key' => 'stock', 'field' => 'inStock'),
            )
        ),
    ),
);

// create a client instance
$client = new Solarium\Client($adapter, $eventDispatcher, $config);

// get a select query instance based on the config
$query = $client->createSelect($select);

// this executes the query and returns the result
$resultset = $client->select($query);

// display the total number of documents found by Solr
echo 'NumFound: '.$resultset->getNumFound();

// display facet counts
echo '<hr/>Facet counts for field "inStock":<br/>';
$facet = $resultset->getFacetSet()->getFacet('stock');
foreach ($facet as $value => $count) {
    echo $value . ' [' . $count . ']<br/>';
}

// show documents using the resultset iterator
//foreach ($resultset as $document) {
//
//    echo '<hr/><table>';
//    echo '<tr><th>id</th><td>' . $document->id . '</td></tr>';
//    echo '<tr><th>name</th><td>' . $document->name . '</td></tr>';
//    echo '<tr><th>price</th><td>' . $document->price . '</td></tr>';
//    echo '</table>';
//}

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





htmlFooter();
