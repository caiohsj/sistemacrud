<?php 

require_once("vendor/autoload.php");

use \Slim\Slim;
use Crud\BD\Conexao;
use Crud\Model\Lembrete;
use Crud\Model\Usuario;
use Crud\Page;

$app = new Slim();

$app->config("debug", true);

// Rota principal
$app->get("/", function(){
	$page = new Page(["header"=>false, "footer"=>false]);

	$page->setTpl("index");
});

//Rota para abrir o template de cadastro
$app->get("/cadastro", function(){

	$page = new Page(["header"=>false, "footer"=>false]);

	$page->setTpl("cadastro");
});

// Rota para cadastrar via post
$app->post("/cadastro", function(){
	$usuario = new Usuario();


	// Colocando no objeto os dados do usuario que será cadastrado, que veio via post
	$usuario->setNome($_POST["nome"]);
	$usuario->setEmail($_POST["email"]);
	$usuario->setSenha($_POST["senha"]);
	// Status 1, conta confirmada
	// Status 2, conta não confirmada
	$usuario->setStatus(1);

	// Inserindo usuário
	$usuario->add();

	//Redirecionando para página principal
	header("Location: /");
	exit;
});

// Rota para deslogar do sistema
$app->get("/sair", function(){
	echo "Saindo";
});

$app->run();
 ?>