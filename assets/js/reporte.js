$(document).ready(function () {
    $(".btn-filtro-ingreso").on("click", function () {
        const periodo = $(this).data("periodo");
        $("#periodoIngreso").val(periodo);
        $("#fechaInicioIngreso").val("");
        $("#fechaFinIngreso").val("");
        $("#formReporteIngresoFiltro")[0].submit();
    });

    $("#formReportePersonalizado").on("submit", function (e) {
        const inicio = $("#fecha_inicio").val();
        const fin = $("#fecha_fin").val();

        if (!inicio || !fin) {
            e.preventDefault();
            alert("Seleccione la fecha de inicio y la fecha de fin.");
            return;
        }

        if (inicio > fin) {
            e.preventDefault();
            alert("La fecha de inicio no puede ser mayor que la fecha fin.");
        }
    });
});