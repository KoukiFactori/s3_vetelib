const appointmentLinks = document.querySelectorAll('.appointment-link');
const deleteButton = document.querySelector('.delete');
let idChoosenAppointment;
let abortController;
console.log(appointmentLinks);

appointmentLinks.forEach(link => {
    link.addEventListener('click', async (event) => { 
        event.preventDefault();
        deleteButton.style.display = "block";

        if (abortController) {
            abortController.abort();
        }

        abortController = new AbortController();
        const data = await fetch("/mon_profil/rdv/" + link.dataset.id, {
            signal: abortController.signal
        })
            .then(response => response.json());
            idChoosenAppointment= parseInt(data.id);
            const appointmentDate = new Date(data.date)
            document.querySelector(".date").innerText = appointmentDate.toLocaleDateString('fr-FR', {
                day: 'numeric',
                month: 'long',
                year: 'numeric',
                hours: 'numeric',
                minutes: 'numeric',
            });
            document.querySelector(".name_Vete").innerText =`Dr ${ data.veterinaire.lastname }${ data.veterinaire.firstname}`
            document.querySelector(".name").innerText = data.animal.name
            document.querySelector(".species").innerText = data.animal.espece.name
            document.querySelector(".rdv").innerText = data.description
    });
});

deleteButton.style.display = "none";

deleteButton.addEventListener('click', async (event) => {
    event.preventDefault();
    await fetch(`/mon_profil/rdv/${idChoosenAnimal}/delete`)
    location.reload();   
});
function redirect() {
    window.location.href = '/prendre-rdv';
}