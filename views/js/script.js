function getCiudades() {
  let departamento = document.getElementById("departamento").value;
  let ciudadDropdown = document.getElementById("ciudad");

  // Limpiar el dropdown de ciudades
  ciudadDropdown.innerHTML = '<option value="" disabled selected>Selecciona una ciudad</option>';

  // Llamar a la API para obtener las ciudades del departamento seleccionado
  fetch(`https://www.datos.gov.co/resource/xdk5-pm3f.json?departamento=${departamento}`)
    .then(response => response.json())
    .then(data => {
      data.forEach(ciudad => {
        let option = document.createElement("option");
        option.text = ciudad.municipio;
        option.value = ciudad.municipio;
        ciudadDropdown.add(option);
      });
    })
    .catch(error => console.error('Error al obtener las ciudades:', error));
}

// Llenar el dropdown de departamentos al cargar la página
window.onload = function () {
  let departamentoDropdown = document.getElementById("departamento");

  fetch("https://www.datos.gov.co/resource/xdk5-pm3f.json?$query=SELECT%20distinct%20departamento%20ORDER%20BY%20departamento")
    .then(response => response.json())
    .then(data => {
      data.forEach(departamento => {
        let option = document.createElement("option");
        option.text = departamento.departamento;
        option.value = departamento.departamento;
        departamentoDropdown.add(option);
      });
    })
    .catch(error => console.error('Error al obtener los departamentos:', error));
}

function btn_go_back() {
  window.history.back();
}


document.addEventListener('DOMContentLoaded', function () {
  // Función toggleMenu
  function toggleMenu() {
    let menu = document.getElementById("menu");
    if (menu) {
      menu.style.display = (menu.style.display === "block") ? "none" : "block";
    } else {
      console.error('El elemento "menu" no existe en el DOM');
    }
  }

  // Swiper
  let swiper = new Swiper(".mySwiper", {
    slidesPerView: 1,
    spaceBetween: 80,
    grabCursor: true,
    loop: true,
    breakpoints: {
      991: {
        slidesPerView: 3
      }
    }
  });

  // Productos
  const productosLink = document.querySelector('nav.sidebar ul li:nth-child(5) a');
  const submenuProductos = document.getElementById('submenu-productos');

  if (productosLink && submenuProductos) {
    productosLink.addEventListener('click', function (event) {
      event.preventDefault();
      submenuProductos.style.display = (submenuProductos.style.display === 'none') ? 'block' : 'none';
    });
  } else {
    console.error('Los elementos para el submenu de productos no existen en el DOM');
  }

  // Carrusel
  const track = document.getElementById('track');
  const prevButton = document.getElementById('button-prev');
  const nextButton = document.getElementById('button-next');
  const slides = document.querySelectorAll('.slick');

  if (track && prevButton && nextButton && slides.length > 0) {
    const totalSlides = slides.length;
    let slideWidth = slides[0].offsetWidth;
    let currentIndex = 0;

    function moveCarousel(direction) {
      if (direction === 'next') {
        currentIndex = (currentIndex + 1) % totalSlides;
      } else if (direction === 'prev') {
        currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
      }
      const newPosition = currentIndex * slideWidth;
      track.style.transition = 'transform 0.5s ease';
      track.style.transform = `translateX(-${newPosition}px)`;
    }

    prevButton.addEventListener('click', function () {
      moveCarousel('prev');
    });

    nextButton.addEventListener('click', function () {
      moveCarousel('next');
    });

    window.addEventListener('resize', function () {
      slideWidth = slides[0].offsetWidth;
      track.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
    });
  } else {
    console.error('Elementos del carrusel no existen en el DOM o no hay slides');
  }
});

// funcion para barra de navegacion
document.addEventListener('DOMContentLoaded', function () {
    const navbar = document.querySelector('.navbar');
    
    window.addEventListener('scroll', function () {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });
});


// metodo de entrega

document.getElementById("editBtn").addEventListener("click", function () {
  document.getElementById("display-info").style.display = "none";
  document.getElementById("edit-form").style.display = "block";
});

document.getElementById("continueBtn").addEventListener("click", function () {
  alert("Continuar con el siguiente paso");
});

document.getElementById("edit-form").addEventListener("submit", function (e) {
  e.preventDefault();
  document.getElementById("direccionDisplay").innerText =
    document.getElementById("direccion").value;
  document.getElementById("edit-form").style.display = "none";
});



