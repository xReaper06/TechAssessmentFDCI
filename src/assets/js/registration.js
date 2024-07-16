$(document).ready(function () {

    $('#reg-btn').on('click', function () {
        Register();
    })

});

const Register = () => {
    const name = $('#registration-name').val()
    const email = $('#registration-email').val()
    const password = $('#registration-password').val()
    const confirmpassword = $('#registration-confirmpassword').val()

    if (name == '' || email == '' || password == '' || confirmpassword == '') {
        alert('Please Fill in Empty Spaces')
    } else {
        if (password != confirmpassword) {
            alert('Password is not Match')
        } else {
            handleRegistration(name, email, password)
        }
    }

}
const handleRegistration = (dataname, dataemail, datapassword) => {
    try {
        const formData = {
            method: 'register',
            name: dataname,
            email: dataemail,
            password: datapassword
        }
        $.post('./src/routes/index.php', formData, function (data, status) {
            parsedData = JSON.parse(data);
            if (data.status === 'Error') {
                $('#error-message').text(data.message)
            } else {
                location.href = "./thankyou.php"
            }
        })
    } catch (error) {
        console.log(error)
    }
}