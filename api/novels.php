<?php

//Get all list novels
$app->get('/novels', function(){
    $db = new PDO('sqlite:../testdb.db');

    $query = "select * from novel"; //query
    //prepare a statement for execution and return object
    $fetch = $db->prepare($query);
    $fetch->execute();
    //PDO:FETCH_CLASS will set the key from database, using data after the constructor
    //if without it, Data is populated before the constructor is called and 
    //the key in table will be set "0","1",...
    $result = $fetch->fetchAll(PDO::FETCH_CLASS);
    $db = null;
    if(isset($result)) {
        header('Content-type: application/json');
        echo json_encode($result);
    }
});

//GET A SINGLE NOVEL
$app->get('/novels/{id}', function($request, $response){
    $db = new PDO('sqlite:../testdb.db');

    $id = $request->getAttribute('id'); // get Id from URL

    $query = "select * from novel where id = $id"; //query
    $fetch = $db->prepare($query);
    $fetch->execute();
    $result = $fetch->fetchAll(PDO::FETCH_CLASS);
    $db = null;
    if(isset($result)) {
        header('Content-type: application/json');
        echo json_encode($result);
    }
});

//ADD A NOVEL
$app->post('/novels/add', function($request, $response){
        
        $id = $request->getParam('id');
        $nameNovel = $request->getParam('nameNovel');
        $authorNovel = $request->getParam('authorNovel');
        $query = "INSERT INTO novel VALUES(:id,:nameNovel,:authorNovel)";  //query 
    try {
        $db = new PDO('sqlite:../testdb.db');
        
        $fetch = $db->prepare($query);
        //bindParam to column in db
        $fetch->bindParam(':id', $id);
        $fetch->bindParam(':nameNovel', $nameNovel);
        $fetch->bindParam(':authorNovel', $authorNovel);
        $fetch->execute();  
        echo '{"notice": {"text": "Novel is added"}';
    } 
    catch(PDOException $ex) {
        echo '{"error": {"text": '.$ex->getMessage().'}';
    }

});

//UPDATE A NOVEL
$app->put('/novels/update/{id}', function($request, $response){
    $id = $request->getAttribute('id');
    $nameNovel = $request->getParam('nameNovel');
    $authorNovel = $request->getParam('authorNovel');
   
    $query = "UPDATE novel SET
                    nameNovel = :nameNovel ,
                    authorNovel = :authorNovel
                WHERE id = $id "; //query
    try {
        $db = new PDO('sqlite:../testdb.db');
        $fetch = $db->prepare($query);

        $fetch->bindParam(':nameNovel', $nameNovel);
        $fetch->bindParam(':authorNovel', $authorNovel);
        $fetch->execute();
        echo '{"notice": {"text": "Novel is updated"}';
    }
    catch(PDOException $ex) {
        echo '{"error": {"text": '.$ex->getMessage().'}';
    }
    

});


//DELETE A NOVEL
$app->delete('/novels/delete/{id}', function($request, $response){
    $id = $request->getAttribute('id');
    try {
        $db = new PDO('sqlite:../testdb.db');
        $query = "DELETE FROM novel WHERE id = $id";
        $fetch = $db->prepare($query);
        $fetch->execute();
        echo '{"notice": {"text": "Novel is deleted"}';
    }
    catch(PDOException $ex) {
        echo '{"error": {"text": '.$ex->getMessage().'}';
    }

});