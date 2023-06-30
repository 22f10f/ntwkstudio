function toggleMenu() {
  const burgerMenu = document.querySelector('.burger-menu');
  const mainMenu = document.querySelector('.main-menu');
  const hrElements = document.querySelectorAll('.animated-hr');

  burgerMenu.classList.toggle('active');
  mainMenu.style.top = burgerMenu.classList.contains('active') ? '0' : '-100%';

  hrElements.forEach(function(hr) {
    hr.classList.toggle('active');
  });

  const burgerMenuLines = document.querySelectorAll('.burger-menu-line');
  burgerMenuLines.forEach(function(line) {
    line.classList.toggle('reverse-animation'); 
  });
}


// Для прокручивания до контейнера с Преимуществами ?

  document.addEventListener("DOMContentLoaded", function() {
    const circleBlock = document.querySelector(".header-block-circle");
    const benefitsBlock = document.querySelector(".benefits");

    circleBlock.addEventListener("click", function() {
      scrollToElement(benefitsBlock, 1000); // Замедление на 10 секунд
    });

    function scrollToElement(element, duration) {
      const targetPosition = element.getBoundingClientRect().top;
      const startPosition = window.pageYOffset || document.documentElement.scrollTop;
      const distance = targetPosition - startPosition;
      let startTime = null;

      function scrollAnimation(currentTime) {
        if (startTime === null) {
          startTime = currentTime;
        }

        const elapsedTime = currentTime - startTime;
        const scrollProgress = easeInOutCubic(elapsedTime, startPosition, distance, duration);
        window.scrollTo(0, scrollProgress);

        if (elapsedTime < duration) {
          requestAnimationFrame(scrollAnimation);
        }
      }

      function easeInOutCubic(t, b, c, d) {
        t /= d / 2;
        if (t < 1) return c / 2 * t * t * t + b;
        t -= 2;
        return c / 2 * (t * t * t + 2) + b;
      }

      requestAnimationFrame(scrollAnimation);
    }
  });



document.addEventListener("DOMContentLoaded", function() {
  const fadeElements = document.querySelectorAll(".fade-in");

  function checkFadeElements() {
    fadeElements.forEach(function(element) {
      if (isElementInViewport(element)) {
        element.classList.add("visible");
      }
    });
  }

  function isElementInViewport(element) {
    const rect = element.getBoundingClientRect();
    return (
      rect.top >= 0 &&
      rect.left >= 0 &&
      rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
      rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
  }

  window.addEventListener("scroll", checkFadeElements);
  window.addEventListener("resize", checkFadeElements);

  checkFadeElements();
});


function changeColor() {
  var elements = document.querySelectorAll('*');
  for (var i = 0; i < elements.length; i++) {
    var element = elements[i];
    var currentColor = getComputedStyle(element).color;
    
    if (currentColor === 'rgb(0, 0, 0)') {
      element.style.color = 'white';
    } else if (currentColor === 'rgb(255, 255, 255)') {
      element.style.color = 'black';
    }
  }
  
  var body = document.querySelector('body');
  var currentBgColor = getComputedStyle(body).backgroundColor;
  if (currentBgColor === 'rgb(0, 0, 0)') {
    body.style.backgroundColor = 'white';
  } else if (currentBgColor === 'rgb(255, 255, 255)') {
    body.style.backgroundColor = 'black';
  }
}
