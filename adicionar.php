<?php
	session_start();
	//Conexão com BDD
	$usuario = "root";
	$senha = "";
	$servidor = "localhost";
	$bddnome = "cadastros";
	$conexao = mysqli_connect($servidor,$usuario,$senha,$bddnome);
	if(!$conexao){
		echo "Sem conexao";
	}
	
	$id = $_SESSION['id'];
	$add = $_GET['user'];
	echo $id ." ".$add;
	
	$selecao = mysqli_query ($conexao,"INSERT INTO amizade(convite,convidado,status)
		VALUES
		($id,$add,'aguardo')");
	header("Location: home.php?user=$add");
?>