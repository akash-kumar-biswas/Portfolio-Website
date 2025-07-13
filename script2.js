  const scriptURL = 'https://script.google.com/macros/s/AKfycbzIsmg_kOXf2luGxs8SQs2GBI4bL5srmBMjWveZQcUgOLT4oeygOZME9PG1yF_TkRvP/exec';
  const form = document.forms['submit-to-google-sheet'];
  const successMsg = document.querySelector('.form-message');
  const errorMsg = document.querySelector('.form-error');

  successMsg.style.display = 'none';
  errorMsg.style.display = 'none';

  form.addEventListener('submit', e => {
    e.preventDefault();
    fetch(scriptURL, { method: 'POST', body: new FormData(form) })
      .then(response => {
        if (response.ok) {
          successMsg.style.display = 'inline-flex';
          errorMsg.style.display = 'none';
          form.reset();

          setTimeout(() => {
            successMsg.style.display = 'none';
          }, 3000);
        } else {
          throw new Error('Response not OK');
        }
      })
      .catch(error => {
        successMsg.style.display = 'none';
        errorMsg.style.display = 'inline-flex';

        setTimeout(() => {
          errorMsg.style.display = 'none';
        }, 5000);

        console.error('Error!', error.message);
      });
  });