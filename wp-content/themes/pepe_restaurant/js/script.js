const form = document.getElementById('reservation-form')
const alert = form.querySelector('.alert')
form.onsubmit = e => {
    e.preventDefault()
    form.classList.add('validated')
    alert.innerHTML = ''
    if(!form.elements.name.validity.valid) {
        alert.innerHTML = 'Name is invalid'
    }
    else if(!form.elements.email.validity.valid) {
        alert.innerHTML = 'Email is invalid'
    }
    else if(!form.elements.date.validity.valid) {
        alert.innerHTML = 'Date is invalid'
    }
    else if(!form.elements.time.validity.valid) {
        alert.innerHTML = 'Time is invalid'
    }
    else if(!form.elements.visitors_count.validity.valid) {
        alert.innerHTML = 'Visitors count is invalid'
    }
    if (alert.innerHTML) return
    let formData = new FormData()
    formData.append('action', 'save_reservation')
    formData.append('name', form.elements.name.value)
    formData.append('email', form.elements.email.value)
    formData.append('date', form.elements.date.value)
    formData.append('time', form.elements.time.value)
    formData.append('visitors_count', form.elements.visitors_count.value)
    fetch(form.action, {
        method: 'POST',
        body: formData
    })
        .then(response => response.text())
        .then(text => {
            console.log(text)
            form.innerHTML = "<h2><span>Thanks!</span><br><span>Спасибо!</span></h2>"
        })
}