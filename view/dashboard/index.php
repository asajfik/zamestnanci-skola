<div class="container mt-5">
    <h1 class="text-center mb-4"><?= htmlspecialchars($title); ?></h1>

    <!-- Logged-in User Info -->
    <div class="alert alert-success">
        <p>Přihlášen jako: <strong><?= htmlspecialchars($account['name'] ?? 'Neznámý uživatel'); ?></strong></p>
    </div>

    <!-- Employees Table -->
    <h2>Zaměstnanci</h2>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Jméno</th>
                    <th>Email</th>
                    <th>Pozice</th>
                    <th>Oddělení</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($employees as $employee): ?>
                    <tr>
                        <td><?= htmlspecialchars($employee['id']); ?></td>
                        <td><?= htmlspecialchars($employee['name']); ?></td>
                        <td><?= htmlspecialchars($employee['email']); ?></td>
                        <td><?= htmlspecialchars($employee['position_name']); ?></td>
                        <td><?= htmlspecialchars($employee['department_name']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Departments List -->
    <h2>Oddělení</h2>
    <ul class="list-group mb-4">
        <?php foreach ($departments as $department): ?>
            <li class="list-group-item"><?= htmlspecialchars($department['name']); ?></li>
        <?php endforeach; ?>
    </ul>

    <!-- Positions List -->
    <h2>Pozice</h2>
    <ul class="list-group mb-4">
        <?php foreach ($positions as $position): ?>
            <li class="list-group-item"><?= htmlspecialchars($position['name']); ?></li>
        <?php endforeach; ?>
    </ul>
</div>