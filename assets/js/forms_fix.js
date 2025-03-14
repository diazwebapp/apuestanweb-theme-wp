document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('aw_login_form');

  form.addEventListener('submit', function(event) {
      event.preventDefault();
      
      const formData = new FormData(form);
      formData.append('action', 'aw_login_action');
      
      fetch(aw_login_params['ajaxurl'], {
          method: 'POST',
          body: formData
      })
      .then(response => response.json())
      .then(data => {
        console.log(data)
          if (data==0) {
            window.location.href = aw_login_params['redirect_url'];
            return
          } else {
              const notification = document.getElementById('notification');
              notification.innerHTML = data.data;
              notification.style.display = 'block';
          }
      })
      .catch(error => console.error('Error:', error));
  });
});
