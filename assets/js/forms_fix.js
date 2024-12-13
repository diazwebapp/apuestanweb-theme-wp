document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('aw_login_form');
  form.addEventListener('submit', function(event) {
      event.preventDefault();
      
      const formData = new FormData(form);
      formData.append('action', 'aw_login_action');
      
      fetch(aw_login_params.ajaxurl, {
          method: 'POST',
          body: formData
      })
      .then(response => response.json())
      .then(data => {
          if (data.success) {
              window.location.href = data.redirect_url;
          } else {
              const notification = document.getElementById('notification');
              notification.innerHTML = data.data;
              notification.style.display = 'block';
          }
      })
      .catch(error => console.error('Error:', error));
  });
});
