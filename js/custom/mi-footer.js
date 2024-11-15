import { Sesion } from "../Sesion.js";
import { ROL_ID_ADMINISTRADOR } from "../ROL_ID_ADMINISTRADOR.js";
import { ROL_ID_CLIENTE } from "../ROL_ID_CLIENTE.js";

export class MiFooter extends HTMLElement {
  connectedCallback() {
    this.style.display = "block";

    this.innerHTML =
      /* html */
      `<footer>
        <div class="background">
            <svg class="svg" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1600 900" preserveAspectRatio="none">
                <defs>
                    <path id="wave" fill="rgba(230, 195, 170, 1)" d="M-363.852,502.589c0,0,236.988-41.997,505.475,0
                    s371.981,38.998,575.971,0s293.985-39.278,505.474,5.859s493.475,48.368,716.963-4.995v560.106H-363.852V502.589z" />
                </defs>
                <g>
                    <use xlink:href="#wave" opacity=".4">
                        <animateTransform attributeName="transform" attributeType="XML" type="translate" dur="8s" calcMode="spline" values="270 230; -334 180; 270 230" keyTimes="0; .5; 1" keySplines="0.42, 0, 0.58, 1.0;0.42, 0, 0.58, 1.0" repeatCount="indefinite" />
                    </use>
                    <use xlink:href="#wave" opacity=".6">
                        <animateTransform attributeName="transform" attributeType="XML" type="translate" dur="6s" calcMode="spline" values="-270 230;243 220;-270 230" keyTimes="0; .6; 1" keySplines="0.42, 0, 0.58, 1.0;0.42, 0, 0.58, 1.0" repeatCount="indefinite" />
                    </use>
                    <use xlink:href="#wave" opacity=".9">
                        <animateTransform attributeName="transform" attributeType="XML" type="translate" dur="4s" calcMode="spline" values="0 230;-140 200;0 230" keyTimes="0; .4; 1" keySplines="0.42, 0, 0.58, 1.0;0.42, 0, 0.58, 1.0" repeatCount="indefinite" />
                    </use>
                </g>
            </svg>
        </div>
        <section class="mb-3">
          <ul class="socials">
            <li><a href="#" data-bs-toggle="tooltip" title="Tiktok"><i class='fa-brands fa-tiktok fa-xl'></i></a></li>
            <li><a href="#" data-bs-toggle="tooltip" title="Facebook"><i class="fa-brands fa-facebook fa-xl"></i></a></li>
            <li><a href="#" data-bs-toggle="tooltip" title="Instagram"><i class="fa-brands fa-instagram fa-xl"></i></a></li>
          </ul>
          <ul class="links">
            <li><progress max="100">Cargando&hellip;</progress></li>
          </ul>
        </section>
      </footer>
      <a href="#" class="back-to-top"><i class="fa fa-chevron-up" data-bs-toggle="tooltip" title="Volver a arriba"></i></a>`;
  }

  /**
   * @param {Sesion} sesion
   */
  set sesion(sesion) {
    const rolIds = sesion.rolIds;
    let innerHTML = /* html */ `<li><a href="index.html">Inicio</a></li>`;
    innerHTML += /* html */ `<li><a href="catalogo.html">Catálogo</a></li>`;
    innerHTML += /* html */ `<li><a href="nosotros.html">Nosotros</a></li>`;
    innerHTML += /* html */ `<li><a href="contacto.html">Contacto</a></li>`;
    innerHTML += this.hipervinculosAdmin(rolIds);
    innerHTML += this.hipervinculosCliente(rolIds);
    const ulLinks = this.querySelector("ul.links");
    if (ulLinks !== null) {
      ulLinks.innerHTML = innerHTML;
    }
  }

  /**
   * @param {Set<string>} rolIds
   */
  hipervinculosAdmin(rolIds) {
    return rolIds.has(ROL_ID_ADMINISTRADOR)
      ? /* html */ ""
      : "";
  }

  /**
   * @param {Set<string>} rolIds
   */
  hipervinculosCliente(rolIds) {
    return rolIds.has(ROL_ID_CLIENTE)
      ? /* html */ `<li><a href="citas.html">Agenda tu cita</a></li>`
      : "";
  }
}

customElements.define("mi-footer", MiFooter);
