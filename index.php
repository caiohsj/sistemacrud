<?php 

require_once("vendor/autoload.php");

use \Slim\Slim;

use Crud\BD\Conexao;
use Crud\Model\Lembrete;
use Crud\Page;

$app = new Slim();

$app->config("debug", true);

// Rota principal
$app->get("/", function(){
	$page = new Page(["header"=>false, "footer"=>false]);

	$page->setTpl("index");
});

//Rota para cadastrar
$app->get("/cadastro", function(){

	$page = new Page(["header"=>false, "footer"=>false]);

	$page->setTpl("cadastro");
});

// Rota para deslogar do sistema
$app->get("/sair", function(){
	echo "Saindo";
});

$app->run();
 ?>