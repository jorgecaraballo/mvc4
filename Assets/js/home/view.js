class View extends Vista {
    constructor(controlador) {
        super(controlador);
    }
    
    muestraVisitas(o) {
        if (o && o.status && o.data && o.data.visitas !== undefined) {
            const footer = document.querySelector('footer.landing-footer');
            if (footer) {
                const badge = document.createElement('div');
                badge.className = 'visitas-badge';
                badge.innerHTML = `👁️ Visitas: <strong>${o.data.visitas}</strong>`;
                footer.appendChild(badge);
            }
        }
    }
}
