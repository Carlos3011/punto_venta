import {Tabulator} from 'tabulator-tables';

document.addEventListener('DOMContentLoaded', function () {
    let table = new Tabulator("#tabla-ejemplo", {
        layout: "fitColumns",
        responsiveLayout: "hide",
        pagination: "local",
        paginationSize: 10,
        paginationSizeSelector: [5, 10, 20, 50],
        columns: [
            { title: "ID", field: "id", sorter: "number", width: 80 },
            { title: "Nombre", field: "nombre", sorter: "string" },
            { title: "Email", field: "email", sorter: "string" },
            { title: "Rol", field: "rol", sorter: "string" },
            { title: "Estado", field: "estado", sorter: "string" },
        ],
        data: [
            { id: 1, nombre: "Juan Pérez", email: "juan@ejemplo.com", rol: "Administrador", estado: "Activo" },
            { id: 2, nombre: "María García", email: "maria@ejemplo.com", rol: "Vendedor", estado: "Activo" },
            { id: 3, nombre: "Carlos López", email: "carlos@ejemplo.com", rol: "Almacenista", estado: "Inactivo" },
        ],
        locale: "es-es",
        placeholder: "No hay datos disponibles"
    });
});