import Swiper from "https://unpkg.com/swiper@8/swiper-bundle.esm.browser.min.js";

const changeSwiper = (swiper) => {
  if (document.documentElement.clientWidth < 800 && document.documentElement.clientWidth > 500) {
    swiper.params.slidesPerView = 2;
    swiper.update();
  } 
  else if(document.documentElement.clientWidth <= 500)  {
    swiper.params.slidesPerView = 1;
    swiper.update();
  }
  else {
    swiper.params.slidesPerView = 3;
    swiper.update();
  }
 
}
export default () => {
  new Swiper(".swiperProjects", {
    // Optional parameters

    loop: true,

    // If we need pagination

    // Navigation arrows
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },

    // And if we need scrollbar
    scrollbar: {
      el: ".swiper-scrollbar",
    },
  });
  new Swiper(".swiperTeam", {
    // Optional parameters

    loop: true,

    autoplay: {
      delay: 3500,
      disableOnInteraction: false,
    },
    effect: "fade",
  });
  const swiper = new Swiper(".swiperAboutTeam", {
    slidesPerView: 3,
    spaceBetween: 30,
    freeMode: true,
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    

    autoplay: {
      delay: 10500,
      disableOnInteraction: false,
    },
   
  });
  window.addEventListener('resize', (e)=> {
    changeSwiper(swiper);
  })
  changeSwiper(swiper);
  
};
