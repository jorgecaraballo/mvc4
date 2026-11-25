class Controller extends Controlador {
    constructor(model, view) {
        super(model, view);
        this.view.escuchadorLoginComponent(this.handleEscuchadorLoginComponent);
        }
    handleEscuchadorLoginComponent = (detail) => {
        this.model._ajax('POST', 'loginUser', detail, (err, o) => {
        if  (!err) {
                this.view.handleEscuchadorLoginComponent(o); 
                }
        else {
                console.log(err, o);
                }
            });
        };
    }

