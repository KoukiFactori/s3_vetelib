const animalLinks = document.querySelectorAll('.animal-link');
const firstAnimal = document.querySelector('.animal-link');
let abortController;
console.log(firstAnimal.dataset.id);
let idChoosenAnimal=firstAnimal.dataset.id;
const deleteButton = document.querySelector('.delete');

animalLinks.forEach(link => {
    link.addEventListener('click', async (event) => {
        event.preventDefault();
        deleteButton.style.display = "block";

        if (abortController) {
            abortController.abort();
        }

        abortController = new AbortController();

        const data = await fetch("/mon_profil/animal/" + link.dataset.id, {
            signal: abortController.signal
        })
            .then(response => response.json());
        console.log(data.id);
        idChoosenAnimal= parseInt(data.id);
        console.log(idChoosenAnimal);
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

deleteButton.style.display = "none";

deleteButton.addEventListener('click', async (event) => {
    event.preventDefault();
    await fetch(`/mon_profil/animal/${idChoosenAnimal}/delete`)
        
});

function redirect() {
    window.location.href = '/mon_profil/animal/add';
}