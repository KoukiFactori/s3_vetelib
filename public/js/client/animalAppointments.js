const animalLinks = document.querySelectorAll('.animal-link')

let abortController;

animalLinks.forEach(link => {
    link.addEventListener('click', async (event) => {
        event.preventDefault();

        if (abortController) {
            abortController.abort();
        }

        abortController = new AbortController();

        const data = await fetch("/client/animals/" + link.dataset.id, {
            signal: abortController.signal
        })
            .then(response => response.json());

        const date = new Date(data.birthdate);
        document.querySelector(".name").innerText = data.name
        document.querySelector(".species").innerText = data.espece.name
        document.querySelector(".birthdate").innerText = date.toLocaleDateString('fr-FR', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });
    })
});