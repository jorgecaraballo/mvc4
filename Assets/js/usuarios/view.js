class View extends Vista {
    constructor(controlador) {
        super(controlador);
        this.menuToggle = document.getElementById('menuToggle');
        this.sidebar = document.getElementById('sidebar');

        this.tbody = document.getElementById('tbodyUsuarios');
        this.formContainer = document.getElementById('formUsuarioContainer');
        this.form = document.getElementById('formUsuario');
        this.btnNuevo = document.getElementById('btnNuevoUsuario');
        this.btnCancelar = document.getElementById('btnCancelarUsuario');
        
        // Referencias al select de roles
        this.selectRoles = document.getElementById('usuario_rol');
    }

    escuchadorMenuToggle = () => {
        this.menuToggle.addEventListener('click', () => {
            this.sidebar.classList.toggle('active');
        });
    };

    // Mostrar/Ocultar el formulario
    toggleFormulario(mostrar, data = null) {
        if (mostrar) {
            this.formContainer.style.display = 'block';
            if (data) {
                document.getElementById('usuario_id').value = data.id;
                document.getElementById('usuario_nombres').value = data.nombres;
                document.getElementById('usuario_apellidos').value = data.apellidos;
                document.getElementById('usuario_email').value = data.email;
                document.getElementById('usuario_password').value = ''; // Siempre vacío por seguridad
                this.selectRoles.value = data.rol_id;
                document.getElementById('usuario_status').value = data.status_id;
                
                // Opcional: Deshabilitar el campo de contraseña si es edición (o dejarlo para cambiar)
                // document.getElementById('usuario_password').required = false;
            } else {
                this.form.reset();
                document.getElementById('usuario_id').value = 0;
            }
        } else {
            this.formContainer.style.display = 'none';
        }
    }

    // Llenar el select de roles dinámicamente
    llenarSelectRoles(roles) {
        this.selectRoles.innerHTML = '<option value="">Seleccione un rol</option>'; // Opción por defecto
        
        roles.forEach(rol => {
            const option = document.createElement('option');
            option.value = rol.id;
            option.textContent = rol.rol;
            this.selectRoles.appendChild(option);
        });
    }

    // Renderizar la tabla de usuarios
    renderizarTabla(usuarios) {
        this.tbody.innerHTML = '';
        
        if (!usuarios || usuarios.length === 0) {
            this.tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding: 20px;">No hay usuarios registrados.</td></tr>';
            return;
        }

        usuarios.forEach(user => {
            const tr = document.createElement('tr');
            tr.style.borderBottom = '1px solid var(--border-color)';
            
            const estadoBadge = user.status_id == 1 
                ? '<span style="color: #10b981;">Activo</span>' 
                : '<span style="color: #ef4444;">Inactivo</span>';

            tr.innerHTML = `
                <td style="padding: 10px;">${user.id}</td>
                <td style="padding: 10px;">${user.nombres}</td>
                <td style="padding: 10px;">${user.apellidos}</td>
                <td style="padding: 10px;">${user.email}</td>
                <td style="padding: 10px;">${user.rol}</td>
                <td style="padding: 10px;">${estadoBadge}</td>
                <td style="padding: 10px;">
                    <button class="btn-edit" data-id="${user.id}" style="background: transparent; border: none; color: var(--accent-color); cursor: pointer; margin-right: 10px;">Editar</button>
                    <button class="btn-delete" data-id="${user.id}" style="background: transparent; border: none; color: #ef4444; cursor: pointer;">Eliminar</button>
                </td>
            `;
            this.tbody.appendChild(tr);
        });
    }

    // Reutilizamos los métodos de notificación y confirmación (puedes copiarlos de roles/view.js)
    mostrarNotificacion(mensaje, tipo = 'success') {
        const container = document.getElementById('toast-container');
        if (!container) return;

        const toast = document.createElement('div');
        toast.className = `toast ${tipo}`;
        toast.innerText = mensaje;

        container.appendChild(toast);

        setTimeout(() => {
            toast.classList.add('fade-out');
            toast.addEventListener('animationend', () => toast.remove());
        }, 3000);
    }

    confirmarAccion(mensaje) {
        return new Promise((resolve) => {
            const dialog = document.getElementById('confirmDialog');
            const btnConfirm = document.getElementById('dialogConfirm');
            const btnCancel = document.getElementById('dialogCancel');
            const msgElement = document.getElementById('dialogMessage');

            msgElement.innerText = mensaje;

            const newBtnConfirm = btnConfirm.cloneNode(true);
            const newBtnCancel = btnCancel.cloneNode(true);
            btnConfirm.replaceWith(newBtnConfirm);
            btnCancel.replaceWith(newBtnCancel);

            newBtnConfirm.addEventListener('click', () => {
                dialog.close();
                resolve(true);
            });

            newBtnCancel.addEventListener('click', () => {
                dialog.close();
                resolve(false);
            });

            dialog.showModal();
        });
    }
}
