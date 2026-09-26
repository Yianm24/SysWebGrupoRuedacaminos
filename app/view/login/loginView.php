<div class="vh-100 ">
  <div class="container-fluid py-5 h-100 ">
    <main class="row d-flex justify-content-center align-items-center h-100">
      <section class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card bg-dark bg-opacity-75 text-white rounded-4" >
          <div class="card-body p-3 text-center">

            <div class="mb-md-2 mx-4">

              <h2 class="fw-bold mb-2 text-uppercase">Iniciar Sesión</h2>
              <p class="text-white-50 mb-3">Por favor, ingrese su Cedula y Contraseña</p>

              <form action="?url=login" method="post">
                <div class="form-outline form-white mb-2">
                  <input type="text" id="cedula_input" name="cedula" class="form-control form-control-sm anillo-foco" />
                  <label class="fw-bold text-light" for="cedula_input">Cedula</label>
                </div>

              <div class="form-outline form-white mb-2">
                <input type="password" id="password_input" name="password" class="form-control form-control-sm anillo-foco" />
                <label class="fw-bold text-light" for="password_input">Contraseña</label>
              </div>

              <p class="small mb-5 pb-lg-2"><a class="text-white-50" href="#!">Olvido su contraseña?</a></p>

              <button class="btn btn-outline-light btn-lg px-5 mb-2" value="acceder" name="tipoSolicitud" type="submit">Entrar</button>
              </form>
              <a class="btn btn-outline-light btn-lg px-5" href="?url=dashboard">Dashboard</a>

            </div>

        <!--     <div>
              <p class="mb-0">Don't have an account? <a href="#!" class="text-white-50 fw-bold">Sign Up</a>
              </p>
            </div>
 -->
          </div>
        </div>
      </section>