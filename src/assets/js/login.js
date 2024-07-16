$(document).on('click', function () {

    $('#login-btn').on('click', function () {
        login();
    })
});

const login = () => {
    const email = $('#login-email').val()
    const password = $('#login-password').val()
    if (email == '' || password == '') {
        alert('Please Fill in Empty fields')
    } else {
        try {

            const formData = {
                method: 'login',
                email: email,
                password: password
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