class View extends Vista {
    constructor(controlador) {
        super(controlador);
    }
    
    muestraVisitas(cantidad) {
        // Aquí buscas el elemento en el DOM y le insertas la cantidad
        console.log("Visitas:", cantidad);
    }

    muestraVisitas(o) {
        if (o && o.status && o.data && o.data.visitas !== undefined) {
            // Buscamos el footer público
            const footer = document.querySelector('footer.landing-footer');
            
            if (footer) {
                // Creamos el contenedor con la misma clase que ya teníamos
                const badge = document.createElement('div');
                badge.className = 'visitas-badge';
                badge.innerHTML = `👁️ Visitas: <strong>${o.data.visitas}</strong>`;
                
                // Lo agregamos al final del footer
                footer.appendChild(badge);
            }
        }
    }

}
