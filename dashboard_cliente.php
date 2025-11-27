<?php
    include 'includes/header_cliente.php';     
    session_start();
    include 'includes/conexao.php';


// Verifica se usuário está logado
if (!isset($_SESSION['usuario_id'], $_SESSION['usuario_email'])) {
    // não logado
    header('Location: index.php'); // ajuste caminho para sua página de login
    exit;
}

// opcional: usuario logado. Pode usar $_SESSION['usuario_nome'] etc.
?>   
    


<!-- Cabeçalho com imagem e frase de impacto -->
<header class="masthead">
    <div class="container px-5">
        <div class="row gx-5 align-items-center">
            <div class="col-lg-6">
                <div class="mb-5 mb-lg-0 text-center text-lg-start">
                    <h1 class="display-1 lh-1 mb-3">
                        Bem-vinda, <?= htmlspecialchars($_SESSION['usuario_nome']) ?>!
                    </h1>
                    <p class="lead fw-normal text-muted mb-5">
                        Agora você está logado. Confira todas as novidades e produtos disponíveis.
                    </p>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="assets/img/loginpet.png" alt="Imagem de animais de estimação" class="img-fluid">
            </div>
        </div>
    </div>
</header>
<main>
    <section class="py-5">
        <div class="container px-5">
            <div class="row gx-5">
                <div class="col-12">
                    <h2 class="display-6 mb-4">Minhas Consultas</h2>
        <div class="table-responsive">
                <table class="table table-striped table-hover"
              style="border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,255,0.1); overflow: hidden;">
              <thead class="table" style="background-color: blue;">
                <tr>
                  <th style="color:#fff;">Data</th>
                  <th style="color:#fff;">Horário</th>
                  <th style="color:#fff;">Procedimento</th>
                  <th style="color:#fff;">Pet</th>
                  <th style="color:#fff;">Status</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $idUsuario = $_SESSION['usuario_id'];

                $sql = "
                  SELECT 
                    c.ID_consulta,
                    c.Data_consulta AS data,
                    c.Horario,
                    c.Procedimento,
                    c.Status,
                    a.Nome AS nome_pet,
                    c.motivo_cancelamento
                  FROM Consulta c
                  INNER JOIN Animal a ON a.ID_Animal = c.ID_Animal
                  WHERE a.idDono_animal = :id
                  ORDER BY c.Data_consulta DESC
                ";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':id' => $idUsuario]);
                $consultas = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (empty($consultas)) {
                    echo '<tr><td colspan="5" class="text-center text-muted">Nenhuma consulta encontrada.</td></tr>';
                } else {
                    foreach ($consultas as $row) {
                        echo '<tr>';
                        echo '<td>' . date("d/m/Y", strtotime($row["data"])) . '</td>';
                        echo '<td>' . htmlspecialchars($row["Horario"]) . '</td>';
                        echo '<td>' . htmlspecialchars($row["Procedimento"]) . '</td>';
                        echo '<td>' . htmlspecialchars($row["nome_pet"]) . '</td>';
                        $status = empty($row["motivo_cancelamento"]) ? htmlspecialchars($row["Status"]) : "Cancelada";
                        echo '<td>' . $status . '</td>';
                        echo '</tr>';
                    }
                }
                ?>
              </tbody>
            </table>
        </div>

                    <!-- Botão centralizado para ir ao modal e remarcar a consulta -->
                    <div class="text-center mt-4">
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#consultaModal">
                            Remarcar ou Cancelar Consulta
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal para Cancelar/Reagendar Consulta -->
        <div class="modal fade" id="consultaModal" tabindex="-1" aria-labelledby="consultaModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: blue;">
                        <h5 class="modal-title" id="consultaModalLabel" style="color: white;">Gerenciar Consulta</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Informações da Consulta, aqui seria as consultas que ainda vão acontecer do cliente -->
                        <div class="mb-4">
                            <div class="mb-3">
                                <select class="form-control" name="infoconsultas" id="consultaSelecionada" required>
                                    <option value="" disabled selected>Selecione a consulta</option>

                                    <?php
                                    $sqlConsultasModal = "
                                        SELECT 
                                            c.ID_consulta,
                                            c.Data_consulta,
                                            c.Horario
                                        FROM Consulta c
                                        INNER JOIN Animal a ON a.ID_Animal = c.ID_Animal
                                        WHERE a.idDono_animal = :id
                                        AND c.Status = 'agendada'
                                        ORDER BY c.Data_consulta ASC
                                    ";

                                    $stmtModal = $pdo->prepare($sqlConsultasModal);
                                    $stmtModal->execute([':id' => $idUsuario]);
                                    $consultasModal = $stmtModal->fetchAll(PDO::FETCH_ASSOC);

                                    foreach ($consultasModal as $c) {
                                        echo '<option value="' . $c["ID_consulta"] . '">';
                                        echo "Dia " . date("d/m/Y", strtotime($c["Data_consulta"])) . " às " . $c["Horario"];
                                        echo '</option>';
                                    }
                                    ?>
                                </select>

                            </div>

                        </div>

                        <!-- h5 com opções para serem escolhidas -->
                        <div class="border-top pt-4">
                            <h5 class="fw-bold mb-3">Selecione a opção desejada:</h5>

                            <!-- Reagendar Consulta -->
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h6 class="card-title">Reagendar Consulta</h6>
                                        <form action="reagendar_consulta.php" method="POST" class="mt-3">

                                            <!-- CAMPO IMPORTANTE!!! -->
                                             <input type="hidden" name="id_consulta" id="idConsultaReagendar">

                                            <div class="row">

                                            <div class="col-md-6 mb-3">
                                                <!-- input de data para poder agendar uma nova -->
                                                <label for="novaData" class="form-label">Nova Data</label>
                                                <input type="date" class="form-control" id="novaData" name="nova_data"
                                                    required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="novoHorario" class="form-label">Novo Horário</label>
                                                <select class="form-control" id="novoHorario" name="novo_horario"
                                                    required>
                                                    <option value="" disabled selected>Selecione o horário</option>
                                                    <option value="08:00">08:00</option>
                                                    <option value="09:00">09:00</option>
                                                    <option value="10:00">10:00</option>
                                                    <option value="11:00">11:00</option>
                                                    <option value="14:00">14:00</option>
                                                    <option value="15:00">15:00</option>
                                                    <option value="16:00">16:00</option>
                                                    <option value="17:00">17:00</option>
                                                </select>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-warning">Confirmar Reagendamento</button>
                                    </form>
                                </div>
                            </div>

                          <!-- Opção 2: Cancelar Consulta -->
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title text-danger">Cancelar Consulta</h6>

                                    <form action="cancelar_consulta.php" method="POST" class="mt-3">

                                        <!-- ⬇⬇⬇ ESTE É O CAMPO QUE FALTAVA ⬇⬇⬇ -->
                                        <input type="hidden" name="id_consulta" id="idConsultaCancelar">

                                        <div class="mb-3">
                                            <label for="motivoCancelar" class="form-label">Motivo do Cancelamento</label>
                                            <textarea class="form-control" id="motivoCancelar" name="motivo" rows="2"
                                                placeholder="Informe o motivo..." required></textarea>
                                        </div>

                                        <button type="submit" class="btn btn-danger">Confirmar Cancelamento</button>

                                    </form>

                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            style="background-color: blue;">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.getElementById("consultaSelecionada").addEventListener("change", function() {
                let id = this.value;

                document.getElementById("idConsultaReagendar").value = id;
                document.getElementById("idConsultaCancelar").value = id;
            });
</script>

    </section>
</main>
<?php
include 'includes/footer.php';
?>