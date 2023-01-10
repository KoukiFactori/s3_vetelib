const appointmentLinks = document.querySelectorAll('.animal-link');
let abortController;

appointmentLinks.forEach(link => {
    link.addEventListener('click', async (event) => { 
        event.preventDefault();

        if (abortController) {
            abortController.abort();
        }

        abortController = new AbortController();
        const data = await fetch("/mon_profil/rdv/" + link.dataset.id, {
            signal: abortController.signal
        })
            .then(response => response.json());
            const appointmentDate = new Date(data.date)
            document.querySelector(".date").innerText = appointmentDate.toLocaleDateString('fr-FR', {
                day: 'numeric',
                month: 'long',
                year: 'numeric',
                hours: 'numeric',
                minutes: 'numeric',
            });
            document.querySelector(".name").innerText = data.animal.name
            document.querySelector(".species").innerText = data.animal.espece.name
            document.querySelector(".rdv").innerText = data.description
    });
});