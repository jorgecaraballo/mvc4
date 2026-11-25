class View extends Vista {
	constructor() {
		super();
        this.loginComponent = document.getElementsByTagName('login-component')[0];
		}
    escuchadorLoginComponent(handleEscuchadorLoginComponent) {
        this.loginComponent.addEventListener('login-submit', (e) => {
            handleEscuchadorLoginComponent(e.detail);
            });
        }
    handleEscuchadorLoginComponent = (o) => {
        if (o.status) {
            //console.log(o);
            window.location = base_url+'dashboard';
            }
        else {
            // En lugar de solo console.log, llamamos a nuestra función que pasa el mensaje al componente
            this.muestraErrorLogin(o.msg);
            }
        };
    muestraErrorLogin(mensaje) {
        // Buscamos el componente en el DOM y le seteamos el atributo
        const componente = document.querySelector('login-component');
        if (componente) {
            componente.setAttribute('error-msg', mensaje);
            }
        }
    }
