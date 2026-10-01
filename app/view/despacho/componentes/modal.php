<div class="modal fade" id="modalDespacho" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="modalLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>


            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light table-header-custom">
                            <tr>
                                <th class="ps-4">DESTINATARIO</th>
                                <th class="text-center">DESTINO</th>
                                <th class="text-center">CHOFER</th>
                                <th class="text-center">VEHICULO</th>
                                <th class="text-center">ASIGNAR FECHA</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- <?php //foreach ($result as $value): 
                                    ?> -->
                            <tr>
                                <td class="ps-4 fw-medium"></td>
                                <td>
                                    <span class="fw-medium"></span>
                                </td>
                                <td class="text-secondary">
                                    <select class="form-select form-select-sm" aria-label="Seleccionar Estado">
                                        <option selected>Estado</option>
                                        <option value="lara">Lara</option>
                                        <option value="yaracuy">Yaracuy</option>
                                    </select>
                                </td>

                                <td class="text-center">
                                    <select class="form-select form-select-sm" aria-label="Seleccionar Estado">
                                        <option selected>Estado</option>
                                        <option value="lara">Lara</option>
                                        <option value="yaracuy">Yaracuy</option>
                                    </select>
                                </td>
                                <td class="text-center">
                                    <input type="date" id="fecha" name="fecha">
                                </td>

                            </tr>
                            <?php //endforeach; 
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>

            <footer class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" name="tipoSolicitud" value="" class="btn btn-primary"></button>
            </footer>

        </div>
    </div>
</div>