const scriptURL = '' //your sheets script url here
  const form = document.forms['application-form'];

  let res;
  form.addEventListener('submit', e => {
    e.preventDefault()
    $('#submit-btn').addClass('d-none');
    document.getElementById('wait').classList.remove('d-none');
      
    fetch(scriptURL, { method: 'POST', body: new FormData(form)})
      .then(response => {
        res = response;

        console.log('Success!', response)
        
    })
      .catch(error => {
        console.error('Error!', error.message)
        $('#fail').removeClass('d-none'); 
        $('#success').addClass('d-none');
    })
      setTimeout(successs,5000) 
  })
function successs() {
    $('#success').removeClass('d-none');
    $('#wait').addClass('d-none');
    if(res.status !== 200){
            $('#success').addClass('d-none');
            $('#fail').removeClass('d-none'); ;
    }
}