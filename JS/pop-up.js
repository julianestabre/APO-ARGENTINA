document.getElementById('contactForm').addEventListener('submit', async function (event) {
    event.preventDefault(); // Evitar el envío estándar del formulario

    const formData = new FormData(this);

    try {
        const response = await fetch('form/guardar_datos.php', {
            method: 'POST',
            body: formData,
        });

        // Verificar si la respuesta fue exitosa
        if (!response.ok) {
            throw new Error("Error al enviar los datos.");
        }

        // Mostrar el mensaje de éxito
        showSuccessMessage();

        // Restablecer el formulario (limpiar los campos)
        document.getElementById('contactForm').reset();
        
    } catch (error) {
        console.error("Error:", error);
        alert("Ocurrió un error. Inténtalo nuevamente.");
    }
});

function showSuccessMessage() {
    const overlay = document.getElementById('overlay');
    const messageDiv = document.getElementById('successMessage');

    // Mostrar el overlay y el mensaje con animación
    overlay.classList.add('visible');
    messageDiv.classList.add('visible');

    // Ocultar después de 4 segundos
    setTimeout(() => {
        overlay.classList.remove('visible');
        messageDiv.classList.remove('visible');
    }, 4000);
}
