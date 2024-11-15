document.addEventListener("DOMContentLoaded", (event) => {
  // Datos estáticos para la gráfica de pastel
  // const pieData = {
  //   labels: ["Modelo Marian", "Modelo Rebecca", "Modelo Carolina"],
  //   datasets: [
  //     {
  //       data: [10, 20, 30], // Datos numéricos
  //       backgroundColor: ["#000", "#fcb4bc", "#ecdcc6"],
  //     },
  //   ],
  // };

  // // Opciones de la gráfica de pastel
  // const pieOptions = {
  //   responsive: true,
  //   maintainAspectRatio: false,
  // };

  // // Crear gráfica de pastel
  // const pieCtx = document.getElementById("myPieChart").getContext("2d");
  // new Chart(pieCtx, {
  //   type: "pie",
  //   data: pieData,
  //   options: pieOptions,
  // });

  // // Datos estáticos para la gráfica de barras
  // const barData = {
  //   labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo"],
  //   datasets: [
  //     {
  //       label: "Ventas",
  //       data: [150, 200, 100, 81, 215],
  //       backgroundColor: "#E6C3AA",
  //     },
  //   ],
  // };

  // // Opciones de la gráfica de barras
  // const barOptions = {
  //   responsive: true,
  //   maintainAspectRatio: false,
  // };

  // // Crear gráfica de barras
  // const barCtx = document.getElementById("myBarChart").getContext("2d");
  // new Chart(barCtx, {
  //   type: "bar",
  //   data: barData,
  //   options: barOptions,
  // });

  // Datos estáticos para citas
  const appointmentsData = [
    { cliente: "Juan Pérez", fecha: "2024-06-01", hora: "10:00" },
    { cliente: "María García", fecha: "2024-06-02", hora: "12:00" },
    { cliente: "Luis Martínez", fecha: "2024-06-03", hora: "14:00" },
  ];

  // Rellenar tabla de citas
  const appointmentsTable = document.getElementById("appointments-table");
  appointmentsData.forEach((row, index) => {
    const tr = document.createElement("tr");
    tr.innerHTML = `<td>${row.cliente}</td><td>${row.fecha}</td><td>${row.hora}</td><td class="table-actions">
            <button class="btn btn-warning btn-sm" onclick="editAppointment(${index})"><i class="fa fa-pencil"></i></button>
            <button class="btn btn-danger btn-sm" onclick="deleteAppointment(${index})"><i class="fa fa-trash"></i></button>
        </td>`;
    appointmentsTable.appendChild(tr);
  });

  // Datos estáticos para productos
  const productsData = [
    { producto: "Modelo Mariana", precio: "$8,499.90", stock: 5 },
    { producto: "Modelo Rebecca", precio: "$6,299.90", stock: 3 },
    { producto: "Modelo Carolina", precio: "$7,399.90", stock: 8 },
  ];

  // Rellenar tabla de productos
  const productsTable = document.getElementById("products-table");
  productsData.forEach((row, index) => {
    const tr = document.createElement("tr");
    tr.innerHTML = `<td>${row.producto}</td><td>${row.precio}</td><td>${row.stock}</td><td class="table-actions">
            <button class="btn btn-warning btn-sm" onclick="editProduct(${index})"><i class="fa fa-pencil"></i></button>
            <button class="btn btn-danger btn-sm" onclick="deleteProduct(${index})"><i class="fa fa-trash"></i></button>
        </td>`;
    productsTable.appendChild(tr);
  });
});

function addItem() {
  alert("Agregar item");
}

function editItem(index) {
  alert("Modificar item " + index);
}

function deleteItem(index) {
  alert("Eliminar item " + index);
}

function addAppointment() {
  alert("Agregar cita");
}

function editAppointment(index) {
  alert("Modificar cita " + index);
}

function deleteAppointment(index) {
  alert("Eliminar cita " + index);
}

function addProduct() {
  alert("Agregar producto");
}

function editProduct(index) {
  alert("Modificar producto " + index);
}

function deleteProduct(index) {
  alert("Eliminar producto " + index);
}
