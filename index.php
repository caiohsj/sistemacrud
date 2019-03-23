<?php 
session_start();
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

	$page->setTpl("index",[
		"erro"=>Usuario::getErro()
	]);
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

//Rota para login
$app->post("/login", function(){
	$usuario = new Usuario();

	if($usuario->findByEmail($_POST["email"]) === false){
		Usuario::setErro("Email ou senha inválidos!");
    	header("Location: /");
    	exit;
	}

	if ($usuario->login($_POST["email"], $_POST["senha"])) {
		header("Location: /conta");
		exit;
	} else {
		Usuario::setErro("Email ou senha inválidos!");
		header("Location: /");
		exit;
	}
});

// Rota para abrir a página da conta do usuário, onde está listado os seus lembretes
$app->get("/conta", function(){
	$usuario = new Usuario();

	if ($usuario->verifyLogin() === false){
		header("Location: /");
		exit;
	}

	$page = new Page();

	$page->setTpl("conta");
});

// Rota para deslogar do sistema
$app->get("/sair", function(){
	Usuario::logout();

	header("Location: /");
	exit;
});

$app->run();
 ?>