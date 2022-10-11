<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Gracjan Krawiec - Panel logowania</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <link href="{{ URL::asset('css/form_index.css') }}" rel="stylesheet">
    </head>

    <body>

  <!-- PHP LOGIN  -->
  <?php
// Dzień dobry, witam w moim kodzie, na początek wiem że to się nie trzyma w ogóle założeń i modelu MVC oraz wiem,
// że nie jest idealnym kodem (uczę się, wcześniej pisałem tylko wygląd stron i miałem troche zadań z php ale czegoś takiego nie robiłem) tyle wstępem a teraz kod.
// Użyłem laravela ponieważ miałem problemy z instalacją phalcona ale z tego co patrzyłem to tez MVC.
// poniżej mamy kod logowania (bez sesji oraz przechodzenia do innych stron),


    if (isset($_POST['login'])) {
      if (!empty($_POST['email']) && !empty($_POST['pass'])) {

        $email = $_POST['email'];
        $pass = md5($_POST['pass']);

        // wybiera pasującego usera do emaila i hasła
        $users = DB::table('users')->where('email', $email)->get();
        $users = DB::table('users')->where('password', $pass)->get();

        // jak wszystko ok to pokazuje się nam jakże urokliwy poniższy komunikat
        ?>

          <div class="SukcesLogin">

            <h2>Witaj użytkowniku o emailu:<?php foreach ($users as $dataRow) {echo $dataRow->email;} ?></h2>
            <p>Właśnie zalogowałeś się do pustej strony, musisz być bardzo szczęśliwy skoro tak bardzo tu chciałeś być... Skoro widzisz że nic tu nie ma to po co zaglądać w kod? :D</p>
            <p>Nie ma przycisku wyloguj, zgadza się może i ukradłem, ale tylko głupi by nie skorzystał ;)</p>
          </div>

        <?php

      }else{}
    }else{}

   ?>
   <!-- Formularze na stronie -->
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
            // Kod do obsługi formularza rejestracji

            if (isset($_POST['register'])) {

              $email = $_POST['reg-email'];

            // Sprawdzamy czy email nie jest pusty, pózniej czy hasła są takie same
              if (!empty($email)) {
                if ($_POST['reg-pass'] == $_POST['reg-repass']) {
                    $password = md5($_POST['reg-pass']);

                    if ($password) {
                      $subject = "Wiadomość z kodem werfikacyjnym";

                      //To generuje nam kodzik do werfikacji który jest wysyłany mailem
                      $tokens = bin2hex(openssl_random_pseudo_bytes(2));


                      //Wysyłamy maila
                      $sendMail = mail($email, "$subject", $tokens);



                      //Poniżej okienko wyskakujące do wprowadzenia kodu
                        ?>
                          <div class="verifiBox">
                            <h2>Wprowadź poniżej otrzymany kod.</h2>
                            <form action=""  method="get">

                              <input type="text" name="code" maxlength="4" value="">
                              <?php

                              DB::table('users')->insert([
                                  'email' => $email,
                                  'password' => $password,
                                  'token' => $tokens,
                              ]);

                              //Pokazuje kod w wersji domyślnej należy usunąć
                                echo $tokens;

                                //Wyświetla ew. błedy
                              if (isset($tokenError)) {
                                ?>
                                  <p class="error"><?php echo $tokenError;?></p>
                                <?php
                              }else{}
                              ?>
                              <input type="submit" class="button" name="verific" value="Werfikuj">
                              <?php
                              if (isset($_POST['verific']) && $_GET['code'] == $tokens) {
                                //W tym ifie powinno być dodanie do BD usera oraz wyświetlenie kolejnego komunikatu



                                  ?>
                                    <div class="verifi_done">
                                        <h2>Gratulujemy werfikacja została zakończona pomyślnie</h2>
                                        <p>Dziękujemy za zaufanie, dopiero teraz logowanie staje się możliwe :D</p>
                                        <a href="/" class="button">Odśwież</a>
                                    </div>
                                  <?php


                              }else{}
                                ?>
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

        <!-- Scripts  -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    </body>
</html>
