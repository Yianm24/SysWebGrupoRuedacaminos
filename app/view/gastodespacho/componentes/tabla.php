<td class="pe-4 text-center">
    <a href="#" class="text-secondary me-2 text-decoration-none" title="Editar"
        data-bs-toggle="modal" data-bs-target="#registerdespacho">
        <i class="bi bi-pencil"></i>
    </a>
    <a href="#" class="text-secondary me-2 text-decoration-none" title="Detalles"
        data-bs-toggle="modal" data-bs-target="#registerdespacho">
        <i class="bi bi-eye-fill"></i>
    </a>
    <!-- Nuevo botón transaccional para agregar gastos asociados al despacho -->
    <a href="#" class="text-success me-2 text-decoration-none" title="Gastos Despacho"
        data-bs-toggle="modal" data-bs-target="#modalGastosDespacho" data-id="<?= $value['cod_despacho']; ?>">
        <i class="bi bi-cash-stack"></i>
    </a>
</td>