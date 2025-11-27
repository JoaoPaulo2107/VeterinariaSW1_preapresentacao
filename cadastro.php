<?php
include 'includes/header.php';
?>
<section class="d-flex align-items-center"
  style="background-color: #f8f9fa; padding-top: 100px; padding-bottom: 100px; min-height: 100vh;">
  <div class="container py-5">
    <div class="row align-items-center justify-content-center">

      <!-- Coluna do formulário (à esquerda) -->
      <div class="col-md-6 col-lg-5">
        <form action="crud\form_cadastrar.php" method="POST" style="background-color: #fff; border: 1px solid #00569d; border-radius: 15px; padding: 30px;">

          <!-- Nome -->
          <div class="form-outline mb-3">
            <strong class="form-label"  for="nome" style="color:#00569d">Nome:</strong>
            <input type="text" id="nome" name="nome" class="form-control form-control-lg" placeholder="Digite seu nome" />
          </div>

          <!-- Telefone -->
          <div class="form-outline mb-3">
            <strong class="form-label"  for="telefone" style="color:#00569d">Telefone:</strong>
            <input type="tel" id="telefone" name="telefone" class="form-control form-control-lg" placeholder="(xx) xxxxx-xxxx" />
          </div>

          <!-- CPF -->
          <div class="form-outline mb-3">
            <strong class="form-label"  for="cpf" style="color:#00569d">CPF:</strong>
            <input type="text" id="cpf" name="cpf" class="form-control form-control-lg" placeholder="000.000.000-00" />
          </div>

          <!-- Email -->
          <div class="form-outline mb-3">
            <strong class="form-label" for="email" style="color:#00569d">Email:</strong>
            <input type="email" id="email" name="email" class="form-control form-control-lg" placeholder="seuemail@exemplo.com" />
          </div>

          <!-- Senha -->
          <div class="form-outline mb-4">
            <strong class="form-label" for="senha" style="color:#00569d">Senha:</strong>
            <input type="password" id="senha" name="senha" class="form-control form-control-lg" placeholder="********" />
          </div>

          <!-- Link de login -->
          <div class="text-center mb-4">
            <a href="login.php">Já tem uma conta?</a>
          </div>

          <!-- Botão de envio -->
          <!-- <a href="dashboard_adm.php" type="submit" class="btn btn-primary btn-lg w-100">Cadastrar</a> -->
          <button type="submit" class="btn btn-primary btn-lg w-100">Cadastrar</button>
        </form>
      </div>

    </div>
  </div>
</section>
<?php
include 'includes/footer.php';
?>

<script>
  // Máscara do telefone
  const telInput = document.getElementById('telefone');
  telInput.addEventListener('input', function () {
    let valor = this.value.replace(/\D/g, ''); // remove tudo que não é número
    valor = valor.substring(0, 11); // limita a 11 dígitos

    if (valor.length > 6) {
      this.value = `(${valor.substring(0,2)}) ${valor.substring(2,7)}-${valor.substring(7,11)}`;
    } else if (valor.length > 2) {
      this.value = `(${valor.substring(0,2)}) ${valor.substring(2,7)}`;
    } else {
      this.value = valor;
    }
  });

  // Máscara do CPF
  const cpfInput = document.getElementById('cpf');
  cpfInput.addEventListener('input', function () {
    let valor = this.value.replace(/\D/g, ''); // só números
    valor = valor.substring(0, 11); // máximo 11

    if (valor.length > 9) {
      this.value = `${valor.substring(0,3)}.${valor.substring(3,6)}.${valor.substring(6,9)}-${valor.substring(9,11)}`;
    } else if (valor.length > 6) {
      this.value = `${valor.substring(0,3)}.${valor.substring(3,6)}.${valor.substring(6,9)}`;
    } else if (valor.length > 3) {
      this.value = `${valor.substring(0,3)}.${valor.substring(3,6)}`;
    } else {
      this.value = valor;
    }
  });
</script>  
</body>