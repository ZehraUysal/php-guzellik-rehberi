//login-reg işlemleri
document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("authModal");
    const loginButton = document.getElementById("loginButton");
    const closeModal = document.getElementById("closeModal");
    const registerSwitch = document.getElementById("registerSwitch");
    const loginSwitch = document.getElementById("loginSwitch");
    const loginForm = document.getElementById("loginForm");
    const registerForm = document.getElementById("registerForm");

    // Modal açma
    loginButton.addEventListener("click", () => {
        modal.style.display = "flex"; // Modal'ı aç
        loginForm.style.display = "block"; // Giriş formunu göster
        registerForm.style.display = "none"; // Kayıt formunu gizle
        clearErrors(); // Hata mesajlarını temizle
    });

    // Modal kapama
    closeModal.addEventListener("click", () => {
        modal.style.display = "none"; // Modal'ı kapat
    });

    // Kayıt formuna geçiş
    registerSwitch.addEventListener("click", () => {
        loginForm.style.display = "none";
        registerForm.style.display = "block";
        clearErrors();
    });

    // Giriş formuna geçiş
    loginSwitch.addEventListener("click", () => {
        loginForm.style.display = "block";
        registerForm.style.display = "none";
        clearErrors();
    });

    // Hata mesajlarını temizleme fonksiyonu
    function clearErrors() {
        document.querySelectorAll('.error').forEach(error => error.remove());
    }

    // Hata mesajları varsa formu açık bırak
    const errorLogin = new URLSearchParams(window.location.search).get('error_login');
    const errorRegister = new URLSearchParams(window.location.search).get('error_register');
    
    if (errorLogin || errorRegister) {
        modal.style.display = "flex"; // Modal'ı açık bırak

        if (errorLogin) {
            const errorDiv = document.createElement('div');
            errorDiv.classList.add('error');
            errorDiv.innerHTML = errorLogin;
            loginForm.appendChild(errorDiv); // Giriş formunda hata mesajını göster
            loginForm.style.display = "block";
            registerForm.style.display = "none";
        }

        if (errorRegister) {
            const errorDiv = document.createElement('div');
            errorDiv.classList.add('error');
            errorDiv.innerHTML = errorRegister;
            registerForm.appendChild(errorDiv); // Kayıt formunda hata mesajını göster
            registerForm.style.display = "block";
            loginForm.style.display = "none";
        }
    }
});
// Favori butonuna tıklanıldığında çalışacak fonksiyon
document.addEventListener('DOMContentLoaded', function () {
    const favoriBtns = document.querySelectorAll('.favori-btn'); // Favori butonlarını seçiyoruz

    favoriBtns.forEach(function (button) {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            const id = button.getAttribute('data-id'); // id parametresi
            const type = button.getAttribute('data-type'); // type parametresi (sac_id, makyaj_id, cilt_id)
            const action = button.classList.contains('active') ? 'remove' : 'add'; // Eğer aktifse 'remove', değilse 'add'

            // AJAX isteği gönder
            fetch("favori_islem.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    id: id,
                    type: type,  // 'sac_id', 'makyaj_id', 'cilt_id' şeklinde gönderilmeli
                    action: action  // 'add' veya 'remove'
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Butonun durumunu güncelle
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

// konu ekle buton
document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector(".konu-ekle-form");

    form.addEventListener("submit", function (e) {
        e.preventDefault(); // Formun normal şekilde gönderilmesini engelle

        const formData = new FormData(form); // Form verilerini al

        fetch("konu_ekle.php", {
            method: "POST",
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                window.location.href = "forum.php?success_konu=Yeni konu başarıyla eklendi!"; // Yönlendir
            } else {
                alert("Hata: " + data.message); // Hata mesajını göster
            }
        })
        .catch(error => {
            console.error("Hata oluştu:", error);
            alert("Beklenmedik bir hata oluştu.");
        });
    });
});















