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

	$page->setTpl("cadastro",[
		"erro"=>Usuario::getErro(),
		"registerValues"=>(isset($_SESSION["registerValues"])) ? $_SESSION["registerValues"] : ["name"=>"","email"=>"", "senha"=>""]
	]);
});

// Rota para cadastrar via post
$app->post("/cadastro", function(){
	$usuario = new Usuario();

	if($usuario->findByEmail($_POST["email"])){
		Usuario::setErro("Email inválido!");

		// Colocando na sessão os valores que o usuario digitou na hora do cadastro
		$_SESSION["registerValues"] = $_POST;

    	header("Location: /cadastro");
    	exit;
	}

	// Colocando no objeto os dados do usuario que será cadastrado, que veio via post
	$usuario->setNome($_POST["nome"]);
	$usuario->setEmail($_POST["email"]);
	$usuario->setSenha($_POST["senha"]);
	// Status 1, conta confirmada
	// Status 2, conta não confirmada
	$usuario->setStatus(1);

	// Inserindo usuário
	$usuario->add();

	// Deixando a sessão vazia
	$_SESSION["registerValues"] = ["nome"=>"", "email"=>"", "senha" => ""];

	//$_SESSION["registerValues"] = "";

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

	if (Usuario::verifyLogin() === false){
		header("Location: /");
		exit;
	}

	$lembrete = new Lembrete();

	$page = new Page();

	$page->setTpl("conta", [
		"lembretes"=>$lembrete->listByIdUsuario($_SESSION["idUsuario"])
	]);
});

//Rota para abrir o template que insere um lembrete
$app->get("/adicionar", function(){

	$page = new Page();

	$page->setTpl("adicionarLembrete");
});

//Rota para inserir um lembrete
$app->post("/adicionar", function(){

	if (Usuario::verifyLogin() === false){
		header("Location: /");
		exit;
	}

	$lembrete = new Lembrete();

	$lembrete->setDescricao($_POST["descricao"]);
	$lembrete->setFkUsuario($_SESSION["idUsuario"]);

	$lembrete->add();

	header("Location: /conta");
	exit;

});

// Rota para excluir um lembrete
$app->get("/lembrete/:id/excluir", function($id){
	if (Usuario::verifyLogin() === false){
		header("Location: /");
		exit;
	}

	$lembrete = new Lembrete();

	$lembrete->loadById($id);

	$lembrete->delete();

	header("Location: /conta");
	exit;
});

//Rota para abrir o template que edita um lembrete
$app->get("/lembrete/:id", function($id){

	if (Usuario::verifyLogin() === false){
		header("Location: /");
		exit;
	}

	$lembrete = new Lembrete();

	$page = new Page();

	$page->setTpl("atualizarLembrete",[
		"lembrete"=>$lembrete->listById($id)
	]);
});

//Rota para editar um lembrete
$app->post("/lembrete/:id", function($id){

	if (Usuario::verifyLogin() === false){
		header("Location: /");
		exit;
	}

	$lembrete = new Lembrete();

	$lembrete->setId($id);
	$lembrete->setDescricao($_POST["descricao"]);
	$lembrete->setFkUsuario($_SESSION["idUsuario"]);

	$lembrete->update();

	header("Location: /conta");
	exit;
});

// Rota para deslogar do sistema
$app->get("/sair", function(){
	Usuario::logout();

	header("Location: /");
	exit;
});

$app->run();
 ?>