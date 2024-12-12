<div class="container mt-5">
    <div class="alert alert-success">
        <p>Přihlášen jako: <strong><?= htmlspecialchars($account['name'] ?? 'Neznámý uživatel'); ?></strong></p>
        <a href="/account/logout" class="btn btn-danger">Odhlásit se</a>
    </div>

    <?php if (!empty($_SESSION["isAdmin"]) && $_SESSION["isAdmin"]): ?>

        <div class="d-flex justify-content-between mb-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">Přidat zaměstnance</button>
            <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#addDepartmentModal">Přidat oddělení</button>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPositionModal">Přidat pozici</button>
        </div>

        <div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="/dashboard/addEmployee" method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addEmployeeModalLabel">Přidat zaměstnance</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="employee-name" class="form-label">Jméno</label>
                                <input type="text" class="form-control" id="employee-name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="employee-email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="employee-email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="employee-salary" class="form-label">Výplata</label>
                                <input type="number" class="form-control" id="employee-salary" name="salary" required>
                            </div>
                            <div class="mb-3">
                                <label for="employee-start_date" class="form-label">Začátek práce</label>
                                <input type="date" class="form-control" id="employee-start_date" name="start_date" required>
                            </div>
                            <div class="mb-3">
                                <label for="employee-position" class="form-label">Pozice</label>
                                <select class="form-select" id="employee-position" name="position_id" required>
                                    <?php foreach ($positions as $position): ?>
                                        <option value="<?= htmlspecialchars($position['id']); ?>"><?= htmlspecialchars($position['name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="employee-department" class="form-label">Oddělení</label>
                                <select class="form-select" id="employee-department" name="department_id" required>
                                    <?php foreach ($departments as $department): ?>
                                        <option value="<?= htmlspecialchars($department['id']); ?>"><?= htmlspecialchars($department['name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zavřít</button>
                            <button type="submit" class="btn btn-primary">Přidat zaměstnance</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addDepartmentModal" tabindex="-1" aria-labelledby="addDepartmentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="/dashboard/addDepartment" method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addDepartmentModalLabel">Přidat oddělení</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="department-name" class="form-label">Název oddělení</label>
                                <input type="text" class="form-control" id="department-name" name="name" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zavřít</button>
                            <button type="submit" class="btn btn-primary">Přidat oddělení</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addPositionModal" tabindex="-1" aria-labelledby="addPositionModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="/dashboard/addPosition" method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addPositionModalLabel">Přidat pozici</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="position-name" class="form-label">Název pozice</label>
                                <input type="text" class="form-control" id="position-name" name="name" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zavřít</button>
                            <button type="submit" class="btn btn-primary">Přidat pozici</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <?php endif; ?>

    <div class="card-header">
        <h2 class="card-title">Zaměstnanci</h2>
    </div>
    <div class="card-body">
        <form method="GET" action="" class="mb-4" id="filter-form">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="department" class="form-label">Oddělení</label>
                    <select id="department" name="department" class="form-select" onchange="document.getElementById('filter-form').submit();">
                        <option value="">Všechna oddělení</option>
                        <?php foreach ($departments as $department): ?>
                            <option value="<?= htmlspecialchars($department['id']); ?>" <?= isset($_GET['department']) && $_GET['department'] == $department['id'] ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($department['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="position" class="form-label">Pozice</label>
                    <select id="position" name="position" class="form-select" onchange="document.getElementById('filter-form').submit();">
                        <option value="">Všechny pozice</option>
                        <?php foreach ($positions as $position): ?>
                            <option value="<?= htmlspecialchars($position['id']); ?>" <?= isset($_GET['position']) && $_GET['position'] == $position['id'] ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($position['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="min_salary" class="form-label">Minimální plat</label>
                    <input type="number" id="min_salary" name="min_salary" class="form-control" value="<?= htmlspecialchars($_GET['min_salary'] ?? ''); ?>" onchange="document.getElementById('filter-form').submit();">
                </div>
                <div class="col-md-2">
                    <label for="max_salary" class="form-label">Maximální plat</label>
                    <input type="number" id="max_salary" name="max_salary" class="form-control" value="<?= htmlspecialchars($_GET['max_salary'] ?? ''); ?>" onchange="document.getElementById('filter-form').submit();">
                </div>
                <div class="col-md-2">
                    <label for="search" class="form-label">Hledat</label>
                    <input type="text" id="search" name="search" class="form-control" placeholder="Vyhledat" value="<?= htmlspecialchars($_GET['search'] ?? ''); ?>" onblur="document.getElementById('filter-form').submit();">
                </div>
            </div>
        </form>


        <!-- Tabulka zaměstnanců -->
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th><a class="<?= $sortBy === 'id' ? 'text-info' : ''; ?>" href="?sort_by=id&order=<?= $sortBy === 'id' && $order === 'ASC' ? 'DESC' : 'ASC'; ?>">ID</a></th>
                        <th><a class="<?= $sortBy === 'name' ? 'text-info' : ''; ?>" href="?sort_by=name&order=<?= $sortBy === 'name' && $order === 'ASC' ? 'DESC' : 'ASC'; ?>">Jméno</a></th>
                        <th><a class="<?= $sortBy === 'email' ? 'text-info' : ''; ?>" href="?sort_by=email&order=<?= $sortBy === 'email' && $order === 'ASC' ? 'DESC' : 'ASC'; ?>">Email</a></th>
                        <th><a class="<?= $sortBy === 'position_name' ? 'text-info' : ''; ?>" href="?sort_by=position_name&order=<?= $sortBy === 'position_name' && $order === 'ASC' ? 'DESC' : 'ASC'; ?>">Pozice</a></th>
                        <th><a class="<?= $sortBy === 'department_name' ? 'text-info' : ''; ?>" href="?sort_by=department_name&order=<?= $sortBy === 'department_name' && $order === 'ASC' ? 'DESC' : 'ASC'; ?>">Oddělení</a></th>
                        <th><a class="<?= $sortBy === 'salary' ? 'text-info' : ''; ?>" href="?sort_by=salary&order=<?= $sortBy === 'salary' && $order === 'ASC' ? 'DESC' : 'ASC'; ?>">Plat</a></th>
                        <th><a class="<?= $sortBy === 'start_date' ? 'text-info' : ''; ?>" href="?sort_by=start_date&order=<?= $sortBy === 'start_date' && $order === 'ASC' ? 'DESC' : 'ASC'; ?>">Začátek práce</a></th>
                        <?php if (!empty($_SESSION["isAdmin"]) && $_SESSION["isAdmin"]): ?>
                            <th>Akce</th>
                        <?php endif; ?>
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
                            <td><?= htmlspecialchars($employee['salary']); ?></td>
                            <td><?= htmlspecialchars($employee['start_date']); ?></td>
                            <?php if (!empty($_SESSION["isAdmin"]) && $_SESSION["isAdmin"]): ?>
                                <td>
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editEmployeeModal-<?= $employee['id']; ?>">Editovat</button>
                                    <form action="/dashboard/deleteEmployee" method="POST" class="d-inline">
                                        <input type="hidden" name="id" value="<?= $employee['id']; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Smazat</button>
                                    </form>
                                </td>
                                <div class="modal fade" id="editEmployeeModal-<?= $employee['id']; ?>" tabindex="-1" aria-labelledby="editEmployeeModalLabel-<?= $employee['id']; ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="/dashboard/editEmployee" method="POST">
                                                <input type="hidden" name="id" value="<?= $employee['id']; ?>">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editEmployeeModalLabel-<?= $employee['id']; ?>">Editace zaměstnance</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="employee-name-<?= $employee['id']; ?>" class="form-label">Jméno</label>
                                                        <input type="text" class="form-control" id="employee-name-<?= $employee['id']; ?>" name="name" value="<?= htmlspecialchars($employee['name']); ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="employee-email-<?= $employee['id']; ?>" class="form-label">Email</label>
                                                        <input type="email" class="form-control" id="employee-email-<?= $employee['id']; ?>" name="email" value="<?= htmlspecialchars($employee['email']); ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="employee-salary-<?= $employee['id']; ?>" class="form-label">Výplata</label>
                                                        <input type="number" class="form-control" id="employee-salary-<?= $employee['id']; ?>" name="salary" value="<?= htmlspecialchars($employee['salary']); ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="employee-start_date-<?= $employee['id']; ?>" class="form-label">Začátek práce</label>
                                                        <input type="date" class="form-control" id="employee-start_date-<?= $employee['id']; ?>" name="start_date" value="<?= htmlspecialchars($employee['start_date']); ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="employee-position-<?= $employee['id']; ?>" class="form-label">Pozice</label>
                                                        <select class="form-select" id="employee-position-<?= $employee['id']; ?>" name="position_id" required>
                                                            <?php foreach ($positions as $position): ?>
                                                                <option value="<?= htmlspecialchars($position['id']); ?>" <?= $employee['position_id'] == $position['id'] ? 'selected' : ''; ?>><?= htmlspecialchars($position['name']); ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="employee-department-<?= $employee['id']; ?>" class="form-label">Oddělení</label>
                                                        <select class="form-select" id="employee-department-<?= $employee['id']; ?>" name="department_id" required>
                                                            <?php foreach ($departments as $department): ?>
                                                                <option value="<?= htmlspecialchars($department['id']); ?>" <?= $employee['department_id'] == $department['id'] ? 'selected' : ''; ?>><?= htmlspecialchars($department['name']); ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zavřít</button>
                                                    <button type="submit" class="btn btn-primary">Uložit změny</button>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>


    <div card class="row">
        <div class="col-md-6">
            <div class="card-header">
                <h2 class="card-title">Oddělení</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Název oddělení</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($departments as $department): ?>
                                <tr>
                                    <td><?= htmlspecialchars($department['id']); ?></td>
                                    <td><?= htmlspecialchars($department['name']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card-header">
                <h2 class="card-title">Pozice</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Název pozice</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($positions as $position): ?>
                                <tr>
                                    <td><?= htmlspecialchars($position['id']); ?></td>
                                    <td><?= htmlspecialchars($position['name']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>