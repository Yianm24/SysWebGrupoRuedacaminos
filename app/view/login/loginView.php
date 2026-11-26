<?php $msgLogin = $_GET['msg'] ?? ''; ?>

<div class="min-vh-100 d-flex align-items-center justify-content-center p-3"
    style="background: radial-gradient(circle at top right, rgba(234, 179, 8, 0.14), transparent 45%), #f4f6f9;">
  <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white w-100" style="max-width: 420px;">
    <div class="p-4 text-center text-white"
        style="background: linear-gradient(135deg, #111315, #1f2328); border-bottom: 3px solid #eab308;">
      <div class="d-inline-flex align-items-center justify-content-center rounded-circle overflow-hidden mb-2 shadow-sm"
          style="width: 78px; height: 78px; background-color: #ffffff; border: 2px solid #eab308;">
        <img src="app/view/img/logo2.png"
            alt="Logo Grupo RuedaCaminos C.A."
            style="width: 100%; height: 100%; object-fit: cover;">
      </div>
      <h1 class="h5 fw-bold mb-0">Grupo RuedaCaminos C.A.</h1>
      <small class="text-white-50">Sistema de Gestión de Envíos de Paquetería</small>
    </div>

    <div class="card-body p-4">
      <div class="text-center mb-3">
        <h2 class="h6 fw-bold text-dark text-uppercase mb-1">Iniciar Sesión</h2>
        <p class="text-muted small mb-0">Ingrese su cédula y contraseña para acceder</p>
      </div>

      <?php if (!empty($msgLogin)): ?>
        <div class="alert alert-danger py-2 px-3 small rounded-3 mb-3" role="alert">
          <i class="bi bi-exclamation-circle-fill me-1"></i>
          <?= htmlspecialchars($msgLogin, ENT_QUOTES, 'UTF-8') ?>
        </div>
      <?php endif; ?>

      <form id="formLogin" action="?url=login" method="post" autocomplete="off">
        <div class="mb-3">
          <label class="form-label fw-semibold small" for="cedula_input">Cédula</label>
          <input type="text" id="cedula_input" name="cedula"
                class="form-control form-control-lg fs-6 anillo-foco"
                placeholder="Ej. 28123456" required autofocus>
        </div>

        <div class="mb-4">
          <label class="form-label fw-semibold small" for="password_input">Contraseña</label>
          <div class="input-group input-group-lg">
            <input type="password" id="password_input" name="password"
                  class="form-control fs-6 anillo-foco"
                  placeholder="Ingrese su contraseña" required>
            <button class="btn btn-outline-secondary" type="button" id="togglePasswordBtn"
                    aria-label="Mostrar o ocultar contraseña" title="Mostrar / Ocultar contraseña">
              <i class="bi bi-eye" id="togglePasswordIcon"></i>
            </button>
          </div>
        </div>

        <button class="btn btn-dark btn-lg w-100 fw-semibold py-2 rounded-3"
                id="btnAcceder" value="acceder" name="Solicitud" type="button"
                style="border-bottom: 2px solid #eab308;">
          Entrar
        </button>
      </form>
    </div>

    <div class="card-footer bg-light border-0 py-2 text-center">
      <small class="text-muted" style="font-size: 0.78rem;">Acceso restringido al personal autorizado</small>
    </div>
  </div>
</div>