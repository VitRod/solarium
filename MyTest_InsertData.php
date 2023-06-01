<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MyTest_InsertData</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>

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

if ($_POST) {
    // if data is posted add it to Solr

    // create a client instance
    $client = new Solarium\Client($adapter, $eventDispatcher, $config);

    // get an update query instance
    $update = $client->createUpdate();

    // create a new document for the data
    // please note that any type of validation is missing in this example to keep it simple!
    $doc = $update->createDocument();
    $doc->id = $_POST['id'];
    $doc->name = $_POST['name'];
    $doc->price = $_POST['price'];

    // add the document and a commit command to the update query
    $update->addDocument($doc);
    $update->addCommit();

    // this executes the query and returns the result
    $result = $client->update($update);

    echo '<b>Update query executed</b><br/>';
    echo 'Query status: ' . $result->getStatus(). '<br/>';
    echo 'Query time: ' . $result->getQueryTime();

} else {
    // if no data is posted show a form
    ?>



<!--    <form method="POST">-->
<!--        Id: <input type="text" name="id"/> <br/>-->
<!--        Name: <input type="text" name="name"/> <br/>-->
<!--        Price: <input type="text" name="price"/> <br/>-->
<!--        <input type="submit" value="Add"/>-->
<!--    </form>-->

    <!-- write a form to insert data into the techproducts core of solr with id, name, price
    // and button submit to add the data to the core
    // using bootstrap 5.0.2 -->

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <form method="POST">
                    <div class="mb-3">
                        <label for="id" class="form-label">Id</label>
                        <input type="text" class="form-control" id="id" name="id" aria-describedby="id">
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" aria-describedby="name">
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="text" class="form-control" id="price" name="price" aria-describedby="price">
                    </div>
                    <button type="submit" class="btn btn-primary">Add</button>
                </form>
            </div>
        </div>



    <?php
}

?>


</body>
</html>