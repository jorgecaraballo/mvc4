class Model extends Modelo {
    constructor(controlador, metodo) {
        super(controlador, metodo);
    }

    // Obtener todos los usuarios
    getUsuarios(callback) {
        this._ajax('GET', 'getUsuarios', null, callback);
    }

    // Insertar o actualizar un usuario
    setUsuario(payload, callback) {
        this._ajax('POST', 'setUsuario', payload, callback);
    }

    // Eliminar un usuario
    delUsuario(id, callback) {
        this._ajax('POST', 'delUsuario', { id: id }, callback);
    }

    // Obtener los roles para el select del formulario
    getRolesSelect(callback) {
        this._ajax('GET', 'getRolesSelect', null, callback);
    }
}
