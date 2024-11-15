/*=============================================
PAGINACION PRODUCTOS
=============================================*/
function obtenerProductosPaginados(tipo, pagina, filtros) {
  if (tipo === "vestidos") {
    $.ajax({
      url: "ajax/ajaxVestidos.php",
      method: "POST",
      data: {
        accion: "paginarVestidos",
        pagina: pagina,
        filtros: filtros,
      },
      dataType: "json",
      success: function (respuesta) {
        if (respuesta && respuesta.html) {
          document.querySelector("#tarjetasVes").innerHTML = respuesta.html;
          bindProductItemClick(tipo);
          actualizarInterfazPaginacion(
            respuesta.total,
            respuesta.pagina,
            tipo,
            filtros
          );
        }
      },
      error: function (xhr, status, error) {
        console.error("Error al obtener los datos:", xhr["responseText"]);
      },
    });
  } else if (tipo === "accesorios") {
    $.ajax({
      url: "ajax/ajaxAccesorios.php",
      method: "POST",
      data: {
        accion: "paginarAccesorios",
        pagina: pagina,
        filtros: filtros,
      },
      dataType: "json",
      success: function (respuesta) {
        if (respuesta && respuesta.html) {
          document.querySelector("#tarjetasAcc").innerHTML = respuesta.html;
          bindProductItemClick(tipo);
          actualizarInterfazPaginacion(
            respuesta.total,
            respuesta.pagina,
            tipo,
            filtros
          );
        }
      },
      error: function (xhr, status, error) {
        console.error("Error al obtener los datos:", xhr["responseText"]);
      },
    });
  }
}

function actualizarInterfazPaginacion(total, paginaActual, tipo, filtros) {
  paginaActual = parseInt(paginaActual);
  var porPagina = 6;
  var totalPages = Math.ceil(total / porPagina);

  var paginacionHTML = "";

  if (totalPages > 1) {
    paginacionHTML += '<ul class="pagination">';

    if (paginaActual > 1) {
      paginacionHTML +=
        '<li class="page-item"><a class="page-link" href="#" data-pagina="' +
        (paginaActual - 1) +
        '">Anterior</a></li>';
    } else {
      paginacionHTML +=
        '<li class="page-item disabled"><a class="page-link" href="#">Anterior</a></li>';
    }

    for (var i = 1; i <= totalPages; i++) {
      if (i === paginaActual) {
        paginacionHTML +=
          '<li class="page-item active"><a class="page-link" href="#">' +
          i +
          "</a></li>";
      } else {
        paginacionHTML +=
          '<li class="page-item"><a class="page-link" href="#" data-pagina="' +
          i +
          '">' +
          i +
          "</a></li>";
      }
    }

    if (paginaActual < totalPages) {
      paginacionHTML +=
        '<li class="page-item"><a class="page-link" href="#" data-pagina="' +
        (paginaActual + 1) +
        '">Siguiente</a></li>';
    } else {
      paginacionHTML +=
        '<li class="page-item disabled"><a class="page-link" href="#">Siguiente</a></li>';
    }

    paginacionHTML += "</ul>";
  }

  var paginacionID =
    tipo === "vestidos" ? "#paginacionVestidos" : "#paginacionAccesorios";
  $(paginacionID).html(paginacionHTML);

  $(paginacionID).off("click", ".page-link");
  $(paginacionID).on("click", ".page-link", function (e) {
    e.preventDefault();
    var pagina = $(this).data("pagina");
    obtenerProductosPaginados(tipo, pagina, filtros);
  });
}

$(document).ready(function () {
  obtenerProductosPaginados("vestidos", 1, "");

  // Formulario vestidos
  $("#formFiltrosVes").on("submit", function (event) {
    event.preventDefault();

    const serializedFormData = {};
    $("input[name='tallas[]']:checked").each(function () {
      if (!serializedFormData["tallas"]) {
        serializedFormData["tallas"] = [];
      }
      serializedFormData["tallas"].push($(this).val());
    });

    $("input[name='colores[]']:checked").each(function () {
      if (!serializedFormData["colores"]) {
        serializedFormData["colores"] = [];
      }
      serializedFormData["colores"].push($(this).val());
    });

    const formData = new FormData(this);
    for (let [key, value] of formData.entries()) {
      serializedFormData[key] = value;
    }

    obtenerProductosPaginados("vestidos", 1, serializedFormData);
  });

  // Formulario accesorios
  $("#formFiltrosAcc").on("submit", function (event) {
    event.preventDefault();

    const serializedFormData = {};
    $("input[name='colores[]']:checked").each(function () {
      if (!serializedFormData["colores"]) {
        serializedFormData["colores"] = [];
      }
      serializedFormData["colores"].push($(this).val());
    });

    const formData = new FormData(this);
    for (let [key, value] of formData.entries()) {
      serializedFormData[key] = value;
    }

    obtenerProductosPaginados("accesorios", 1, serializedFormData);
  });
});

