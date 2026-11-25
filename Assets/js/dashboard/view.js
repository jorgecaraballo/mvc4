class View extends Vista {
	constructor() {
		super();
        this.menuToggle = document.getElementById('menuToggle');
        this.sidebar = document.getElementById('sidebar');
		}
    escuchadorMenuToggle = () => {
        this.menuToggle.addEventListener('click', () => {
            this.sidebar.classList.toggle('active');
            });
        };
    }
