<?php

require_once(__DIR__.'/init.php');

htmlHeader();

// create a client instance
$client = new Solarium\Client($adapter, $eventDispatcher, $config);

// get a select query instance
$query = $client->createSelect();

// set a query (all prices starting from 12)
//$query->setQuery('price:[12 TO *]');
$query->setQuery('price:[2 TO *]');

// set start and rows param (comparable to SQL limit) using fluent interface
$query->setStart(2)->setRows(10);

// set fields to fetch (this overrides the default setting 'all fields')
$query->setFields(array('id','name','price', 'score'));


// sort the results by price ascending
//$query->addSort('price', $query::SORT_ASC);

$query->addSort('id', $query::SORT_ASC);

// this executes the query and returns the result
$resultset = $client->select($query);

// display the total number of documents found by Solr
echo 'NumFound: '.$resultset->getNumFound();

// display the max score
echo '<br>MaxScore: '.$resultset->getMaxScore();

// show documents using the resultset iterator
foreach ($resultset as $document) {

    echo '<hr/><table>';

    // the documents are also iterable, to get all fields
    foreach ($document as $field => $value) {
        // this converts multivalue fields to a comma-separated string
        if (is_array($value)) {
            $value = implode(', ', $value);
        }

        echo '<tr><th>' . $field . '</th><td>' . $value . '</td></tr>';
    }

    echo '</table>';
}

htmlFooter();