document
  .getElementById("resetButtonVes")
  .addEventListener("click", function () {
    document.getElementById("formFiltrosVes").reset();
    obtenerProductosPaginados("vestidos", 1, "");
  });

document
  .getElementById("pills-vestidos-tab")
  .addEventListener("click", function () {
    document.getElementById("formFiltrosVes").reset();
    obtenerProductosPaginados("vestidos", 1, "");
  });

document
  .getElementById("resetButtonAcc")
  .addEventListener("click", function () {
    document.getElementById("formFiltrosAcc").reset();
    obtenerProductosPaginados("accesorios", 1, "");
  });

document
  .getElementById("pills-accesorios-tab")
  .addEventListener("click", function () {
    document.getElementById("formFiltrosAcc").reset();
    obtenerProductosPaginados("accesorios", 1, "");
  });

document.addEventListener("DOMContentLoaded", function () {
  function toggleColors(buttonId, containerId) {
    const toggleColorsButton = document.getElementById(buttonId);
    const colorOptions = document.querySelectorAll(
      containerId + " .color-option"
    );
    let expanded = false;

    toggleColorsButton.addEventListener("click", function (event) {
      event.preventDefault();

      colorOptions.forEach((colorOption, index) => {
        if (index >= 3) {
          colorOption.classList.toggle("d-none");
        }
      });

      if (expanded) {
        toggleColorsButton.innerHTML =
          '<i class="fa-solid fa-plus"></i> Mostrar más';
      } else {
        toggleColorsButton.innerHTML =
          '<i class="fa-solid fa-minus"></i> Mostrar menos';
      }
      expanded = !expanded;
    });

    return function resetToggle() {
      colorOptions.forEach((colorOption, index) => {
        if (index >= 3) {
          colorOption.classList.add("d-none");
        }
      });
      toggleColorsButton.innerHTML =
        '<i class="fa-solid fa-plus"></i> Mostrar más';
      expanded = false;
    };
  }

  let resetVestidosColors = toggleColors(
    "toggleColorsVes",
    "#pills-vestidos #colorContainer"
  );
  let resetAccesoriosColors = toggleColors(
    "toggleColorsAcc",
    "#pills-accesorios #colorContainer"
  );

  const vestidosTab = document.querySelector("#pills-vestidos-tab");
  const accesoriosTab = document.querySelector("#pills-accesorios-tab");

  vestidosTab.addEventListener("shown.bs.tab", function () {
    resetVestidosColors();
  });

  accesoriosTab.addEventListener("shown.bs.tab", function () {
    resetAccesoriosColors();
  });

  if (vestidosTab.classList.contains("active")) {
    resetVestidosColors();
  } else if (accesoriosTab.classList.contains("active")) {
    resetAccesoriosColors();
  }
});

/*=============================================
INPUT PRECIO
=============================================*/

document.addEventListener("DOMContentLoaded", function () {
  function updatePrice(priceMaxElement, priceMaxDisplayElement) {
    const priceMax = parseInt(priceMaxElement.value);
    priceMaxDisplayElement.innerText = `$${priceMax.toLocaleString("en-US")}`;
  }

  const priceMaxVestidos = document.getElementById("precioVestidos");
  const priceMaxDisplayVestidos = document.getElementById(
    "priceMaxDisplayVestidos"
  );

  priceMaxVestidos.addEventListener("input", function () {
    updatePrice(priceMaxVestidos, priceMaxDisplayVestidos);
  });

  updatePrice(priceMaxVestidos, priceMaxDisplayVestidos);

  const priceMaxAccesorios = document.getElementById("precioAccesorios");
  const priceMaxDisplayAccesorios = document.getElementById(
    "priceMaxDisplayAccesorios"
  );

  priceMaxAccesorios.addEventListener("input", function () {
    updatePrice(priceMaxAccesorios, priceMaxDisplayAccesorios);
  });

  updatePrice(priceMaxAccesorios, priceMaxDisplayAccesorios);
});
