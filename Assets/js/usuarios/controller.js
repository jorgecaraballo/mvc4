'use strict';
class Controller extends Controlador {
    constructor(model, view) {
        super(model, view);
        this.init();
    }

    init() {
        this.cargarRolesSelect(); // Primero cargamos los roles para el select
        this.cargarUsuarios();    // Luego cargamos los usuarios
        this.bindEventos();
    }

    cargarRolesSelect() {
        this.model.getRolesSelect((err, o) => {
            if (!err && o.status) {
                this.view.llenarSelectRoles(o.data);
            } else {
                console.error("Error al cargar roles:", o);
            }
        });
    }

    cargarUsuarios() {
        this.model.getUsuarios((err, o) => {
            if (!err && o.status) {
                this.view.renderizarTabla(o.data);
            } else {
                console.error("Error al cargar usuarios:", o);
            }
        });
    }

    bindEventos() {
        this.view.escuchadorMenuToggle();

        // 1. Botón para abrir formulario de nuevo usuario
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
            
            this.model.setUsuario(payload, (err, o) => {
                if (!err && o.status) {
                    this.view.mostrarNotificacion(o.msg, 'success');
                    this.view.toggleFormulario(false);
                    this.cargarUsuarios(); // Recargar tabla
                } else {
                    this.view.mostrarNotificacion(o.msg || "Error al guardar", 'error');
                }
            });
        });

        // 4. Delegación de eventos para botones de Editar y Eliminar
        this.view.tbody.addEventListener('click', (e) => {
            if (e.target.classList.contains('btn-delete')) {
                const id = e.target.getAttribute('data-id');
                
                this.view.confirmarAccion('¿Estás seguro de que deseas eliminar este usuario?')
                    .then((aceptado) => {
                        if (aceptado) {
                            this.model.delUsuario(id, (err, o) => {
                                if (!err && o.status) {
                                    this.view.mostrarNotificacion(o.msg, 'success');
                                    this.cargarUsuarios();
                                } else {
                                    this.view.mostrarNotificacion(o.msg || "Error al eliminar", 'error');
                                }
                            });
                        }
                    });
            }

            if (e.target.classList.contains('btn-edit')) {
                const id = e.target.getAttribute('data-id');
                const fila = e.target.closest('tr');
                const celdas = fila.querySelectorAll('td');
                
                const data = {
                    id: id,
                    nombres: celdas[1].innerText,
                    apellidos: celdas[2].innerText,
                    email: celdas[3].innerText,
                    // Ojo: para el rol, como es un texto (el nombre del rol), no tenemos el ID.
                    // Lo ideal es buscar el ID del rol en el select comparando el texto.
                    // Pero para KISS, haremos que el backend devuelva el id del rol en la tabla (como un data-attribute)
                };
                
                // Buscamos el rol_id que corresponde al nombre del rol seleccionado
                const rolNombre = celdas[4].innerText;
                const selectOptions = this.view.selectRoles.options;
                let rolId = 0;
                for (let i = 0; i < selectOptions.length; i++) {
                    if (selectOptions[i].text === rolNombre) {
                        rolId = selectOptions[i].value;
                        break;
                    }
                }
                data.rol_id = rolId;
                data.status_id = celdas[5].innerText.includes('Activo') ? 1 : 0;
                
                this.view.toggleFormulario(true, data);
            }
        });
    }
}
