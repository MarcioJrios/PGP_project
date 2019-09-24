    <div>
      <h2>Acesso</h2>
    </div>
  	<form action="includes/verificacao_login.php" method="POST">	<!--manda os dados para o arquivo verificacao.php via POST-->
  		<div class="campo-login">
        <input type="text" name="email" placeholder="Email"><br>		<!--o nome das variaveis enviadas são definidas pelo 'name' no <input> -->
      </div>
      <div class="campo-login">
  		  <input type="password" name="senha" placeholder="Senha"><br>
      </div>
      <div style="color: red; margin-left: 0px;">	<!--recebe o valor da variavel 'erro' da pagina verificacao.php via redirecionamento -->
        <?php
        if(isset($_GET['erro'])){
          if ($_GET['erro'] == 4) {
            echo "O campo Email não pode ser vazio";
          }else if($_GET['erro'] == 5){
            echo "O campo Senha não pode ser vazio";
          }else if($_GET['erro'] == 3){
          	echo "Formato de Email inválido";
          }else{
            echo "Dados incorretos";
          }
        }
        ?>
      </div>
      <div>
        <a href="#">Esqueceu a sua senha?</a>
      </div>
      <div>
        <input type="checkbox" name="">
        <label>Permanecer conectado</label>
      </div>
      <div class="campo-login">
  		  <input type="submit" value="Login">
        <a style="text-decoration:none;" href="#"><input type="button" value="Cadastrar-se"></a>
      </div>
  	</form>
    
