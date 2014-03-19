<?php
    require '../vendor/slim/slim/Slim/Slim.php';
    \Slim\Slim::registerAutoloader();
    $app = new \Slim\Slim();
    $app->response()->header('Content-Type','application/json;charset=utf-8');
    $app->get('/',function(){
       echo "SlimProdutos";
    });
    
    $app->get('/categorias','getCategorias');
    $app->post('/produtos','addProduto');
    
    $app->run();
    
    function getConn(){
        return new PDO('mysql:host=localhost;dbname=SlimProdutos','root','root',array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

}

function getCategorias(){
    $stmt = getConn()->query("SELECT * FROM Categorias");
    $categorias = $stmt->fetchAll(PDO::FETCH_OBJ);
    echo "{categorias:".json_encode($categorias)."}";
}

function addProduto(){
    $request = \Slim\Slim::getInstance()->request();
    $produto = json_decode($request->getBody());
    $sql = "INSERT INTO produtos (nome,preco,dataInclusao,idCategoria) values (:nome,:preco,:dataInclusao,:idCategoria) ";
    $conn = getConn();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam("nome",$produto->nome);
    $stmt->bindParam("preco",$produto->preco);
    $stmt->bindParam("dataInclusao",$produto->dataInclusao);
    $stmt->bindParam("idCategoria",$produto->idCategoria);
    $stmt->execute();
    $produto->id = $conn->lastInsertId();
    echo json_encode($produto);
}