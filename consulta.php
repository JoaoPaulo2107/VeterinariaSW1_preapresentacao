<?php
include 'includes/header_cliente.php';
session_start();

// Verifica se usuário está logado
if (!isset($_SESSION['usuario_id'], $_SESSION['usuario_email'])) {
    // não logado
    header('Location: index.php'); // ajuste caminho para sua página de login
    exit;
}

// opcional: usuario logado. Pode usar $_SESSION['usuario_nome'] etc.
?>

<body>
    <main>
            <div class="container_consulta">
                <h1>Marque a Consulta do seu Pet</h1>
                <form action="/VETERINARIASW1/crud/inserir_consulta.php" method="POST">



                    <!-- Escolha do Pet (Pegar os Cadastrados, as informações abaixo estão desabilitadas pois serão preenchidas quando o pet for selecionado)-->
                    <div class="mb-3">
                        <?php 
                        include 'includes/conexao.php';
                        $usuario_id = $_SESSION['usuario_id'];

                        $sqlPets = "SELECT * FROM animal WHERE idDono_animal = :id";
                        $stmtPets = $pdo->prepare($sqlPets);
                        $stmtPets->execute([':id' => $usuario_id]);
                        $pets = $stmtPets->fetchAll(PDO::FETCH_ASSOC);
                        ?>

                        <div class="mb-3">
                            <select class="form-control" id="petSelect" name="ID_Animal" required>
                                <option value="" disabled selected>Selecione o Pet</option>

                                <?php foreach ($pets as $p): ?>
                                    <option 
                                        value="<?= $p['ID_Animal'] ?>"
                                        data-especie="<?= $p['Especie'] ?>"
                                        data-raca="<?= $p['Raca'] ?>"
                                        data-idade="<?= $p['Idade'] ?>"
                                        data-peso="<?= $p['Peso'] ?>"
                                        data-sexo="<?= $p['Sexo'] ?>"
                                    >
                                        <?= htmlspecialchars($p['Nome']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
    
                    <!-- Espécie -->
                    <div class="mb-3">
                        <input type="text" class="form-control" id="especie" placeholder="Espécie" disabled>
                    </div>

                    <!-- Raça -->
                    <div class="mb-3">
                        <input type="text" class="form-control" id="raca" placeholder="Raça" disabled>
                    </div>

                    <!-- Idade -->
                    <div class="mb-3">
                        <input type="text" class="form-control" id="idade" placeholder="Idade" disabled>
                    </div>

                    <!-- Peso -->
                    <div class="mb-3">
                        <input type="text" class="form-control" id="peso" placeholder="Peso" disabled>
                    </div>

                    <!-- Sexo -->
                    <div class="mb-3">
                        <input type="text" class="form-control" id="sexo" placeholder="Sexo" disabled>
                    </div>
                    <!-- Procedimento -->
                    <div class="mb-3">
                        <select class="form-control" name="procedimento" required>
                            <option value="" disabled selected>Selecione o procedimento</option>
                            <option value="Vacinação">Vacinação</option>
                            <option value="Consulta geral">Consulta geral</option>
                            <option value="Tosse ou resfriado">Tosse ou resfriado</option>
                            <option value="Retorno">Retorno</option>
                            <option value="Banho">Banho e Tosa</option>
                            <option value="Exame">Exame</option>
                            <option value="Outro">Outro</option>
                        </select>
                    </div>

                    <!-- Data -->
                    <div class="mb-3">
                        <input type="date" class="form-control" name="data" required>
                    </div>

                    <!-- Horário -->
                    <div class="mb-3">
                        <select class="form-control" name="horario" required>
                            <option value="" disabled selected>Selecione o horário</option>
                            <option value="09:00">09:00</option>
                            <option value="10:00">10:00</option>
                            <option value="11:00">11:00</option>
                            <option value="13:00">12:00</option>
                            <option value="14:00">14:00</option>
                            <option value="15:00">15:00</option>
                            <option value="16:00">16:00</option>
                            <option value="17:00">17:00</option>
                            <option value="18:00">18:00</option>
                        </select>
                    </div>

                    <!-- Campo Opcional -->
                    <div class="mb-3">
                        <input type="text" class="form-control" name="observacao"
                            placeholder="Observação (campo não obrigatório)">
                    </div>

                    <!-- Botões -->
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                    <a href="dashboard_cliente.php" type="button" class="btn btn-warning">Voltar</a>
                </form>
            </div>
    </main>
    <script>
    document.getElementById("petSelect").addEventListener("change", function() {
        let option = this.selectedOptions[0];

        document.getElementById("especie").value = option.dataset.especie;
        document.getElementById("raca").value = option.dataset.raca;
        document.getElementById("idade").value = option.dataset.idade;
        document.getElementById("peso").value = option.dataset.peso;
        document.getElementById("sexo").value = option.dataset.sexo;
    });
    </script>

<?php
 include 'includes/footer.php';
?>
