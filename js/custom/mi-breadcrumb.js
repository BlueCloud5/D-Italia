export class MiBreadcrumb extends HTMLElement {
  connectedCallback() {
    this.style.display = "block";

    this.innerHTML =
      /* html */
      `<div class="container mt-2">
        <nav>
            <ol class="breadcrumb fs-5">
                <li class="breadcrumb-item"><a href="index.html" style="text-decoration: none;">Inicio</a></li>
                <i class='bx bx-chevron-right bx-fade-left fs-3 ms-3 me-n1 text-black'></i>
                <li class='breadcrumb-item active'><progress max="100">Cargando&hellip;</progress></li>
            </ol>
        </nav>
      </div>`;

    const paginaActual = this.getPaginaActual();

    let innerHTML = /* html */ `<li>${this.getNombrePagina(paginaActual)}</li>`;
    const ulLinks = this.querySelector("li.active");
    if (ulLinks !== null) {
      ulLinks.innerHTML = innerHTML;
    }
  }

  /**
   * Obtiene la página actual desde la URL.
   * @returns {string} - El nombre de la página actual.
   */
  getPaginaActual() {
    const url = window.location.href;

    // Asegurarnos de que url no es undefined o null
    if (!url) {
      console.error("La URL no es válida");
      return "inicio"; // Regresar 'inicio' por defecto si no se obtiene la URL
    }

    // Obtener el nombre de la página sin la extensión
    const nombrePagina = url.split("/").pop()?.split(".").shift();

    return nombrePagina || "inicio"; // Si no se puede obtener, asigna 'inicio' por defecto
  }

  /**
   * Devuelve el nombre legible de la página según la clave.
   * @param {string} pagina - El nombre de la página.
   * @returns {string} - El nombre legible de la página.
   */
  getNombrePagina(pagina) {
    const nombres = {
      inicio: "Inicio",
      catalogo: "Catálogo",
      citas: "Agenda tu cita",
      nosotros: "Nosotros",
      contacto: "Contacto",
      carrito: "Carrito",
      verificar: "Verificar",
      gracias: "Gracias",
      iniciarSesion: "Iniciar Sesión",
      registro: "Registrarse",
      panelControl: "Panel de Control",
      perfil: "Perfil",
      accesoriosAdmin: "Tabla de Accesorios",
      categoriasAdmin: "Tabla de Categorías",
      citasAdmin: "Tabla de Citas",
      coloresAdmin: "Tabla de Colores",
      contactosAdmin: "Tabla de Mensajes de contacto",
      serviciosAdmin: "Tabla de Servicios",
      tallasAdmin: "Tabla de Tallas",
      usuariosAdmin: "Tabla de Usuarios",
      ventasAdmin: "Tabla de Ventas",
      vestidosAdmin: "Tabla de Vestidos",
      cerrarSesion: "Cerrar Sesión",
    };
    return nombres[pagina] || "Página desconocida";
  }
}

customElements.define("mi-breadcrumb", MiBreadcrumb);
