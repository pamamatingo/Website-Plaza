// vacancy-form.js

// Validación del formulario de vacantes
const form = document.getElementById('vacancy-form');

if (form) {
    form.addEventListener('submit', (e) => {
        const positionInput = document.getElementById('position');
        const cvInput = document.getElementById('cv');

        const position = positionInput ? positionInput.value.trim() : '';
        const cv = cvInput ? cvInput.files[0] : null;

        if (!position || !cv) {
            e.preventDefault();
            alert('Por favor, completa todos los campos y adjunta tu CV.');
        }
    });
}
