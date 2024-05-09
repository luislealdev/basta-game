      <?php
        if (isset($_GET['e']) && $_GET['e'] != 7) {
            header('location: /basta/app/auth/');
        }
        ?>

      <!DOCTYPE html>
      <html lang="en">

      <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <link rel="stylesheet" href="https://luisrrleal.com/styles/leal-styles.css">
          <link rel="stylesheet" href="../../public/global.css">
          <title>Email Sended</title>
      </head>

      <body>
          <main class="flex justify-content align-center center-text">
              <div>
                  <h1 class="f-size-70">Correo enviado</h1>
                  <p class="f-size-24">Se ha enviado un correo con tu contraseña a la dirección proporcionada</p>
                  <div class="mt-50">
                      <a href="/basta/app/auth/" class="p-10 radius no-border f-size-24 bg-primary white-text">Ingresar</a>
                  </div>
              </div>
          </main>
      </body>

      </html>