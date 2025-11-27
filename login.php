<?php
    //cabeçalho do site
    include 'includes/header.php';
?>
<!-- Section ocupa a tela vertical -->
<section class="vh-100">
    <div class="container py-5 h-100">
      <!-- Linha centralizada com os itens alinhados no meio -->
      <div class="row d-flex align-items-center justify-content-center h-100">

        <!-- Coluna da imagem do lado esquerdo -->
        <div class="col-md-6 mb-5">
          <!-- imagem de um gato -->
          <img src="assets/img/gato_login.png" 
               class="img-fluid" 
               alt="Phone image" 
               style="max-width: 65%; height: auto;">
        </div>

        <!-- Coluna do formulário de login -->
        <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
          <!-- formulário manda os dados pro PHP fazer o login -->
          <form action="crud\form_login.php" method="POST" 
                style="background-color: #f; border: 1px solid #00569d; border-radius: 15px; padding: 20px; margin: 10px;">
            
            <!-- Campo de email -->
            <div data-mdb-input-init class="form-outline mb-4">
              <strong class="form-label" for="form1Example13" style="color:#00569d">Email:</strong>
              <input name="email" type="email" id="form1Example13" class="form-control form-control-lg" />
            </div>

            <!-- Campo de senha -->
            <div data-mdb-input-init class="form-outline mb-4">
              <strong class="form-label" for="form1Example23" style="color:#00569d">Senha:</strong>
              <input name="senha" type="password" id="form1Example23" class="form-control form-control-lg" />
            </div>

            <!-- Opções embaixo dos campos -->
            <div class="d-flex justify-content-around align-items-center mb-4">
              <!-- Checkbox "Lembre-me" -->
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="form1Example3" checked />
                <label class="form-check-label" for="form1Example3">Lembre-me</label>
              </div>
              <!-- Link cadastro -->
              <a href="cadastro.php">Não tem uma conta?</a>
            </div>

            <!-- Botão de envio -->
            <button type="submit" data-mdb-button-init data-mdb-ripple-init 
                    class="btn btn-primary btn-lg w-100">
              Entrar
            </button>
          </form>
        </div>
      </div>
    </div>
</section>

<?php
    // Aqui eu fecho a página incluindo o rodapé (footer) do site
    include 'includes/footer.php';
?>
</body>
</html>
