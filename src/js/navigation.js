export default () => {

  const menu = document.querySelector(".menu");
  menu.addEventListener('click', (e)=> {
    e.preventDefault();
    const id = e.target.getAttribute('href');
    const scrollTarget = document.querySelector(id);

    const topOffset = 50;
  
    const elementPosition = scrollTarget.getBoundingClientRect().top;
    const offsetPosition = elementPosition - topOffset;

    window.scrollBy({
        top: offsetPosition,
        behavior: 'smooth'
    });
  })
}