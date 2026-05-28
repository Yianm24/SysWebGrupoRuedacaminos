<div class="container-fluid py-5 px-4">
    <div class="row">
        <div class="col-xl-5 col-lg-6 mb-4">
            <h2 class="mb-4 text-primary"><i class="bi bi-bank"></i> Gestión de Cuentas Bancarias</h2>
            <div class="card shadow-sm">
                <div class="card-header bg-white"><h5 class="mb-0">Registrar Cuenta Propia</h5></div>
                <div class="card-body">
                    <form action="?url=banco" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Banco</label>
                            
                            <input class="form-control" list="listaBancos" name="nombre_banco" placeholder="Escriba o seleccione un banco..." required>
                            
                            <datalist id="listaBancos">
                                <option value="Banco de Venezuela">
                                <option value="Banesco">
                                <option value="Mercantil">
                                <option value="BBVA Provincial">
                                <option value="BNC">
                            </datalist>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Número de Cuenta (20 dígitos)</label>
                            <input type="text" class="form-control" name="numero_cuenta" placeholder="0134-xxxx-xx-xxxxxxxxxx" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Titular / Razón Social</label>
                            <input type="text" class="form-control" name="titular" value="Grupo RuedaCaminos C.A." readonly>
                        </div>
                        <button type="submit" class="btn btn-primary w-100"><i class="bi bi-plus-circle"></i> Registrar Cuenta</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-7 col-lg-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white"><h4 class="mb-0 fw-bold">Cuentas Registradas</h4></div>
                <div class="card-body p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Banco</th>
                                <th>Número de Cuenta</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ps-4 fw-bold">Banco de Venezuela</td>
                                <td>0102-0000-00-0000000000</td>
                                <td class="text-center">
                                    <a href="#" class="text-secondary me-2"><i class="bi bi-pencil"></i></a>
                                    <a href="#" class="text-secondary"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td class="ps-4 fw-bold">Banesco</td>
                                <td>0134-0000-00-0000000000</td>
                                <td class="text-center">
                                    <a href="#" class="text-secondary me-2"><i class="bi bi-pencil"></i></a>
                                    <a href="#" class="text-secondary"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td class="ps-4 fw-bold">Mercantil</td>
                                <td>0105-0000-00-0000000000</td>
                                <td class="text-center">
                                    <a href="#" class="text-secondary me-2"><i class="bi bi-pencil"></i></a>
                                    <a href="#" class="text-secondary"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>