<?php

require_once(__DIR__.'/init.php');
htmlHeader();

// This is the custom result document class
class MyDoc extends Solarium\QueryType\Select\Result\Document
{
    public function getSpecialPrice()
    {
        $price = $this->price;
        if (is_array($price)) {
            $price = array_map(function($value) {
                return round(($value * 0.95), 2);
            }, $price);
        } else {
            $price = round(($price * 0.95), 2);
        }
        return $price;
    }
}




// create a client instance
$client = new Solarium\Client($adapter, $eventDispatcher, $config);

// get a select query instance
$query = $client->createSelect();

// set the custom resultclass
$query->setDocumentClass('MyDoc');


// this executes the query and returns the result
$resultset = $client->select($query);

// display the total number of documents found by Solr
echo 'NumFound: '.$resultset->getNumFound();


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

    // Handle "offer price" field
    $specialPrice = $document->getSpecialPrice();
    if (is_array($specialPrice)) {
        $specialPrice = implode(", ", $specialPrice);
    }
    echo '<tr><th>offer price</th><td>' . $specialPrice . '</td></tr>';

    echo '</table>';
}



htmlFooter();
