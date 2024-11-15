export class MiBanner extends HTMLElement {
  connectedCallback() {
    this.style.display = "block";

    this.innerHTML =
      /* html */
      `<div class="hero">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-6">
                    <h1 id="titulo"><progress max="100">Cargando&hellip;</progress></h1>
                    <p class="fs-4 lh-base" id="descripcion"><progress max="100">Cargando&hellip;</progress></p>
                </div>
                <div class="col-lg-6">
                    <img src="recursos/images/plantilla/logo-texto.png" class="img-fluid" style="filter: drop-shadow(12px 12px 5px rgba(0, 0, 0, 0.7));">
                    <p class="text-center"><img src="recursos/images/plantilla/logo-ilustracion.png" class="w-25" style="filter: drop-shadow(12px 12px 5px rgba(0, 0, 0, 0.7));"></p>
                </div>
            </div>
        </div>
       </div>`;

    const paginaActual = this.getPaginaActual();

    let titulo = this.getNombrePagina(paginaActual);
    const ulTitulo = this.querySelector("h1#titulo");
    if (ulTitulo !== null) {
      ulTitulo.innerHTML = titulo;
    }

    let descripcion = this.getDescripcionPagina(paginaActual);
    const ulDescripcion = this.querySelector("p#descripcion");
    if (ulDescripcion !== null) {
      ulDescripcion.innerHTML = descripcion;
    }
  }

  /**
   * Obtiene la página actual desde la URL.
   * @returns {string} - El nombre de la página actual.
   */
  getPaginaActual() {
    const url = window.location.href;

    if (!url) {
      console.error("La URL no es válida");
      return "inicio";
    }

    const nombrePagina = url.split("/").pop()?.split(".").shift();

    return nombrePagina || "inicio";
  }

  /**
   * Devuelve el nombre legible de la página según la clave.
   * @param {string} pagina - El nombre de la página.
   * @returns {string} - El nombre legible de la página.
   */
  getNombrePagina(pagina) {
    const nombres = {
      catalogo: "Catálogo de productos",
      citas: "Agenda tu cita",
      nosotros: "Nosotros",
      contacto: "Contacto",
    };
    return nombres[pagina] || "Página desconocida";
  }

  getDescripcionPagina(pagina) {
    const descripciones = {
      catalogo:
        "Descubre nuestra amplia selección de vestidos, accesorios y más para hacer tu día especial inolvidable.",
      citas:
        "¿Tienes dudas sobre algún producto? Podemos atenderte en nuestra tienda física, agenda tu cita.",
      nosotros:
        "Nuestra misión es hacer realidad los sueños de todas las jóvenes al ofrecer vestidos de XV años únicos y deslumbrantes, que las hagan sentir especiales y radiantes en su día tan esperado.",
      contacto:
        "En D'Italia, nos apasiona hacer realidad tus sueños para ese día tan especial. Nuestro equipo está dedicado a ofrecerte la mejor atención y asesoría en cada paso del proceso de elección de tu vestido de XV Años. Si tienes alguna pregunta, necesitas más información sobre nuestros productos o servicios, o deseas programar una cita, no dudes en ponerte en contacto con nosotros.",
    };
    return descripciones[pagina] || "Bienvenido a nuestra página.";
  }
}

customElements.define("mi-banner", MiBanner);
