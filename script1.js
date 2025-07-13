  const menuIcon = document.getElementById('menu-icon');
  const closeIcon = document.getElementById('close-icon');
  const navLinks = document.getElementById('navLinks');

  menuIcon.addEventListener('click', () => {
    navLinks.classList.add('show');
  });

  closeIcon.addEventListener('click', () => {
    navLinks.classList.remove('show');
  });