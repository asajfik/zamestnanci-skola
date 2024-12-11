    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h2 class="text-center mb-4">Přihlášení</h2>
                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger" role="alert">
                                <?= htmlspecialchars($error); ?>
                            </div>
                        <?php endif; ?>
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input
                                    type="email"
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    placeholder="Zadejte svůj email"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Heslo</label>
                                <input
                                    type="password"
                                    class="form-control"
                                    id="password"
                                    name="password"
                                    placeholder="Zadejte své heslo"
                                    required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Přihlásit se</button>
                        </form>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <p>Nemáte účet? <a href="/register">Zaregistrujte se zde</a></p>
                </div>
            </div>
        </div>
    </div>