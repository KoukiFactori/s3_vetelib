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
    });
});