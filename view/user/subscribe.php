<div class="container">
    <div class="row">
    <div class="col-sm-6">
        <p onclick="showFormLogin();" class="para-login-sub">Déjà inscrit ?</p>
        <form id="formLogin" method="POST" action="/connexion/" class="d-none">
            <input type="hidden" name="login">
            <div class="form-group">
                <label for="user_login">Pseudo de connexion</label>
                <input type="text" class="form-control" id="user_login" name="user_login" placeholder="Pseudo de connexion" data-validation="length" data-validation-length="min3">
            </div>
            <div class="form-group">
                <label for="user_pwd">Password</label>
                <input type="password" class="form-control" id="user_pwd" name="user_pwd" placeholder="Mot de passe" data-validation="length" data-validation-length="min3">
            </div>
            <button type="submit" class="btn btn-primary">Se connecter</button>
        </form>
    </div>
        <div class="col-sm-6">
            <p onclick="showFormLogin();" class="para-login-sub d-none">Finalement, vous voulez créer un compte ?</p>
            <form id="formSub" action="" method="POST">
                <input type="hidden" name="new_sub">
                <div class="form-group">
                    <label for="sub_user_email">E-mail</label>
                    <input type="text" class="form-control" id="sub_user_email" name="sub_user_email" placeholder="Adresse e-mail" data-validation="email">
                </div>
                <div class="form-group">
                    <label for="sub_user_login">Login</label>
                    <input type="text" class="form-control" id="sub_user_login" name="sub_user_login" placeholder="Pseudo" data-validation="length" data-validation-length="min3">
                </div>
                <div class="form-group">
                    <label for="sub_user_pwd">Mot de passe</label>
                    <input type="password" class="form-control" id="sub_user_pwd" name="sub_user_pwd" placeholder="Mot de passe" data-validation="length" data-validation-length="min3">
                </div>
                <button type="submit" class="btn btn-primary">Créer le profil</button>
            </form>
        </div>
    </div>
</div>

<script>

    function showFormLogin() {
        // $('#modalLogin').modal('show');
        $('#formLogin').toggleClass('d-none');
        $('#formSub').toggleClass('d-none');
        $('.para-login-sub').toggleClass('d-none');
    }

    // function showFormSub() {
    //     // $('#modalLogin').modal('hide');
    //     $('#formSub').toggleClass('d-none');
    //     $('.para-login-sub').toggleClass('d-none');
    // }

    $(document).ready(function() {

        $.validate({
            lang: 'fr'
        });

    });



</script>