const animalLinks = document.querySelectorAll('.animal-link');
const firstAnimal = document.querySelector('.animal-link');
fetch("/client/animals/" + firstAnimal.dataset.id);
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
        const id = data.id;

        const birthday = new Date(data.birthdate);
        const age = (new Date().getFullYear() - birthday.getFullYear());
        document.querySelector(".name").innerText = data.name
        document.querySelector(".species").innerText = data.espece.name
        document.querySelector(".birthdate").innerText = birthday.toLocaleDateString('fr-FR', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });
        document.querySelector(".age").innerText = age.toLocaleString('fr-FR', {
            year: 'numeric'
        });
        const appointments = document.querySelector(".appointments");
        while (appointments.firstChild) appointments.removeChild(appointments.firstChild)
        for (const event of data.events) {
            const dateEvent = new Date(event.date).toLocaleDateString('fr-FR', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });;
            const element = document.createElement("li");
            element.innerHTML = `
            <p>${event.description}</p>
            <p>${dateEvent}
            `;
            appointments.appendChild(element);
        }

    })
});

const deleteButton = document.querySelectorAll('.delete');

deleteButton.addEventListener('click', async (event) => {
    event.preventDefault();
    await fetch(`/mon_profil/animal/${id}/delete`)
        
});

window.loca


