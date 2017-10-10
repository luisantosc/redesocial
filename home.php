<?php
	//Conexão com BDD
	$usuario = "root";
	$senha = "";
	$servidor = "localhost";
	$bddnome = "cadastros";
	$conexao = mysqli_connect($servidor,$usuario,$senha,$bddnome);
	if(!$conexao){
		echo "Sem conexao";
	}
	
	//Criação de sessão
	session_start();
	if(isset($_SESSION['usuario'])){
		$id = $_SESSION['id'];
		$unome = $_SESSION['usuario'];
		$nome = mysqli_query ($conexao,"SELECT * FROM cadastro
				WHERE id = $id");
		$linha = mysqli_fetch_array($nome);
		$name=$linha["nome"];
		$sname = $linha["sobrenome"];
	}
	
	//Criação da pasta com as imagens de perfil e painel
	if($_SERVER['REQUEST_METHOD']=="POST"){
		$erro = false;
		if(!file_exists('usuarios/'.$unome)){
			mkdir('usuarios/'.$unome);	
		}
		if(isset($_FILES['perfil'])){
			$nome_perfil= $_FILES['perfil']['name'];
			$nome_perfil="perfil.jpg";
			copy($_FILES['perfil']['tmp_name'],'usuarios/'.$unome.'/'. $nome_perfil);
		}
		if(isset($_FILES['painel'])){
			$nome_painel= $_FILES['painel']['name'];
			$nome_painel="painel.jpg";
			copy($_FILES['painel']['tmp_name'],'usuarios/'.$unome.'/'. $nome_painel);
		}
				
	}
		
	//Verificando acesso a outros perfis
	if($_SERVER['REQUEST_METHOD']=="GET"){
		if(isset($_GET['user'])){
			$id = $_GET['user'];
			$nome = mysqli_query ($conexao,"SELECT * FROM cadastro
				WHERE id = $id");
			$linha = mysqli_fetch_array($nome);
			$unome = $linha["username"];
			$name = $linha["nome"];
			$sname = $linha["sobrenome"];
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
		<link href="https://fonts.googleapis.com/css?family=Germania+One|Poppins|Rye" rel="stylesheet">
		<link rel="stylesheet" href="./css/font-awesome.css"/>
		<link href="https://fonts.googleapis.com/css?family=Quicksand|Raleway" rel="stylesheet">
		<script src="./js/jquery.min.js"></script>
		<script>
			$(function(){
				$(".perfil").attr("src","./usuarios/<?php echo $unome?>/perfil.jpg");
				$(".painel").attr("src","./usuarios/<?php echo $unome?>/painel.jpg");
				$(".aparecer").click(function(){
					$(".fotos").css("display","block");
					$("body :not(.exc)").css("filter","blur(15px)");
				});
				$(".enviar").click(function(){
					$(".fotos").css("display","none");
					$("body :not(.exc)").css("filter","none");
				});
				$(".exibir_amigos").click(function(){
					$(".amigos").css("display","block");
					$(".solicitacao").css("display","none");
				});
				$(".exibir_solicitacoes").click(function(){
					$(".solicitacao").css("display","block");
					$(".amigos").css("display","none");
				});
				$(".add").click(function(){
					$(this).text("ENVIANDO");
				});
			})
		</script>
	</head>
	<body>
		<?php
		if(isset($_SESSION['usuario'])){
		?>
		<img src="./usuarios/<?php echo $unome?>/painel.jpg" class="painel"/>
		<a id="signout" href="signout.php">Sign Out</a>
		<div class="info">
			<img src="./usuarios/<?php echo $unome?>/perfil.jpg" class="perfil"/>
			<h1 class="nome"> <?php echo $name." ". $sname?></h1>
			<h4 class="nome"><?php echo $unome?></h4>
			<?php
			//Verificação se está no perfil logado
			if($id == $_SESSION['id']){
		?>
			<button class="exibir_solicitacoes"> Solicitações </button>
		
		<?php
			}
			else{
				$getId= $_GET['user'];
				$id_logado = $_SESSION['id'];
		?>	
			<a class="back" href="http://localhost/rede/home.php"> Voltar </a>
		<?php
			$selecao = mysqli_query ($conexao,"SELECT count(*) FROM amizade
		WHERE convite = $getId and convidado = $id_logado and status='amigo' or status='aguardo' or convite = $id_logado and convidado = $getId and status='amigo' or status='aguardo'");
				$linha = mysqli_fetch_array($selecao);
				if($linha["count(*)"]==0){

					
				
		?>
			<a class="add" href="adicionar.php?user=<?php echo $getId;?>"> Adicionar</a>
			
		<?php
				}
			}
		?>
		<button class="exibir_amigos"> Amigos </button>
		
		</div>
		<div class="amigos">
			<?php 
			//Vendo os amigos
			$selecao = mysqli_query ($conexao,"SELECT * FROM amizade
				WHERE convite = $id or convidado = $id and status='amigo'");
			?>
				<h3 class="titulo"> Amigos:</h3>
			<?php
				while($linha = mysqli_fetch_array($selecao)){
					if($id == $linha["convite"]){
						$convidado = $linha["convidado"];
						$descobrir =  mysqli_query ($conexao,"SELECT * FROM cadastro
						WHERE id = $convidado");
						$amigo = mysqli_fetch_array($descobrir);
					
				?>
					<div class="friend">
						<p  class="amigo_nome"><strong><?php echo $amigo["nome"]." ".$amigo["sobrenome"];?></strong></p>
						<p  class="amigo_nome"> <?php echo $amigo["username"];?></p>
						<a  href="http://localhost/rede/home.php?user=<?php echo $convidado ?>"><img src="./usuarios/<?php echo $amigo["username"]?>/painel.jpg" class="amigo_painel" id="<?php echo $convidado ?>"/></a>
						<a  href="http://localhost/rede/home.php?user=<?php echo $convidado ?>"><img src="./usuarios/<?php echo $amigo["username"]?>/perfil.jpg" class="amigo_perfil" id="<?php echo $convidado ?>"/></a>
					</div>
				<?php
					}
					else{
						$convite = $linha["convite"];
						$descobrir =  mysqli_query ($conexao,"SELECT * FROM cadastro
						WHERE id = $convite");
						$amigo = mysqli_fetch_array($descobrir);

					
					
				?>
					<div class="friend">
						<p  class="amigo_nome"><strong> <?php echo $amigo["nome"]." ".$amigo["sobrenome"];?></strong></p>
						<p class="amigo_nome"> <?php echo $amigo["username"];?></p>
						<a  href="http://localhost/rede/home.php?user=<?php echo $convite ?>"><img src="./usuarios/<?php echo $amigo["username"]?>/painel.jpg" class="amigo_painel" id="<?php echo $convite ?>"/></a>
						<a  href="http://localhost/rede/home.php?user=<?php echo $convite ?>"><img src="./usuarios/<?php echo $amigo["username"]?>/perfil.jpg" class="amigo_perfil" id="<?php echo $convite ?>"/></a>
					</div>	
				<?php
					}
					
				}
				?>
		</div>
		<div class="solicitacao">
		<?php 
			//Verificação se está no perfil logado
			if($id == $_SESSION['id']){
			//Vendo as solicitações de amizade
		?>
			<h3 class="titulo"> Solicitações:</h3>
		<?php
			$selecao = mysqli_query ($conexao,"SELECT * FROM amizade
				WHERE convidado = $id and status='aguardo'");
				while($linha = mysqli_fetch_array($selecao)){
					$convite = $linha["convite"];
					$descobrir =  mysqli_query ($conexao,"SELECT * FROM cadastro
					WHERE id = $convite");
					$amigo = mysqli_fetch_array($descobrir);
				?>
				<div class="friend">
					<p class="amigo_nome"><strong><?php echo $amigo["nome"]." ".$amigo["sobrenome"];?></strong></p>
					<p class="amigo_nome"><?php echo $amigo["username"];?></p>
					<a  href="http://localhost/rede/home.php?user=<?php echo $convite ?>"><img src="./usuarios/<?php echo $amigo["username"]?>/painel.jpg" class="amigo_painel" id="<?php echo $convite ?>"/></a>
					<a  href="http://localhost/rede/home.php?user=<?php echo $convite ?>"><img src="./usuarios/<?php echo $amigo["username"]?>/perfil.jpg" class="amigo_perfil" id="<?php echo $convite ?>"/></a>
					<a class="aceitar" href="http://localhost/rede/aceitar.php?user=<?php echo $amigo['id'] ?>"> Aceitar</a>
				</div>
				<?php
				}
				?>
		</div>
		<?php
			
		?>
			<button class="aparecer"> Trocar imagens </button>
			<form action="home.php" method="post" enctype="multipart/form-data" class="fotos exc">
				Escolha a foto de perfil<input name="perfil" type="file" value="Escolha a foto de perfil" class="exc"/><br>
				Escolha o painel<input name="painel" type="file" value="Escolha a foto de painel" class="exc"/><br>
				<input type="submit" class="enviar exc"/>
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
	
	</body>
</html>

