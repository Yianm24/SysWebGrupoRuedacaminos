                
                <footer class="bg-white text-center py-3 mt-auto border-top w-100 shadow-sm">
                    <div class="container-fluid">
                        <p class="mb-0 text-muted fw-semibold">&copy; <?= date('Y') ?> Grupo RuedaCaminos C.A.</p>
                        <small class="text-muted">Sistema para Empresa de Envíos - Creado por Seccion 2103, Grupo 2</small>
                    </div>
                </footer>
            </div>
        <!-- /#page-content-wrapper -->
        </div>
        <!-- /#wrapper -->

        <!-- Componentes externos -->
        <script src="assets/js/componentes/externos/jquery-4.0.0.min.js"></script>
        <!--Plugin JQ para validar inputs-->
        <script src="assets/js/componentes/externos/jquery.validate.min.js"></script>
        <!--Bootstrap JS-->
        <script src="assets/js/componentes/externos/bootstrap.bundle.min.js"></script>
        <script src="assets/js/componentes/externos/autoNumeric.min.js"></script>
        <!--Alertar personalizadas-->
        <script src="assets/js/componentes/externos/sweetalert2.all.min.js"></script>

        <!-- Componentes internos -->
        <script src="assets/js/componentes/internos/sidebar.js"></script>
        <script src="assets/js/componentes/internos/expreg2mari.js"></script>
        <script src="assets/js/componentes/internos/busqueda.js"></script>

        <script src="assets/js/<?= $_GET['url'] ?>.js"></script>
    </body>

</html>