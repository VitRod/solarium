The facet class supports the Solr pivot facet: <https://solr.apache.org/guide/faceting.html#pivot-decision-tree-faceting>.

Options
-------

The options below can be set as query option values, but also by using the set/get methods. See the API docs for all available methods.

| Name              | Type   | Default value | Description                                                                                      |
|-------------------|--------|---------------|--------------------------------------------------------------------------------------------------|
| fields            | string | null          | Fields to pivot on, separated by commas.                                                         |
| pivot.mincount    | int    | null          | Minimum number of documents that need to match in order for the facet to be included in results. |
| limit             | int    | null          | Limit the facet counts.                                                                          |
| offset            | int    | null          | Show facet count starting from this offset.                                                      |
| sort              | string | null          | Sort order (sorted by count or index). Use one of the class constants.                           |
| overrequest.count | int    | null          | Change the amount of over-requesting Solr does.                                                  |
| overrequest.ratio | float  | null          | Change the amount of over-requesting Solr does.                                                  |
||

Example
-------

```php
<?php

require_once(__DIR__.'/init.php');
htmlHeader();

// create a client instance
$client = new Solarium\Client($adapter, $eventDispatcher, $config);

// get a select query instance
$query = $client->createSelect();

// get the facetset component
$facetSet = $query->getFacetSet();

// create two facet pivot instances
$facet = $facetSet->createFacetPivot('cat-popularity-instock');
$facet->addFields('cat,popularity,inStock');
$facet->setMinCount(0);

$facet = $facetSet->createFacetPivot('popularity-cat');
$facet->addFields('popularity,cat');

// this executes the query and returns the result
$resultset = $client->select($query);

// display the total number of documents found by Solr
echo 'NumFound: '.$resultset->getNumFound();

// display facet results
$facetResult = $resultset->getFacetSet()->getFacet('cat-popularity-instock');
echo '<h3>cat &raquo; popularity &raquo; instock</h3>';
foreach ($facetResult as $pivot) {
    displayPivotFacet($pivot);
}

$facetResult = $resultset->getFacetSet()->getFacet('popularity-cat');
echo '<h3>popularity &raquo; cat</h3>';
foreach ($facetResult as $pivot) {
    displayPivotFacet($pivot);
}

htmlFooter();


/**
 * Recursively render pivot facets
 *
 * @param $pivot
 */
function displayPivotFacet($pivot)
{
    echo '<ul>';
    echo '<li>Field: '.$pivot->getField().'</li>';
    echo '<li>Value: '.$pivot->getValue().'</li>';
    echo '<li>Count: '.$pivot->getCount().'</li>';
    foreach ($pivot->getPivot() as $nextPivot) {
        displayPivotFacet($nextPivot);
    }
    echo '</ul>';
}

```
