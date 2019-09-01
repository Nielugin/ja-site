<?php 

    require('utilBDD.php');
    if (!empty($_POST)) {
        // Cas de la déconnexion
        if (isset($_POST['deconnect'])) {
            // remove all session variables
            session_unset(); 
            // destroy the session 
            session_destroy(); 
            // si page privée
            if (strpos($_SERVER['PHP_SELF'],'listeAdherents') >=0 ) {
                echo "<script type='text/javascript'>document.location.replace('index.php');</script>";
                /*header('Location: http://ja.de.pau.free.fr');
                exit();*/
            }
        } elseif (isset($_POST['connect'])) {
        // Cas de la connexion
            $servername = "sql.free.fr";
            $username = "ja.de.pau";
            $password = "Sq7:P@ss";   
            $dbname = "ja_de_pau";
            
            // Connexion à la BDD
            /*
            // Gestion des Injection SQL
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            // set the PDO error mode to exception
            //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // prepare sql and bind parameters
            $stmt = $conn->prepare("SELECT * FROM Utilisateur WHERE  login = :login AND mdp = :mdp");
            $stmt->bindParam(':login', $login);
            $stmt->bindParam(':mdp', $mdp);
            $login = $_POST["user"];
            $mdp = $_POST["pass"];
            $stmt->execute();
            if ($stmt->columnCount() > 0) {
                // Set session variables 
                $row = mysql_fetch_assoc($result);
                $_SESSION["user"] = $row["login"];
                $_SESSION["droits"] = $row["droits"];
            } else {
                // Afficher une erreur d'authentification
                echo "<div class='alert alert-danger'><strong>Erreur : </strong> Login ou mot de passe incorrect.</div>";
            }
           
            $conn = null;
            */
            // TODO : Injection SQL !!
            
            
            // Sans verification d'Injection SQL
            $db = connecterBDD($servername, $username, $password);
            mysql_select_db($dbname, $db);
            mysql_query("SET NAMES 'utf8'");
            //mysqli_set_charset($db, "utf8");
            $sql = "SELECT * FROM Utilisateur WHERE  login = '".$_POST["user"]."' AND mdp = '".$_POST["pass"]."'";
            $result = mysql_query($sql, $db) or exit(mysql_error() . "<br/>$sql");
            
            if (mysql_num_rows($result) > 0) {
                // Set session variables 
                $row = mysql_fetch_assoc($result);
                $_SESSION["user"] = $row["login"];
                $_SESSION["idUser"] = $row["idUtilisateur"];
                $_SESSION["droits"] = $row["droits"];
            } else {
                // Afficher une erreur d'authentification
                echo "<div class='alert alert-danger'><strong>Erreur : </strong> Login ou mot de passe incorrect.</div>";
            }
            deconnecterBDD($db);
            
        }
    } 

?>
<!-- Fonction de déconnexion -->
<script>
function deconnexion() {
    post(location.pathname.substring(1), {deconnect: true});
}

function post(path, params, method) {
    method = method || "post"; // Set method to post by default if not specified.

    // The rest of this code assumes you are not using a library.
    // It can be made less wordy if you use one.
    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);

    for(var key in params) {
        if(params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);

            form.appendChild(hiddenField);
         }
    }

    document.body.appendChild(form);
    form.submit();
}
</script>

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <ul class="nav navbar-nav">
            <li><a href="index.php">Accueil</a></li>
            <li><a href="presentationJA.php">Présentation JA </a></li>
            <li><a href="planning.php">Planning JA</a></li>
            <li><a href="badges.php">Badges </a></li>
        </ul>
        <?php 
            // si la personne n'est pas connecté
            if (empty($_SESSION["user"])) {
        ?>
        
        <ul class="nav navbar-nav navbar-right">
            <li><a href="#" data-toggle="modal" data-target="#login-modal"><span class="glyphicon glyphicon-log-in"></span> Connexion</a></li>
        </ul>
        <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                    <div class="loginmodal-container">
                            <h1>Connexion</h1><br>
                        <form id="connect" action="#" method="post">
                            <input type="text" name="user" placeholder="Nom d'utilisateur">
                            <input type="password" name="pass" placeholder="Mot de passe">
                            <input type="hidden" name="connect" value="true">
                            <input type="submit" name="login" class="login loginmodal-submit" value="Se connecter">
                        </form>
                            
                        <div class="login-help">
                            En cas de mot de passe oublié, contacter <a href="mailto:ja.de.pau@free.fr?subject=Connexion">Elisabeth</a>.
                        </div>
                    </div>
            </div>
        </div>
        <!-- Affecter la bonne action au formulaire pour rester sur la même page -->
        <script>
            document.getElementById("connect").action = location.pathname.substring(1);
        </script>
        <?php 
         } else {
        ?>
        <ul class="nav navbar-nav navbar-right">
            <li><a><span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION["user"]; ?></a></li>
            <li><a href="javascript:deconnexion()"><span class="glyphicon glyphicon-log-out"></span> Déconnexion</a></li>
        </ul>
        <?php
         }
        ?>
    </div>
</nav>



<!-- Affecter la classe "active" au bon <li> -->
<script>
    var lis = document.getElementsByTagName("li");
    var pageName = location.pathname.substring(1);
    var i ;
    for (i = 0; i < lis.length; i++) {
        if ( (lis[i].firstChild.href.indexOf(pageName) > 0) && (lis[i].firstChild.href.charAt(lis[i].firstChild.href.length-1) != '#')) {
            if (lis[i].parentNode.parentNode.className.indexOf("dropdown") >= 0) {
                lis[i].parentNode.parentNode.className += " active";
            }
        lis[i].className = "active";
        }
    }
</script>
