const queryString = window.location.search;

const urlParams = new URLSearchParams(queryString);

const contactId = urlParams.get('id');

console.log(contactId); // Outputs: 123


$(document).ready(function () {
    $.post('./src/routes/index.php', { method: 'getSpecificData', id: contactId }, function (data, status) {
        let parsedData = JSON.parse(data);
        $('#name').val(parsedData.data.name)
        $('#company').val(parsedData.data.company)
        $('#phone').val(parsedData.data.phone)
        $('#email').val(parsedData.data.email)
    })
})

$(document).on('click', '#update-btn', function () {
    try {
        let formData = {
            method: 'Edit',
            id: contactId,
            name: $('#name').val(),
            company: $('#company').val(),
            phone: $('#phone').val(),
            email: $('#email').val()
        }
        $.post('./src/routes/index.php', formData, function (data, status) {
            let parsedData = JSON.parse(data)
            if (parsedData.status == 'Error') {
                alert(parsedData.message)
            } else {
                alert(parsedData.message)
                location.href = "./contact.php"
            }
        })
    } catch (error) {
        console.log(error)
    }
})