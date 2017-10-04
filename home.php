<?php
	session_start();
	if(isset($_SESSION['usuario'])){
		$id = $_SESSION['id'];
		$unome = $_SESSION['usuario'];
	}
	
	$usuario = "root";
	$senha = "";
	$servidor = "localhost";
	$bddnome = "cadastros";
	$conexao = mysqli_connect($servidor,$usuario,$senha,$bddnome);
	if(!$conexao){
		echo "Sem conexao";
	}
	function aceitar(){
		$modificar = mysqli_query ($conexao,"UPDATE amizade
			SET status = 'amigo'
			WHERE convite = $id");
			
	}
	
	if($_SERVER['REQUEST_METHOD']=="POST"){
		$erro = false;
		$nome_perfil= $_FILES['perfil']['name'];
		$nome_painel= $_FILES['painel']['name'];
		if(!file_exists('usuarios/'.$unome)){
			mkdir('usuarios/'.$unome);	
		}
		$nome_perfil="perfil.jpg";
		$nome_painel="painel.jpg";
		copy($_FILES['perfil']['tmp_name'],'usuarios/'.$unome.'/'. $nome_perfil);
		copy($_FILES['painel']['tmp_name'],'usuarios/'.$unome.'/'. $nome_painel);
				
		}
	if($_SERVER['REQUEST_METHOD']=="GET"){
		if(isset($_GET['user'])){
			$id = $_GET['user'];
			$nome = mysqli_query ($conexao,"SELECT username FROM cadastro
				WHERE id = $id");
			$linha = mysqli_fetch_array($nome);
			$unome = $linha["username"];
		}
	}else{
		$id = $_SESSION['id'];
		$unome = $_SESSION['usuario'];
	}
		
	?>

<!doctype html>  
<html>
	<head>
		<meta charset="utf-8"/>	
		<link rel="stylesheet" href="./css/style.css"/>
		<link rel="stylesheet" href="./css/font-awesome.css"/>
		<link href="https://fonts.googleapis.com/css?family=Quicksand|Raleway" rel="stylesheet">
		<script src="./js/jquery.min.js"></script>
	</head>
	<body>
		<?php
		if(isset($_SESSION['usuario'])){
		?>
		<!--<img src="./usuarios/<?php echo $unome?>/perfil.jpg" class="perfil"/>
		<img src="./usuarios/<?php echo $unome?>/painel.jpg" class="painel"/>-->
		<h1> <?php echo $unome?></h1>
		<div class="solicitacao">
		<?php 
			if($id == $_SESSION['id']){
			$selecao = mysqli_query ($conexao,"SELECT * FROM amizade
				WHERE convidado = $id and status='aguardo'");
				while($linha = mysqli_fetch_array($selecao)){
					$convite = $linha["convite"];
					$descobrir =  mysqli_query ($conexao,"SELECT username FROM cadastro
					WHERE id = $convite");
					$amigo = mysqli_fetch_array($descobrir);
				?>
				<a  href="http://localhost/rede/home.php?user=<?php echo $convite ?>"><img src="./usuarios/<?php echo $amigo["username"]?>/perfil.jpg" class="solicitacao" id="<?php echo $convite ?>"/></a>
				<a href="http://localhost/rede/aceitar.php?id=<?php echo $convite ?>"> Aceitar</a>
				<?php
				}
				?>
		</div>
		<div class="amigos">
			<?php 
			$selecao = mysqli_query ($conexao,"SELECT * FROM amizade
				WHERE status='confirmado'");
				while($linha = mysqli_fetch_array($selecao)){
					
				?>
				
				<?php
				}
				?>
		</div>
		<?php
			
		?>
			<form action="home.php" method="post" enctype="multipart/form-data">
				Escolha a foto de perfil<input name="perfil" type="file" value="Escolha a foto de perfil"/><br>
				Escolha o painel<input name="painel" type="file" value="Escolha a foto de painel"/><br>
				<input type="submit"/>
			</form>
		<?php
			}
		}
		else{
		?>
			<p> Você ainda não está cadastrado </p>
			<a href="login.php"> Fazer login </a>
		<?php
		}
		?>
	
	<a id="signout" href="signout.php">Sign Out</a>
	</body>
</html>

