document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const mainNav = document.querySelector('.main-nav');
    
    if (mobileMenuToggle && mainNav) {
        mobileMenuToggle.addEventListener('click', function() {
            mainNav.classList.toggle('active');
        });
    }
    
    // Dropdown menu for mobile
    const dropdowns = document.querySelectorAll('.dropdown');
    
    dropdowns.forEach(dropdown => {
        const link = dropdown.querySelector('a');
        
        link.addEventListener('click', function(e) {
            // Only apply this behavior on mobile
            if (window.innerWidth <= 768) {
                e.preventDefault();
                dropdown.classList.toggle('active');
            }
        });
    });
    
    // Quantity input in cart
    const quantityInputs = document.querySelectorAll('.quantity-input');
    
    quantityInputs.forEach(input => {
        input.addEventListener('change', function() {
            const form = this.closest('form');
            if (form) {
                form.submit();
            }
        });
    });
    
    // Form validation
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const requiredInputs = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredInputs.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                    input.classList.add('error');
                } else {
                    input.classList.remove('error');
                }
            });
            
            // Password confirmation validation
            const password = form.querySelector('input[name="password"]');
            const confirmPassword = form.querySelector('input[name="confirm_password"]');
            
            if (password && confirmPassword) {
                if (password.value !== confirmPassword.value) {
                    isValid = false;
                    confirmPassword.classList.add('error');
                    
                    // Create or update error message
                    let errorMsg = confirmPassword.nextElementSibling;
                    if (!errorMsg || !errorMsg.classList.contains('password-error')) {
                        errorMsg = document.createElement('p');
                        errorMsg.classList.add('password-error', 'text-danger');
                        confirmPassword.parentNode.appendChild(errorMsg);
                    }
                    
                    errorMsg.textContent = 'Les mots de passe ne correspondent pas.';
                } else {
                    const errorMsg = confirmPassword.nextElementSibling;
                    if (errorMsg && errorMsg.classList.contains('password-error')) {
                        errorMsg.remove();
                    }
                }
            }
            
            if (!isValid) {
                e.preventDefault();
            }
        });
    });
    
    // Add film to cart animation
    const addToCartBtns = document.querySelectorAll('.add-to-cart-btn');
    
    addToCartBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const filmCard = this.closest('.film-card') || this.closest('.film-info-detail');
            
            if (filmCard) {
                // Visual feedback
                btn.textContent = 'Ajouté !';
                setTimeout(() => {
                    btn.textContent = 'Ajouter au panier';
                }, 2000);
            }
        });
    });
});