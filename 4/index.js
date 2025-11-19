document.getElementById('login').addEventListener('submit', function(event) {
  fetch('login.php', {
    method: 'POST',
    body: new FormData(event.target)
  }).then(response => response.text()).then(data => {
    console.log(data);
  })
});