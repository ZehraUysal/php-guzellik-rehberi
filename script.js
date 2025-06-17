document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("authModal");
    const loginButton = document.getElementById("loginButton");
    const closeModal = document.getElementById("closeModal");
    const registerSwitch = document.getElementById("registerSwitch");
    const loginSwitch = document.getElementById("loginSwitch");
    const loginForm = document.getElementById("loginForm");
    const registerForm = document.getElementById("registerForm");

    
    loginButton.addEventListener("click", () => {
        modal.style.display = "flex"; 
        loginForm.style.display = "block"; 
        registerForm.style.display = "none"; 
        clearErrors(); 
    });

    
    closeModal.addEventListener("click", () => {
        modal.style.display = "none"; 
    });

    
    registerSwitch.addEventListener("click", () => {
        loginForm.style.display = "none";
        registerForm.style.display = "block";
        clearErrors();
    });

    
    loginSwitch.addEventListener("click", () => {
        loginForm.style.display = "block";
        registerForm.style.display = "none";
        clearErrors();
    });

    
    function clearErrors() {
        document.querySelectorAll('.error').forEach(error => error.remove());
    }

    
    const errorLogin = new URLSearchParams(window.location.search).get('error_login');
    const errorRegister = new URLSearchParams(window.location.search).get('error_register');
    
    if (errorLogin || errorRegister) {
        modal.style.display = "flex"; 

        if (errorLogin) {
            const errorDiv = document.createElement('div');
            errorDiv.classList.add('error');
            errorDiv.innerHTML = errorLogin;
            loginForm.appendChild(errorDiv); 
            loginForm.style.display = "block";
            registerForm.style.display = "none";
        }

        if (errorRegister) {
            const errorDiv = document.createElement('div');
            errorDiv.classList.add('error');
            errorDiv.innerHTML = errorRegister;
            registerForm.appendChild(errorDiv); 
            registerForm.style.display = "block";
            loginForm.style.display = "none";
        }
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const favoriBtns = document.querySelectorAll('.favori-btn'); 

    favoriBtns.forEach(function (button) {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            const id = button.getAttribute('data-id'); 
            const type = button.getAttribute('data-type'); 
            const action = button.classList.contains('active') ? 'remove' : 'add'; 

            
            fetch("favori_islem.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    id: id,
                    type: type,  
                    action: action  
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    
                    if (data.action === 'add') {
                        button.classList.add('active');
                        button.textContent = 'Favorilerden Çıkar';
                    } else if (data.action === 'remove') {
                        button.classList.remove('active');
                        button.textContent = 'Favorilere Ekle';
                    }
                } else {
                    alert("Hata: " + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
});


document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector(".konu-ekle-form");

    form.addEventListener("submit", function (e) {
        e.preventDefault(); 

        const formData = new FormData(form); 

        fetch("konu_ekle.php", {
            method: "POST",
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                window.location.href = "forum.php?success_konu=Yeni konu başarıyla eklendi!"; 
            } else {
                alert("Hata: " + data.message);
            }
        })
        .catch(error => {
            console.error("Hata oluştu:", error);
            alert("Beklenmedik bir hata oluştu.");
        });
    });
});















