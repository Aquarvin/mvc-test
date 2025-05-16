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
<?php if ($user): ?>
    <h1>Welcome <?= htmlspecialchars($user->getFirstName()); ?></h1>
<?php else: ?>
    <h1>Login a User</h1>
<?php endif; ?>
<div id="logout" class="col-md-2" style="display: <?= $user ? 'block' : 'none' ?>">
    <a class="btn btn-large btn-info" href="/<?php echo constant('URL_SUBFOLDER'); ?>/logoutPost">LOGOUT</a>
</div>

<?php if (isset($success) && $success): ?>
    <?php $showSuccess = 'block'; ?>
<?php endif; ?>
<div class="alert alert-success" style="display: <?= $showSuccess ?>;" role="alert">
    User successfully created!
</div>
<div class="alert alert-danger" style="display: none;" role="alert">
    Error!
</div>
<?php if (!$user): ?>
    <form id="login" class="row g-1 needs-validation">
        <div class="form-group col-md-12">
            <label for="email">Email address</label>
            <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email" placeholder="Enter email" required>
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group col-md-12">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
        </div>
        <div class="col-12">
            <button class="btn btn-primary" type="submit">Login</button>
        </div>
    </form>
<?php endif; ?>
<hr>
<div class="row">
    <div id="home" class="col-md-2">
        <a class="btn btn-large btn-info" href="/<?php echo constant('URL_SUBFOLDER'); ?>">Home</a>
    </div>
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
                url: 'loginPost', // Replace with your backend URL
                type: 'POST',
                data: $(this).serialize(), // Serialize form data
                success: function (response) {
                    const result = JSON.parse(response);
                    if (result.success) {
                        $('.alert-danger').hide();
                        $('.alert-success').text(result.message).show();
                        $('#login').hide();
                        $('#logout').show();
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
