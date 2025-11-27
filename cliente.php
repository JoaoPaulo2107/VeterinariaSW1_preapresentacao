<?php
session_start();
require_once __DIR__ . '/includes/conexao.php';

// Verifica login
if (!isset($_SESSION['usuario_id'], $_SESSION['usuario_email'])) {
    header('Location: ../index.php');
    exit;
}

include 'includes/header_adm.php';

// Se o ADM não escolheu data, usa a atual
$dataSelecionada = $_GET['data'] ?? date('Y-m-d');

// Buscar TODAS as consultas na data selecionada
$sql = "
    SELECT 
        c.ID_consulta,
        c.Data_consulta,
        c.Procedimento,
        c.Horario,
        c.Observacao,
        c.Status,

        a.Nome AS animal_nome,
        a.Raca,
        a.Especie,
        a.Idade,
        a.Peso,
        a.Sexo,

        d.Nome AS dono_nome,
        d.Email,
        d.Telefone
    FROM consulta c
    JOIN animal a ON a.ID_Animal = c.ID_Animal
    JOIN dono_animal d ON a.idDono_animal = d.ID_Dono_animal
    WHERE DATE(c.Data_consulta) = :data
    ORDER BY c.Horario ASC
";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':data', $dataSelecionada);
$stmt->execute();
$consultas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="container py-5">
    <h1 class="mb-4 text-center">Consultas do Dia</h1>

    <!-- Formulário para escolher a data -->
    <form method="GET" class="mb-4">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <label class="form-label fw-bold">Selecione o dia:</label>
                <input type="date" name="data" class="form-control" value="<?= htmlspecialchars($dataSelecionada) ?>" required>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button class="btn btn-primary w-100">Buscar</button>
            </div>
        </div>
    </form>

    <?php if (count($consultas) > 0): ?>
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    Consultas para <?= date('d/m/Y', strtotime($dataSelecionada)) ?> — <?= count($consultas) ?> encontrada(s)
                </h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Dono</th>
                            <th>Animal</th>
                            <th>Espécie</th>
                            <th>Procedimento</th>
                            <th>Hora</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($consultas as $c): ?>
                            <tr>
                                <td><?= $c['ID_consulta'] ?></td>
                                <td><?= htmlspecialchars($c['dono_nome']) ?></td>
                                <td><?= htmlspecialchars($c['animal_nome']) ?></td>
                                <td><?= htmlspecialchars($c['Especie']) ?></td>
                                <td><?= htmlspecialchars($c['Procedimento']) ?></td>
                                <td><?= htmlspecialchars($c['Horario']) ?></td>
                                <td>
                                    <?php
                                    $status = ucfirst(strtolower(trim($c['Status'])));
                                    $badgeClass = match ($status) {
                                        'Aceita' => 'bg-success',
                                        'Cancelada' => 'bg-danger',
                                        'Pendente' => 'bg-warning text-dark',
                                        default => 'bg-secondary'
                                    };
                                    ?>
                                    <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($status) ?></span>
                                </td>
                                <td>
                                    <button class="btn btn-warning btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalConsulta"
                                        data-id="<?= $c['ID_consulta'] ?>"
                                        data-horario="<?= $c['Horario'] ?>"
                                        data-data="<?= $c['Data_consulta'] ?>"
                                        data-dono="<?= htmlspecialchars($c['dono_nome']) ?>"
                                        data-animal="<?= htmlspecialchars($c['animal_nome']) ?>">
                                        Gerenciar
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center mt-4">
            Nenhuma consulta encontrada para <?= date('d/m/Y', strtotime($dataSelecionada)) ?>.
        </div>
    <?php endif; ?>
</main>

<!-- Modal -->
<div class="modal fade" id="modalConsulta" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header" style="background:blue;">
                <h5 class="modal-title text-white">Gerenciar Consulta</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <h5 id="infoConsulta" class="fw-bold mb-3"></h5>

                <!-- Reagendar -->
                <div class="card mb-3">
                    <div class="card-body">
                        <h6>Reagendar Consulta</h6>
                        <form action="crud/reagendar_consulta.php" method="POST">
                            <input type="hidden" name="id_consulta" id="consultaId">
                            <label>Nova Data</label>
                            <input type="date" class="form-control mb-2" name="nova_data" required>
                            <label>Novo horário</label>
                            <select class="form-control mb-2" name="novo_horario" required>
                                <option disabled selected>Selecione o horário</option>
                                <option>08:00</option><option>09:00</option><option>10:00</option>
                                <option>11:00</option><option>14:00</option><option>15:00</option>
                                <option>16:00</option><option>17:00</option>
                            </select>
                            <button class="btn btn-warning">Confirmar</button>
                        </form>
                    </div>
                </div>

                <!-- Cancelar -->
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-danger">Cancelar Consulta</h6>
                        <form action="crud/cancelar_consulta.php" method="POST">
                            <input type="hidden" name="id_consulta" id="consultaIdCancel">
                            <label>Motivo do cancelamento:</label>
                            <textarea name="motivo" class="form-control" required></textarea>
                            <button class="btn btn-danger mt-2">Cancelar Consulta</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>

        </div>
    </div>
</div>

<script>
var modal = document.getElementById('modalConsulta');
modal.addEventListener('show.bs.modal', function (event) {
    var btn = event.relatedTarget;
    var id = btn.getAttribute('data-id');
    var horario = btn.getAttribute('data-horario');
    var data = btn.getAttribute('data-data');
    var dono = btn.getAttribute('data-dono');
    var animal = btn.getAttribute('data-animal');

    document.getElementById('consultaId').value = id;
    document.getElementById('consultaIdCancel').value = id;

    document.getElementById('infoConsulta').innerHTML =
        "<strong>Dono:</strong> " + dono + 
        " — <strong>Animal:</strong> " + animal + 
        " — <strong>Data:</strong> " + data + 
        " — <strong>Hora:</strong> " + horario;
});
</script>

<?php include 'includes/footer.php'; ?>
