class Model extends Modelo {
    constructor(controlador, metodo) {
        super(controlador, metodo);
    }

    // Obtener todos los roles
    getRoles(callback) {
        this._ajax('GET', 'getRoles', null, callback);
    }

    // Insertar o actualizar un rol
    setRol(payload, callback) {
        this._ajax('POST', 'setRol', payload, callback);
    }

    // Eliminar un rol
    delRol(id, callback) {
        this._ajax('POST', 'delRol', { id: id }, callback);
    }
    getModulosPermisos(id, callback) {
        this._ajax('GET', `getModulosPermisos/${id}`, null, callback);
    }

    setPermisos(data, callback) {
        this._ajax('POST', 'setPermisos', data, callback);
    }
}
