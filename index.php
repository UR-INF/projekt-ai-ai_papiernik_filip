<html lang="en" dir="ltr">
   <head>
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
     <link rel="stylesheet" href="style.css">
     <meta charset="utf-8">
     <title>Zaloguj</title>
   </head>
   <body>
     <div class="hero">
        <div class="form-box" id="fb">
          <div class="button-box">
            <div id="btn"></div>
              <button type="button" class="toggle-btn" onclick = "login()">Login</button>
              <button type="button" class="toggle-btn" onclick = "register()">Zarejetruj się</button>
          </div>
          <form id = "login" class="input-group" action="login.php" method="postt">
            <input type="text"  class="input-value" placeholder="Login" required>
            <input type="password"  class="input-value" placeholder="Hasło" required>
            <button type="submit" class="sumbit-btn">Login</button>
          </form>
          <form id = "register" class="input-group" action="register.php" method="post">
            <input type="text" class="input-value" name="login" placeholder="Login" required>
            <input type="password" class="input-value" name="haslo" placeholder="Hasło" required>
            <input type="text" class="input-value" name="imie" placeholder="Imie" required>
            <input type="text" class="input-value" name="nazwisko" placeholder="Nazwisko" required>
            <input type="text" class="input-value" name="email" placeholder="E-mail" required>
            <input type="text" class="input-value" name="kraj" placeholder="Kraj" required>
            <input type="text" class="input-value" name="miasto" placeholder="Miasto" required>
            <input type="text" class="input-value" name="adres" placeholder="Adres" required>
            <button type="submit" class="sumbit-btn">Zarejestruj</button>
          </form>
     </div>
   </div>
   <script>
   var log = document.getElementById("login");
   var reg = document.getElementById("register");
   var btn = document.getElementById("btn");
   var fb = document.getElementById("fb");
   function register(){
     log.style.left = "-400px"
     reg.style.left = "50px"
     btn.style.left = "110px"
     fb.style.height = "740px"
   }
   function login(){
     log.style.left = "50px"
     reg.style.left = "450px"
     btn.style.left = "0"
     fb.style.height = "400px"
   }

   </script>
  </body>
 </html>
