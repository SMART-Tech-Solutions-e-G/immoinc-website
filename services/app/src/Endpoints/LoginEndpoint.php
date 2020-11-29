<?php

require_once("HTMLEndpoint.php");

class LoginEndpoint extends HTMLEndpoint
{
    public function render()
    {
?>
        <div class="login">
            <div class="login-form-wrapper">
                <h1>Anmelden</h1>
                <br>
                <form method="POST">
                    <div class="text-field">
                        <input id="login-email" type="email" name="email" required placeholder=" ">
                        <label for="login-email">E-Mail</label>
                    </div>
                    <div class="text-field">
                        <input type="password" name="password" required placeholder=" ">
                        <label for="login-email">Passwort</label>
                    </div>
                    <br><br>
                    <div class="button-black">
                        <input type="submit" value="Anmelden">
                    </div>
                </form>
                <?php if (isset($_GET["error"])) {
                ?>
                    <div class="error">Deine E-Mail oder dein Passwort ist leider inkorrekt.</div>
                <?php
                }
                ?>
            </div>
        </div>
<?php
    }
}
