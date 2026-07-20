<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light table-header-custom">
                <tr>
                    <th class="ps-4">BANCO</th>
                    <th>NÚMERO DE CUENTA</th>
                    <th class="pe-4 text-center">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($registros as $dato): ?>
                    <tr>
                        <td class="ps-4 fw-medium"><?= $dato['nombrebanco'] ?></td>
                        <td>
                            <span class="fw-medium"><?php echo $dato['numero_cuenta']; ?></span>
                        </td>
                        
                        <td class="pe-4 text-center">
                            <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline" title="Editar" data-bs-toggle="modal" data-bs-target="#editCliente"
                                   
                                >
                            <i class="bi bi-pencil"></i>
                            </button>
                            <form action="?url=cliente" method="POST" style="display: inline;">
                                <fieldset style="display: inline;">
                                    <!-- Elementos para eliminar un vehiculo -->
                                    <input type="hidden" name="cod_cliente" >
                                    <button type="submit" name="tipoSolicitud" value="eliminar" class="btn btn-link text-secondary p-0 m-0 align-baseline" title="Eliminar" onclick="return confirm('¿Está seguro de eliminar este cliente?');">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </fieldset>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <!--<tr>
                    <td class="ps-4 fw-bold">Banco de Venezuela</td>
                    <td>0102-0000-00-0000000000</td>
                    <td class="pe-4 text-center">
                        <a href="#" class="text-secondary me-2"><i class="bi bi-pencil"></i></a>
                        <a href="#" class="text-secondary"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
                <tr>
                    <td class="ps-4 fw-bold">Banesco</td>
                    <td>0134-0000-00-0000000000</td>
                    <td class="pe-4 text-center">
                        <a href="#" class="text-secondary me-2"><i class="bi bi-pencil"></i></a>
                        <a href="#" class="text-secondary"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
                <tr>
                    <td class="ps-4 fw-bold">Mercantil</td>
                    <td>0105-0000-00-0000000000</td>
                    <td class="pe-4 text-center">
                        <a href="#" class="text-secondary me-2"><i class="bi bi-pencil"></i></a>
                        <a href="#" class="text-secondary"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>-->

                </tbody>
        </table>
    </div>
</div>