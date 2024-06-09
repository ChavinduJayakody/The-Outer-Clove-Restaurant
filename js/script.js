document.addEventListener('DOMContentLoaded', function () {
    const header = document.querySelector("header");
    const menu = document.querySelector('#menu-icon');
    const navlist = document.querySelector('.navlist');
  
    window.addEventListener("scroll", function () {
      header.classList.toggle("sticky", window.scrollY > 80);
    });
  
    menu.onclick = () => {
      menu.classList.toggle('bx-x');
      navlist.classList.toggle('open');
    };
  
    window.onscroll = () => {
      menu.classList.remove('bx-x');
      navlist.classList.remove('open');
    };
  
    ScrollReveal().reveal('.background-container', {
      duration: 1000,
      delay: 200,
      origin: 'bottom',
      distance: '50px',
      easing: 'ease-in-out',
      reset: true,
    });
  
    ScrollReveal().reveal('.icon-container-box', {
      duration: 1000,
      delay: 200,
      origin: 'bottom',
      distance: '50px',
      easing: 'ease-in-out',
      reset: true,
    });
  
    ScrollReveal().reveal('.about-img', {
      duration: 1000,
      delay: 200,
      origin: 'top',
      distance: '50px',
      easing: 'ease-in-out',
      reset: true,
    });
  
    ScrollReveal().reveal('.about-text', {
      duration: 1000,
      delay: 200,
      origin: 'right',
      distance: '50px',
      easing: 'ease-in-out',
      reset: true,
    });
  
    ScrollReveal().reveal('.shop', {
      duration: 1000,
      delay: 200,
      origin: 'top',
      distance: '50px',
      easing: 'ease-in-out',
      reset: true,
    });
  
    // login
document.addEventListener("DOMContentLoaded", function () {
    const forms = document.querySelector(".forms"),
      pwShowHide = document.querySelectorAll(".eye-icon"),
      links = document.querySelectorAll(".link");
  
    pwShowHide.forEach(eyeIcon => {
      eyeIcon.addEventListener("click", () => {
        let pwFields = eyeIcon.parentElement.parentElement.querySelectorAll(".password");
  
        pwFields.forEach(password => {
          if (password.type === "password") {
            password.type = "text";
            eyeIcon.classList.replace("bx-hide", "bx-show");
            return;
          }
          password.type = "password";
          eyeIcon.classList.replace("bs-show", "bx-hide");
        });
      });
    });
  
    links.forEach(link => {
      link.addEventListener("click", e => {
        e.preventDefault(); 
        forms.classList.toggle("show-signup");
      });
      link.addEventListener("mouseenter", () => {
        link.style.textDecoration = "underline";
    });

        link.addEventListener("mouseleave", () => {
            link.style.textDecoration = "none";
    });
    });
  });
});


