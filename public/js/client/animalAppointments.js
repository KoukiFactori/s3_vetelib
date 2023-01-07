const animalLinks=document.querySelectorAll('.animal-link')

animalLinks.forEach(link=>{
    link.addEventListener('click',event =>{
        event.preventDefault();

        
        
        fetch("/client/animals/"+link.dataset.id,['credentials:include'])
        .then(response=>response.json())
        .then(data=>{
            document.querySelector(".name").innerText = data.name
        })
        console.log("fdp")
    })

})