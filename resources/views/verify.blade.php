<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Gracjan Krawiec - Panel logowania</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <link href="{{ URL::asset('css/form_index.css') }}" rel="stylesheet">
    </head>

    <body>

        <div class="row align-items-center center-xs formMainWrap">
          <div class="formsWrapper row" >
            <div class="login_form col-xs-12 col-sm-6 col-md-6">
                <div class="formWrap">
                  <h2>Zaloguj się</h2>
                  <p>Jeśli stworzyłeś konto to ta opcja jest dla Ciebie</p>
                  <form class="" action="/" method="post">
                    @csrf
                    <label for="email">Adres email</label>
                    <input type="email" name="email" value="">
                    <label for="pass">Hasło</label>
                    <input type="password" name="pass" value="">
                    <input type="submit" class="button" name="login" value="Zaloguj">
                  </form>
                </div>
            </div>


            <!-- PHP REGISTER  -->
            <?php

            if (isset($_POST['register'])) {

              $email = $_POST['reg-email'];


              if (!empty($email)) {
                if ($_POST['reg-pass'] == $_POST['reg-repass']) {
                    $password = md5($_POST['reg-pass']);

                    if ($password) {
                      $subject = "Wiadomość z kodem werfikacyjnym";
                      $tokens = bin2hex(openssl_random_pseudo_bytes(2));

                      $sendMail = mail($email, "$subject", $tokens);




                        ?>
                          <div class="verifiBox">
                            <h2>Wprowadź poniżej otrzymany kod.</h2>
                            <form  action="" method="post">
                              @csrf
                              <input type="text" name="code" value="">
                              <?php
                                echo $tokens;
                              if (isset($tokenError)) {
                                ?>
                                  <p class="error"><?php echo $tokenError;?></p>
                                <?php
                              }else{}
                              ?>
                              <input type="submit" class="button" name="verification" value="Werfikuj">
                            </form>
                          </div>

                        <?php




                    }
                    else{}


                }else{
                  $regErMsg = 'Podane Hasła nie są takie same';
                }
              }else{
                $regErMsg = 'Podaj adres e-mail';
              }
            }else{}



            ?>

            <div class="register_form col-xs-12 col-sm-6 col-md-6">
              <div class="formWrap">
                <h2>Zarejestruj się</h2>
                <p>Jeśli nie posiadasz konta możesz je stworzyć całkowicie za darmo</p>
                <form class="" action="/" method="post">
                  @csrf
                  <label for="email">Adres email</label>
                  <input type="email" name="reg-email" value="">
                  <label for="pass">Hasło</label>
                  <input type="password" name="reg-pass" value="">
                  <label for="repass">Powtórz hasło</label>
                  <input type="password" name="reg-repass" value="">
                  <?php
                  if (isset($regErMsg)) {
                    ?>
                      <p class="error"><?php echo $regErMsg;?></p>
                    <?php
                  }else{}
                  ?>
                  <input type="submit" class="button" name="register" value="Utwórz konto">
                </form>
              </div>
            </div>
          </div>

        </div>

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    </body>
</html>
