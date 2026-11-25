'use strict';
class Controller extends Controlador {
    constructor(model, view) {
        super(model, view);
        this.init();
    }

    init() {
        this.cargarRoles();
        this.bindEventos();
    }

    cargarRoles() {
        this.model.getRoles((err, o) => {
            if (!err && o.status) {
                this.view.renderizarTabla(o.data);
            } else {
                console.error("Error al cargar roles:", o);
            }
        });
    }

    bindEventos() {
        this.view.escuchadorMenuToggle();

        // 1. Botón para abrir formulario de nuevo rol
        this.view.btnNuevo.addEventListener('click', () => {
            this.view.toggleFormulario(true);
        });

        // 2. Botón cancelar
        this.view.btnCancelar.addEventListener('click', () => {
            this.view.toggleFormulario(false);
        });

        // 3. Submit del formulario (Guardar)
        this.view.form.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(this.view.form);
            const payload = Object.fromEntries(formData.entries());
            
            this.model.setRol(payload, (err, o) => {
                if (!err && o.status) {
                    this.view.mostrarNotificacion(o.msg);
                    this.view.toggleFormulario(false);
                    this.cargarRoles(); // Recargar tabla
                } else {
                    this.view.mostrarNotificacion(o.msg || "Error al guardar");
                }
            });
        });

        // 4. Delegación de eventos para botones de Editar y Eliminar
        this.view.tbody.addEventListener('click', (e) => {

            if (e.target.classList.contains('btn-delete')) {
                const id = e.target.getAttribute('data-id');
                
                // Llamada asíncrona al modal de la vista
                this.view.confirmarAccion('¿Estás seguro de que deseas eliminar este rol?')
                    .then((aceptado) => {
                        if (aceptado) {
                            this.model.delRol(id, (err, o) => {
                                if (!err && o.status) {
                                    this.view.mostrarNotificacion(o.msg, 'success');
                                    this.cargarRoles();
                                } else {
                                    this.view.mostrarNotificacion(o.msg || "Error al eliminar", 'error');
                                }
                            });
                        }
                    });
                }


            if (e.target.classList.contains('btn-edit')) {
                const id = e.target.getAttribute('data-id');
                // Buscamos los datos del rol en la tabla para rellenar el form
                // (Una forma más KISS que hacer otra petición AJAX)
                const fila = e.target.closest('tr');
                const celdas = fila.querySelectorAll('td');
                
                const data = {
                    id: id,
                    rol: celdas[1].innerText,
                    descripcion: celdas[2].innerText,
                    status_id: celdas[3].innerText.includes('Activo') ? 1 : 0
                };
                
                this.view.toggleFormulario(true, data);
            }
        });

        // Evento para abrir el modal de permisos
        this.view.tbody.addEventListener('click', (e) => {
            if (e.target.classList.contains('btn-permisos')) {
                const id = e.target.getAttribute('data-id');
                this.model.getModulosPermisos(id, (err, o) => {
                    if (!err && o.status) {
                        this.view.mostrarModalPermisos(id, o.data);
                    } else {
                        this.view.mostrarNotificacion("Error al cargar permisos", 'error');
                    }
                });
            }
        });

        // Evento para guardar los permisos (submit del form)
        document.getElementById('formPermisos').addEventListener('submit', (e) => {
            e.preventDefault();
            const rol_id = document.getElementById('permisos_rol_id').value;
            const checkboxes = document.querySelectorAll('#modulosContainer input[type="checkbox"]');
            
            // Construir el objeto de permisos
            const permisosObj = {};
            checkboxes.forEach(cb => {
                const modId = cb.getAttribute('data-modulo');
                const tipo = cb.getAttribute('data-permiso');
                
                if (!permisosObj[modId]) {
                    permisosObj[modId] = { modulo_id: modId, r: 0, w: 0, u: 0, d: 0 };
                }
                if (cb.checked) {
                    permisosObj[modId][tipo] = 1;
                }
            });

            // Convertir a array para enviar por FormData
            const formData = new FormData();
            formData.append('rol_id', rol_id);
            let index = 0;
            for (let key in permisosObj) {
                formData.append(`permisos[${index}][modulo_id]`, permisosObj[key].modulo_id);
                formData.append(`permisos[${index}][r]`, permisosObj[key].r);
                formData.append(`permisos[${index}][w]`, permisosObj[key].w);
                formData.append(`permisos[${index}][u]`, permisosObj[key].u);
                formData.append(`permisos[${index}][d]`, permisosObj[key].d);
                index++;
            }

            this.model.setPermisos(formData, (err, o) => {
                if (!err && o.status) {
                    document.getElementById('permisosDialog').close();
                    this.view.mostrarNotificacion(o.msg, 'success');
                } else {
                    this.view.mostrarNotificacion(o.msg || "Error", 'error');
                }
            });
        });

        // Cerrar el modal de permisos
        document.getElementById('permisosCancel').addEventListener('click', () => {
            document.getElementById('permisosDialog').close();
        });

    }
}
