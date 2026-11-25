class Controller extends Controlador {
    constructor(model, view) {
        super(model, view);
        this.view.escuchadorMenuToggle();
        }
    }

