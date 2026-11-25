'use strict';
class Controller extends Controlador {
    constructor(model, view) {
        super(model, view);
        this.checkCookie();
    }
    
    checkCookie = () => {
        // La lógica que ya tenías, pero adaptada al slug
        const cookieName = `${this.model.getMetodo()}_${this.model.slug}`;
        let laCookie = this.model.getCookie(cookieName);
        
        if (laCookie != "") {
            this.model._ajax('GET', `getVisitas/${cookieName }`, null, this.handleCheckCookie);
        } else {
            this.model._ajax('POST', `postVisitas/${cookieName }`, null, (err, o) => {
                if (!err) {
                    this.model.setCookie(cookieName, cookieName, 365, this.checkCookie);
                } else {
                    console.log(err, o);
                }
            });
        }
    };
    
    handleCheckCookie = (err, o) => {
        if (!err) {
            this.view.muestraVisitas(o);
        } else {
            console.log(err, o);
        }
    };
}
