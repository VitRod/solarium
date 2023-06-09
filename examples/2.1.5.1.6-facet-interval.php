<?php

require_once(__DIR__.'/init.php');
htmlHeader();

// create a client instance
$client = new Solarium\Client($adapter, $eventDispatcher, $config);

// get a select query instance
$query = $client->createSelect();

// get the facetset component
$facetSet = $query->getFacetSet();

// create a facet interval instance and set options
$facet = $facetSet->createFacetInterval('price');
$facet->setField('price');
$facet->setSet(array('1-9' => '[1,10)', '10-49' => '[10,50)', '49>' => '[50,*)'));

// this executes the query and returns the result
$resultset = $client->select($query);

// display the total number of documents found by Solr
echo 'NumFound: '.$resultset->getNumFound();

// display facet counts
echo '<hr/>Facet intervals:<br/>';
$facet = $resultset->getFacetSet()->getFacet('price');
foreach ($facet as $interval => $count) {
    echo $interval . ' [' . $count . ']<br/>';
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


htmlFooter();
