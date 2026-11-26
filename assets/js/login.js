$(document).ready(function () {
    const $toggleBtn = $("#togglePasswordBtn");
    const $passwordInput = $("#password_input");
    const $cedulaInput = $("#cedula_input");
    const $toggleIcon = $("#togglePasswordIcon");
    const $btnAcceder = $("#btnAcceder");
    const $formLogin = $("#formLogin");

    $toggleBtn.on("click", function () {
        if (!$passwordInput.length || !$toggleIcon.length) return;
        const mostrar = $passwordInput.attr("type") === "password";
        $passwordInput.attr("type", mostrar ? "text" : "password");
        $toggleIcon.toggleClass("bi-eye", !mostrar).toggleClass("bi-eye-slash", mostrar);
    });

    function enviarLogin() {
        if (!$formLogin.length) return;
        const formEl = $formLogin[0];

        if (typeof formEl.reportValidity === "function" && !formEl.reportValidity()) {
            return;
        }

        const nombreCampo = $btnAcceder.attr("name") || "Solicitud";
        const valorCampo = $btnAcceder.val() || "acceder";

        let $inputSolicitud = $formLogin.find(`input[type="hidden"][name="${nombreCampo}"]`);
        if (!$inputSolicitud.length) {
            $inputSolicitud = $("<input>", {
                type: "hidden",
                name: nombreCampo
            }).appendTo($formLogin);
        }
        $inputSolicitud.val(valorCampo);

        formEl.submit();
    }

    $btnAcceder.on("click", function (e) {
        e.preventDefault();
        enviarLogin();
    });

    $cedulaInput.add($passwordInput).on("keydown", function (e) {
        if (e.key === "Enter" || e.which === 13) {
            e.preventDefault();
            enviarLogin();
        }
    });

    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get("status");
    const mensaje = urlParams.get("msg");

    if (status) {
        setTimeout(function () {
            let title, text, icon;

            switch (status) {
                case "incorrect":
                    title = "Credenciales incorrectas!";
                    text = mensaje || "Por favor, verifique su cédula y contraseña.";
                    icon = "error";
                    break;
            }

            if (title && text && icon) {
                Swal.fire({
                    title: title,
                    text: text,
                    icon: icon
                });
            }
        }, 100);
    }
});