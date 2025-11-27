<?php
    include 'includes/header.php';
?>
<section class="vh-100">
    <div class="container py-5 h-100">
      <div class="row d-flex align-items-center justify-content-center h-100">
        <div class="col-md-6 mb-5">
          <img src="assets/img/gato_login.png" class="img-fluid" alt="Phone image" style="max-width: 400px; height: auto;">
        </div>
        <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
          <form style="background-color: #a3ceef; border: 2px solid #00569d; border-radius: 15px; padding: 20px; margin: 10px;">
            <!-- Email input -->
            <div data-mdb-input-init class="form-outline mb-4">
              <strong class="form-label" for="form1Example13" style="color:#00569d">Email:</strong>
              <input type="email" id="form1Example13" class="form-control form-control-lg" />
            </div>

            <!-- Senha input -->
            <div data-mdb-input-init class="form-outline mb-4">
              <strong class="form-label" for="form1Example23" style="color:#00569d">Senha:</strong>
              <input type="password" id="form1Example23" class="form-control form-control-lg" />
            </div>

            <div class="d-flex justify-content-around align-items-center mb-4">
              <!-- Checkbox -->
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="form1Example3" checked />
                <label class="form-check-label" for="form1Example3"> Lembre-me</label>
              </div>
              <a href="#!">Esqueceu a senha?</a>
            </div>

            <!-- Submit button -->
            <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg btn-block">Entrar</button>
          </form>
        </div>
      </div>
    </div>
</section>
<?php
    include 'includes/footer.php';
?>
</body>
</html>
