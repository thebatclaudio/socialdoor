<?php
session_start();

if(!isset($_SESSION['loggedin']) OR $_SESSION['loggedin']!=1)
    header('location: login.php?error=1');

include "./includes/mysqlclass.class.php";
include "./includes/user.class.php";

$user = new user($_SESSION['user']);

include "header.php";

?>
<div id="container">
    <div id="header">
        <div id="right">
            <form action="search.php" method="post">
                <input type="text" id="search" name="search" placeholder="Cerca..." autocomplete="off">
            </form>
        </div>
        <div id="left">
            <a href="home.php" title="Torna alla home"> <img src="./css/img/logo.png" alt="SocialDoor" id="logo" /> </a>
        </div>
    </div>
    <h2 id='notifTitle'>Modifica i tuoi dati</h2><div id="div"></div>
    <div id="content" style="padding-top: 20px">
            <div style="float: right; padding: 40px 0px; text-align: center;">
                                         <form action="uploadPhoto.php" method="post" enctype="multipart/form-data" width="100px">
                            <img src="<?php if($user->getPic()==1) echo "./photos/".$user->getId().".jpg?imm=".rand(0,99999); else echo "./css/img/profile_photo.png"; ?>"><br />
                            <input type="file" name="upfile" id="upfile" />
                            <br />
                            <input type="submit" class="submitPhoto" value="Cambia foto" /><br />
                            <p>Solo JPEG, GIF e PNG</p>
                         </form>
                         <br /><br />
                         <ul>
                             <li style="text-align: left;"><a href="changePassword.php" style="text-decoration: underline;">Cambia password</a></li>
                         </ul>                         
            </div>
            <form action="saveData.php" method="post">
            <table summary="Registrazione" style="border-right: 1px solid #555; width: 430px">
                <tr>
                    <td><label>Nome:</label></td>
                    <td>
                    <input type="text" name="name" placeholder="<?php echo $user->getName(); ?>" />
                    </td>
                </tr>
                <tr>
                    <td><label>Cognome:</label></td>
                    <td>
                    <input type="text" name="surname" placeholder="<?php echo $user->getSurname(); ?>" />
                    </td>
                </tr>
                <tr>
                    <td><label>Indirizzo email:</label></td>
                    <td>
                    <input type="text" name="email" placeholder="<?php echo $user->getEmail(); ?>" />
                    </td>
                </tr>
                <tr>
                    <td><label>Citt&agrave;</label></td>
                    <td>
                    <input type="text" name="city" placeholder="<?php echo $user->getCity(); ?>" />
                    </td>
                </tr>
                <tr>
                    <td><label>Sesso:</label></td>
                    <td>
                    <select name="sex" style="font-size: 12px;">
                        <option value="0">Seleziona sesso:</option>
                        <option value="1">Uomo</option>
                        <option value="2">Donna</option>
                    </select></td>
                </tr>
                <tr>
                    <td><label>Data di nascita:</label></td>
                    <td>
                    <select name="dd" style="font-size: 12px;">
                        <option value="-1">Giorno:</option>
                        <?php
                        for ($i = 1; $i < 32; $i++) {
                            if ($i < 10) {
                                echo '<option       value="0' . $i . '">' . $i . '</option>';
                            } else {
                                echo '<option       value="' . $i . '">' . $i . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <select id="mese" name="mm" style="font-size: 12px;">
                        <option value="-1">Mese:</option>
                        <option value="01">Gennaio</option>
                        <option value="02">Febbraio</option>
                        <option value="03">Marzo</option>
                        <option value="04">Aprile</option>
                        <option value="05">Maggio</option>
                        <option value="06">Giugno</option>
                        <option value="07">Luglio</option>
                        <option value="08">Agosto</option>
                        <option value="09">Settembre</option>
                        <option value="10">Ottobre</option>
                        <option value="11">Novembre</option>
                        <option value="12">Dicembre</option>
                    </select>
                    <select name="yy" style="font-size: 12px;">
                        <option value="-1">Anno:</option>
                        <?php
                        for ($i = 1930; $i < date("Y") - 14; $i++) {
                            echo '<option value="' . $i . '">' . $i . '</option>';
                        }
                        ?>
                    </select></td>
                </tr>
                <tr>
                    <td><label>Lavoro:</label></td>
                    <td>
                       <input type="text" name="work" placeholder="<?php echo $user->getWork(); ?>" /> 
                    </td>
                </tr>
                <tr>
                <td><label>Sito web:</label></td>
                    <td>
                       <input type="text" name="website" placeholder="<?php if($user->getWebsite() != 'http://') echo $user->getWebsite(); ?>" /> 
                    </td>
                </tr>
                <tr>
                <td><label>Situazione sentimentale:</label></td>
                    <td>
                       <input type="text" name="relationship" placeholder="<?php echo $user->getRelationship(); ?>" /> 
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                    <input id="signupSubmit" class="doorbell" type="submit" value="Modifica" />
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
</div></body></html> 