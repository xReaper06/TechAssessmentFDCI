$(document).ready(function () {
    $('.navlink-main').removeClass('active')
    $('.navlink-add').addClass('active')

    $('#add-btn').on('click', function () {
        addContact();
    })
})

const addContact = () => {
    if ($('#name').val() == '' || $('#company').val() == '' || $('#phone').val() == '' || $('#email').val() == '') {
        alert('Please Fill in Empty Fields')
    } else {
        try {

            let formData = {
                method: 'Add',
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
    }

}