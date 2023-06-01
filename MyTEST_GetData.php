<?php

use Solarium\Core\Client\Adapter\Curl;
use Symfony\Component\EventDispatcher\EventDispatcher;

error_reporting(E_ALL);
ini_set('display_errors', true);

$config = array(
    'endpoint' => array(
        'localhost' => array(
            'scheme' => 'http', # or https
            'host' => '127.0.0.1',
            'port' => 8983,
            'path' => '/',
            // 'context' => 'solr', # only necessary to set if not the default 'solr'
            //'core' => 'films_core',
            'core' => 'techproducts',
        )
    )
);

require $config['autoload'] ?? __DIR__.'/vendor/autoload.php';

$adapter = new Curl();
$eventDispatcher = new EventDispatcher();

//function htmlHeader()
//{
//    echo '<html><head><title>Solarium examples</title></head><body><nav><a href="index.html">Back to Overview</a></nav><br><article>';
//}
//
//function htmlFooter()
//{
//    echo '</article><br><nav><a href="index.html">Back to Overview</a></nav></body></html>';
//}

// create a client instance
$client = new Solarium\Client($adapter, $eventDispatcher, $config);

// get a select query instance
$query = $client->createQuery($client::QUERY_SELECT);

//// Pagination example
//$resultsPerPage = 15;
//$currentPage = 1;
//
//// Set the number of results to return
//$query->setRows($resultsPerPage);
//// Set the 0-based result to start from, taking into account pagination
//$query->setStart(($currentPage - 1) * $resultsPerPage);

// this executes the query and returns the result
$resultset = $client->execute($query);

echo "<pre>"; print_r($resultset); echo "</pre>";