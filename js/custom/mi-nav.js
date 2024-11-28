import { htmlentities } from "../../lib/js/htmlentities.js";
import { Sesion } from "../Sesion.js";
import { ROL_ID_ADMINISTRADOR } from "../ROL_ID_ADMINISTRADOR.js";
import { ROL_ID_CLIENTE } from "../ROL_ID_CLIENTE.js";

export class MiNav extends HTMLElement {
  connectedCallback() {
    this.style.display = "block";

    this.innerHTML =
      /* html */
      `<nav
        class="custom-navbar navbar navbar-expand-md navbar-dark bg-dark sticky-top"
        aria-label="Furni navigation bar">
        <div class="container-fluid">
          <a class="navbar-brand"
            href="index.html">D'Italia<span>.</span></a>
          <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse" data-bs-target="#navbarsFurni"
            aria-controls="navbarsFurni" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarsFurni">
            <ul
              class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0 fs-5 d-flex align-items-center">
              <li class="nav-item">
                <progress max="100">Cargando&hellip;</progress>
              </li> 
            </ul>
          </div>
        </div>
      </nav>`;
  }

  /**
   * @param {Sesion} sesion
   */
  set sesion(sesion) {
    const cue = sesion.cue;
    const rolIds = sesion.rolIds;
    let innerHTML = /* html */ `<li><a class="nav-link active" href="../index.html">Inicio</a></li>`;
    innerHTML += /* html */ `<li><a class="nav-link" href="../catalogo.html">Catálogo</a></li>`;
    if (rolIds.has(ROL_ID_CLIENTE)) {
      innerHTML += /* html */ `<li><a class="nav-link" href="../cliente/citas.html">Agenda tu cita</a></li>`;
    }
    if (rolIds.has(ROL_ID_CLIENTE) || !rolIds.has(ROL_ID_ADMINISTRADOR)) {
      innerHTML += /* html */ `<li><a class="nav-link" href="../nosotros.html">Nosotros</a></li>`;
      innerHTML += /* html */ `<li><a class="nav-link" href="../contacto.html">Contacto</a></li>`;
    }
    if (!rolIds.has(ROL_ID_CLIENTE) && !rolIds.has(ROL_ID_ADMINISTRADOR)) {
      innerHTML += /* html */ `<li><a class="nav-link" href="../iniciarSesion.html"><i class="bx bx-user bx-md"></i></a></li>`;
    }
    innerHTML += this.hipervinculosAdmin(rolIds);
    innerHTML += this.hipervinculosCliente(rolIds);
    const cueHtml = htmlentities(cue);
    if (cue !== "") {
      innerHTML += /* html */ `
      <li class="nav-item">
        <span class="fs-5 fw-bold">${cueHtml}</span>
        <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="../recursos/images/perfil/default/anonimo.png" alt="perfil" style="border-radius: 25px; max-height: 50px; filter: brightness(1);">
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
          <li><a class="dropdown-item" href="../perfil.html">Perfil</a></li>
        </ul>
      </li>
      `;
    }
    const ul = this.querySelector("ul.custom-navbar-nav");
    if (ul !== null) {
      ul.innerHTML = innerHTML;
    }
  }

  /**
   * @param {Set<string>} rolIds
   */
  hipervinculosAdmin(rolIds) {
    return rolIds.has(ROL_ID_ADMINISTRADOR)
      ? /* html */ `<li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Administración
      </a>
      <ul class="dropdown-menu" aria-labelledby="adminDropdown">
          <li><a class="dropdown-item" href="../admin/panelControl.html">Panel de Control</a></li>
          <li><a class="dropdown-item" href="../admin/accesoriosAdmin.html">Accesorios</a></li>
          <li><a class="dropdown-item" href="../admin/categoriasAdmin.html">Categorías</a></li>
          <li><a class="dropdown-item" href="../admin/coloresAdmin.html">Colores</a></li>
          <li><a class="dropdown-item" href="../admin/contactosAdmin.html">Mensajes de contacto</a></li>
          <li><a class="dropdown-item" href="../admin/serviciosAdmin.html">Servicios</a></li>
          <li><a class="dropdown-item" href="../admin/tallasAdmin.html">Tallas</a></li>
          <li><a class="dropdown-item" href="../admin/usuariosAdmin.html">Usuarios</a></li>
          <li><a class="dropdown-item" href="../admin/vestidosAdmin.html">Vestidos</a></li>
      </ul>
  </li>`
      : "";
  }
  // hipervinculosAdmin(rolIds) {
  //   return rolIds.has(ROL_ID_ADMINISTRADOR)
  //     ? /* html */ `<li class="nav-item dropdown">
  //     <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
  //         Administración
  //     </a>
  //     <ul class="dropdown-menu" aria-labelledby="adminDropdown">
  //         <li><a class="dropdown-item" href="../admin/panelControl.html">Panel de Control</a></li>
  //         <li><a class="dropdown-item" href="../admin/accesoriosAdmin.html">Accesorios</a></li>
  //         <li><a class="dropdown-item" href="../admin/categoriasAdmin.html">Categorías</a></li>
  //         <li><a class="dropdown-item" href="../admin/citasAdmin.html">Citas</a></li>
  //         <li><a class="dropdown-item" href="../admin/coloresAdmin.html">Colores</a></li>
  //         <li><a class="dropdown-item" href="../admin/contactosAdmin.html">Mensajes de contacto</a></li>
  //         <li><a class="dropdown-item" href="../admin/serviciosAdmin.html">Servicios</a></li>
  //         <li><a class="dropdown-item" href="../admin/tallasAdmin.html">Tallas</a></li>
  //         <li><a class="dropdown-item" href="../admin/usuariosAdmin.html">Usuarios</a></li>
  //         <li><a class="dropdown-item" href="../admin/ventasAdmin.html">Ventas</a></li>
  //         <li><a class="dropdown-item" href="../admin/vestidosAdmin.html">Vestidos</a></li>
  //     </ul>
  // </li>`
  //     : "";
  // }

  /**
   * @param {Set<string>} rolIds
   */
  hipervinculosCliente(rolIds) {
    return rolIds.has(ROL_ID_CLIENTE)
      ? // ? /* html */ `<li><a class="nav-link" href="carrito.html"><i class="bx bx-cart bx-md"></i></a></li>`
        ""
      : "";
  }
}

customElements.define("mi-nav", MiNav);
