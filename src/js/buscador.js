document.addEventListener('DOMContentLoaded', function(){
iniciarAPP();
});

function iniciarAPP(){
    buscarPorFecha();
}

function buscarPorFecha(){
    const inputFecha=document.querySelector('#fecha');
    console.log(inputFecha);
    inputFecha.addEventListener('input', function(){
        const fechaSeleccionada=inputFecha.value;
        console.log(fechaSeleccionada);
        window.location =`?fecha=${fechaSeleccionada}`;
    });
}
