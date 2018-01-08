  var hamburger = document.querySelector(".hamburger");
  
  hamburger.addEventListener("click", function() {
    
      hamburger.classList.toggle("is-active");
      
      $('#mobile-nav').fadeToggle();
      
  });
