export default () => {
  const menuBtn = document.querySelector('#menu');
  const menu = document.querySelector('.menu');
  menuBtn.addEventListener('click', (e)=> {
    e.preventDefault();
  
   
    menu.classList.toggle('menu-active');

  });
  menu.addEventListener('click', (e)=> {
    e.preventDefault();
    menu.classList.remove('menu-active');
  }) ;
}