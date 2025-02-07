<?php 
  // Démarrer la session
  session_start();
  if (!isset($_SESSION['user'])) {
      // Si l'utilisateur n'est pas connecté, redirection vers la page de connexion
      header("location:index.php");
  }
  $user = $_SESSION['user']; // Email de l'utilisateur connecté
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Chat | <?= $user ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <style>
    #chat3 .form-control {
      border-color: transparent;
    }

    #chat3 .form-control:focus {
      border-color: transparent;
      box-shadow: inset 0px 0px 0px 1px transparent;
    }

    .badge-dot {
      border-radius: 50%;
      height: 10px;
      width: 10px;
      margin-left: 2.9rem;
      margin-top: -.75rem;
    }

    section {
      background-color: #CDC4F9;
    }

    .card {
      border-radius: 15px;
    }
  </style>
</head>

<body>

<section>
  <div class="container py-5">
    <div class="row">
      <div class="col-md-12">
        <div class="card" id="chat3">

          <!-- Section de l'utilisateur connecté -->
          <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Bonjour, <?= $user ?> !</h5>
              <a href="deconnexion.php" class="btn btn-danger">Déconnexion</a>
            </div>
          </div>

          <div class="card-body">
            <div class="row">
              <!-- Liste des utilisateurs -->
              <div class="col-md-6 col-lg-5 col-xl-4 mb-4 mb-md-0">
                <div class="p-3">
                  <h6>Conversations</h6>
                  <div class="input-group rounded mb-3">
                    <input type="search" class="form-control rounded" placeholder="Rechercher un utilisateur" />
                    <span class="input-group-text border-0">
                      <i class="fas fa-search"></i>
                    </span>
                  </div>

                  <div data-mdb-perfect-scrollbar-init style="position: relative; height: 400px">
                    <ul class="list-unstyled mb-0">
                      <?php 
                      // Connexion à la base de données
                      include("connexion_bdd.php");

                      // Récupération des utilisateurs
                      $req = mysqli_query($con, "SELECT email FROM users WHERE email != '$user'");
                      if (mysqli_num_rows($req) > 0) {
                          while ($row = mysqli_fetch_assoc($req)) {
                              ?>
                              <li class="p-2 border-bottom">
                                <a href="chat.php?user=<?= $row['email'] ?>" class="d-flex justify-content-between">
                                  <div class="d-flex flex-row">
                                    <div>
                                      <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
                                           alt="avatar" class="d-flex align-self-center me-3" width="60">
                                    </div>
                                    <div class="pt-1">
                                      <p class="fw-bold mb-0"><?= $row['email'] ?></p>
                                      <p class="small text-muted">Cliquez pour discuter</p>
                                    </div>
                                  </div>
                                </a>
                              </li>
                              <?php
                          }
                      } else {
                          echo "<li>Aucun utilisateur trouvé.</li>";
                      }
                      ?>
                    </ul>
                  </div>
                </div>
              </div>

              <!-- Section des messages -->
              <div class="col-md-6 col-lg-7 col-xl-8">
                <div class="pt-3 pe-3" data-mdb-perfect-scrollbar-init style="position: relative; height: 400px">
                  <h6>Messages</h6>
                  <div id="messages_box">
                    Chargement...
                  </div>
                </div>
                <form action="" class="mt-3" method="POST">
                  <div class="input-group">
                    <textarea name="message" class="form-control" rows="2" placeholder="Votre message"></textarea>
                    <button type="submit" name="send" class="btn btn-primary">Envoyer</button>
                  </div>
                </form>
                <?php
                if (isset($_POST['send'])) {
                    $message = $_POST['message'];
                    $receiver = $_GET['user'] ?? null;
                    if ($receiver && $message != "") {
                        $req = mysqli_query($con, "INSERT INTO messages VALUES (NULL, '$user', '$receiver', '$message', NOW())");
                        if ($req) {
                            header("Location: chat.php?user=$receiver");
                        }
                    }
                }
                ?>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  var messages_box = document.getElementById('messages_box');
  setInterval(function () {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
      if (this.readyState === 4 && this.status === 200) {
        messages_box.innerHTML = this.responseText;
      }
    };
    var receiver = "<?= $_GET['user'] ?? '' ?>";
    xhttp.open("GET", "messages.php?receiver=" + receiver, true);
    xhttp.send();
  }, 1000);
</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js"></script>
</body>

</html>
