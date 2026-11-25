class View extends Vista {
    constructor(controlador) {
        super(controlador);
         this.menuToggle = document.getElementById('menuToggle');
         this.sidebar = document.getElementById('sidebar');

        this.tbody = document.getElementById('tbodyRoles');
        this.formContainer = document.getElementById('formRolContainer');
        this.form = document.getElementById('formRol');
        this.btnNuevo = document.getElementById('btnNuevoRol');
        this.btnCancelar = document.getElementById('btnCancelar');
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
                document.getElementById('rol_id').value = data.id;
                document.getElementById('rol_nombre').value = data.rol;
                document.getElementById('rol_descripcion').value = data.descripcion;
                document.getElementById('rol_status').value = data.status_id;
            } else {
                this.form.reset();
                document.getElementById('rol_id').value = 0;
            }
        } else {
            this.formContainer.style.display = 'none';
        }
    }

    // Renderizar la tabla de roles
    renderizarTabla(roles) {
        this.tbody.innerHTML = '';
        
        if (!roles || roles.length === 0) {
            this.tbody.innerHTML = '<tr><td colspan="5" style="text-align:center; padding: 20px;">No hay roles registrados.</td></tr>';
            return;
        }

        roles.forEach(rol => {
            const tr = document.createElement('tr');
            tr.style.borderBottom = '1px solid var(--border-color)';
            
            // Estado visual
            const estadoBadge = rol.status_id == 1 
                ? '<span style="color: #10b981;">Activo</span>' 
                : '<span style="color: #ef4444;">Inactivo</span>';

            tr.innerHTML = `
                <td style="padding: 10px;">${rol.id}</td>
                <td style="padding: 10px;">${rol.rol}</td>
                <td style="padding: 10px;">${rol.descripcion || ''}</td>
                <td style="padding: 10px;">${estadoBadge}</td>
                <td style="padding: 10px;">
                    <button class="btn-permisos" data-id="${rol.id}" style="background: transparent; border: none; color: #f59e0b; cursor: pointer; margin-right: 10px;">Permisos</button>
                    <button class="btn-edit" data-id="${rol.id}" style="background: transparent; border: none; color: var(--accent-color); cursor: pointer; margin-right: 10px;">Editar</button>
                    <button class="btn-delete" data-id="${rol.id}" style="background: transparent; border: none; color: #ef4444; cursor: pointer;">Eliminar</button>
                </td>
            `;
            this.tbody.appendChild(tr);
        });
    }
    mostrarNotificacion(mensaje, tipo = 'success') {
        const container = document.getElementById('toast-container');
        if (!container) return;

        const toast = document.createElement('div');
        toast.className = `toast ${tipo}`;
        toast.innerText = mensaje;

        container.appendChild(toast);

        // Eliminar después de 3 segundos
        setTimeout(() => {
            toast.classList.add('fade-out');
            // Esperar a que termine la animación para eliminar del DOM
            toast.addEventListener('animationend', () => toast.remove());
        }, 3000);
    }

    // ... (métodos anteriores)

    // Nuevo método para confirmar acciones
    confirmarAccion(mensaje) {
        return new Promise((resolve) => {
            const dialog = document.getElementById('confirmDialog');
            const btnConfirm = document.getElementById('dialogConfirm');
            const btnCancel = document.getElementById('dialogCancel');
            const msgElement = document.getElementById('dialogMessage');

            msgElement.innerText = mensaje;

            // Limpiamos eventos anteriores clonando los botones
            // (Truco KISS para evitar múltiples listeners acumulados)
            const newBtnConfirm = btnConfirm.cloneNode(true);
            const newBtnCancel = btnCancel.cloneNode(true);
            btnConfirm.replaceWith(newBtnConfirm);
            btnCancel.replaceWith(newBtnCancel);

            // Al hacer clic en Aceptar
            newBtnConfirm.addEventListener('click', () => {
                dialog.close();
                resolve(true);
            });

            // Al hacer clic en Cancelar
            newBtnCancel.addEventListener('click', () => {
                dialog.close();
                resolve(false);
            });

            // Abrimos el dialog
            dialog.showModal();
        });
    }

    // ... (métodos anteriores)

    // Abrir el modal de permisos y renderizar los módulos
    mostrarModalPermisos(rol_id, modulos) {
        const dialog = document.getElementById('permisosDialog');
        document.getElementById('permisos_rol_id').value = rol_id;
        
        const container = document.getElementById('modulosContainer');
        container.innerHTML = '';

        modulos.forEach(m => {
            const row = document.createElement('div');
            row.style.display = 'flex';
            row.style.alignItems = 'center';
            row.style.justifyContent = 'space-between';
            row.style.padding = '10px 0';
            row.style.borderBottom = '1px solid var(--border-color)';

            row.innerHTML = `
                <span style="font-weight: bold;">${m.modulo}</span>
                <div style="display: flex; gap: 15px;">
                    <label><input type="checkbox" data-modulo="${m.id}" data-permiso="r" ${m.r == 1 ? 'checked' : ''}> Leer</label>
                    <label><input type="checkbox" data-modulo="${m.id}" data-permiso="w" ${m.w == 1 ? 'checked' : ''}> Crear</label>
                    <label><input type="checkbox" data-modulo="${m.id}" data-permiso="u" ${m.u == 1 ? 'checked' : ''}> Editar</label>
                    <label><input type="checkbox" data-modulo="${m.id}" data-permiso="d" ${m.d == 1 ? 'checked' : ''}> Borrar</label>
                </div>
            `;
            container.appendChild(row);
        });

        dialog.showModal();
    }

}
