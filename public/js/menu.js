// Liste des liens du menu
const menuItems = [
    { name: "Dashboard", link: "index.html", icon: "bx-dashboard" },
    { name: "Utilisateurs", link: "users.html", icon: "bx-user-detail" },
    { name: "Réservations", link: "reservations.html", icon: "bx-calendar-check" }, // <-- AJOUTÉ
    { name: "Ressources", link: "resources.html", icon: "bx-server" },
    { name: "Catégories", link: "categories.html", icon: "bx-category" },
    { name: "Maintenance", link: "maintenance.html", icon: "bx-calendar-exclamation" },
    { name: "Logs / Journal", link: "logs.html", icon: "bx-file-find" },
    { name: "Mon Profil", link: "profile.html", icon: "bx-cog" }
];

const menuContainer = document.getElementById('menu');
const currentPage = window.location.pathname.split("/").pop() || "index.html";

if (menuContainer) {
    menuItems.forEach(item => {
        let isActive = (currentPage === item.link) ? 
            'style="background: rgba(46, 204, 113, 0.15); color: #2ecc71; border-left: 3px solid #2ecc71;"' : '';
        
        let li = `
            <li>
                <a href="${item.link}" ${isActive}>
                    <i class='bx ${item.icon}'></i> ${item.name}
                </a>
            </li>
        `;
        menuContainer.insertAdjacentHTML('beforeend', li);
    });
}