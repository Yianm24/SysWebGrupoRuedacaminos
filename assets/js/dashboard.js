$(document).ready(function () {
    $(".row .card-body h2").each(function () {
        const $el = $(this);
        const textoOriginal = $el.text().trim();
        const esMoneda = textoOriginal.startsWith("$");
        const valorNumerico = parseFloat(textoOriginal.replace(/[^0-9.-]+/g, ""));

        if (isNaN(valorNumerico) || valorNumerico === 0) return;

        $({ contador: 0 }).animate(
            { contador: valorNumerico },
            {
                duration: 600,
                easing: "swing",
                step: function (ahora) {
                    if (esMoneda) {
                        $el.text(
                            "$" +
                                ahora.toLocaleString("en-US", {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2,
                                })
                        );
                    } else {
                        $el.text(Math.floor(ahora));
                    }
                },
                complete: function () {
                    $el.text(textoOriginal);
                },
            }
        );
    });

    const $filasEnvios = $("table tbody tr").filter(function () {
        return $(this).find("td").length === 4;
    });

    $filasEnvios.css("cursor", "pointer").on("click", function () {
        const tracking = $(this).find("td").eq(0).text().trim();
        const cliente = $(this).find("td").eq(1).text().trim();
        const destino = $(this).find("td").eq(2).text().trim();
        const monto = $(this).find("td").eq(3).text().trim();

        if (typeof Swal !== "undefined") {
            Swal.fire({
                title: `Envío ${tracking}`,
                html: `
                    <div class="text-start small">
                        <p class="mb-1"><strong>Destinatario:</strong> ${cliente}</p>
                        <p class="mb-1"><strong>Destino:</strong> ${destino}</p>
                        <p class="mb-0"><strong>Monto Total:</strong> ${monto}</p>
                    </div>
                `,
                icon: "info",
                showCancelButton: true,
                confirmButtonText: "Ir a Envíos",
                cancelButtonText: "Cerrar",
                confirmButtonColor: "#0d6efd",
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "?url=envio";
                }
            });
        } else {
            window.location.href = "?url=envio";
        }
    });
});