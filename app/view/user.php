<?php
$showSuccess = 'none';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Inventory</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .edit-mode input {
            width: 100px;
        }
    </style>
</head>
<body class="container my-4">
<h1>Create a User</h1>

<?php if (isset($success) && $success): ?>
    <?php $showSuccess = 'block'; ?>
<?php endif; ?>
<div class="alert alert-success" style="display: <?= $showSuccess ?>;" role="alert">
    User successfully created!
</div>
<div class="alert alert-danger" style="display: none;" role="alert">
    Error!
</div>

<form class="row g-1 needs-validation" id="register-user" novalidate>
    <div class="col-md-6">
        <label for="firstName" class="form-label">First name</label>
        <input type="text" class="form-control" id="firstName" name="first_name" placeholder="First Name" required>
        <div class="valid-feedback">
            Looks good!
        </div>
    </div>
    <div class="col-md-6">
        <label for="lastName" class="form-label">Last name</label>
        <input type="text" class="form-control" id="lastName" name="last_name" placeholder="Last Name" required>
        <div class="valid-feedback">
            Looks good!
        </div>
    </div>
    <div class="col-md-6">
        <label for="email" class="form-label">E-mail</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
        <div class="invalid-feedback">
            Please provide a valid email.
        </div>
    </div>
    <div class="col-md-6">
        <label for="mobilePhone" class="form-label">Mobile Phone</label>
        <input type="text" class="form-control" id="mobilePhone" name="phone" placeholder="012345678" required>
        <div class="invalid-feedback">
            Please provide a valid Phone Number.
        </div>
    </div>
    <div class="col-md-12">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
        <div class="invalid-feedback">
            Please provide a Password.
        </div>
    </div>
    <div class="col-12">
        <button class="btn btn-primary" type="submit">Submit form</button>
    </div>
</form>
<hr>
<div id="home">
    <a class="btn btn-large btn-info" href="/<?php echo constant('URL_SUBFOLDER'); ?>">Home</a>
</div>
<script>
    (() => {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
    })()

    $(document).ready(function () {
        $("form").submit(function (event) {
            event.preventDefault();
            $.ajax({
                url: 'userPost', // Replace with your backend URL
                type: 'POST',
                data: $(this).serialize(), // Serialize form data
                success: function (response) {
                    const result = JSON.parse(response);
                    if (result.success) {
                        $('.alert-danger').hide();
                        $('.alert-success').show();
                        $('#register-user')[0].reset();
                    } else {
                        $('.alert-success').hide();
                        $('.alert-danger').text('Error: ' + result.message).show();
                    }
                },
                error: function (xhr, status, error) {
                    $('.alert-success').hide();
                    $('.alert-danger').text('Error: ' + xhr.responseText).show();
                }
            });

            event.preventDefault();
        });
    });
</script>
</body>
</html>
