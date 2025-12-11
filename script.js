// Pettomets - Main JavaScript file

// Form submission handler for forms with class 'joinForm'
document.addEventListener('DOMContentLoaded', function() {
    const joinForm = document.querySelector('.joinForm');
    
    if (joinForm) {
        joinForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = new FormData(joinForm);
            const data = Object.fromEntries(formData);
            
            // In a real application, this would send data to a server
            console.log('Form submitted:', data);
            
            // Show success message
            alert('Thank you for your interest! We will contact you soon.');
            
            // Reset form
            joinForm.reset();
        });
    }
});
