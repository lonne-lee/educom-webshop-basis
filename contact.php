<?php
//initiate variables to collect form input
$salutation = $firstName = $lastName = $email = $phone = $street = $housenumber = $housenumberAddition = $postalcode = $city = $commPreference = $message = '';

$salutationErr = $firstNameErr = $lastNameErr = $emailErr = $phoneErr = $streetErr = $housenumberErr = $housenumberAdditionErr = $postalcodeErr = $cityErr = $commPreferenceErr = $messageErr = ''; //iniate variables to enter error messages

$emailRequired = $phoneRequired = $adressRequired = false;

$valid = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    function cleanString($string) {
        $string = trim($string);
        $string = stripslashes($string);
        $string = htmlspecialchars($string);
        return $string;
    }

    function getPostVar($key, $default=''){
        if(isset($_POST[$key])){
            return cleanString($_POST[$key]);
        }
        return $default;
    }

    $salutation = getPostVar('salutation');
    $firstName = getPostVar('firstName');
    $lastName = getPostVar('lastName');
    $commPreference = getPostVar('commPreference');
    $email = getPostVar('email');
    $phone = getPostVar('phone');
    $street = getPostVar('street');
    $housenumber = getPostVar('housenumber');
    $housenumberAddition = getPostVar('housenumberAddition');
    $postalcode = getPostVar ('postalcode');
    $city = getPostVar('city');
    $message = getPostVar('message');

    /*validate that salutation is selected */

    if(empty($firstName)) {
        $firstNameErr = "Voornaam is vereist";
    } else {
        if (!preg_match("/^[A-Za-zÀ-ÖØ-öø-ÿ\-\s]*$/",$firstName)) {
           $firstNameErr = "Alleen letters en spaties zijn toegestaan";
        }
    }

    if(empty($lastName)) {
        $lastNameErr = "Achternaam is vereist";
    } else {
        if (!preg_match("/^[A-Za-zÀ-ÖØ-öø-ÿ\-\s]*$/",$lastName)) {
            $lastNameErr = "Alleen letters en spaties zijn toegestaan";
        }
    }
    
 
    switch ($commPreference) {
        case "email":
            $emailRequired = true;
            break;
        case "phone":
            $phoneRequired = true;
            break;
        case "post":
            $adressRequired = true;
            break;
        case "";
            $commPreferenceErr = "Selecteer een communicatievoorkeur";
            break;
        default:
            $commPreferenceErr = "Onbekende communicatievoorkeur";
            break;

    }
    
    if(empty($email)){
        if($emailRequired){
            $emailErr = "E-mail is vereist";
        }
    } else {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $emailErr = "Ongeldig e-mailadres";
        }
    }

    if(empty($phone)){
        if($phoneRequired){
            $phoneErr = "Telefoonnummer vereist";
        }
    } else {
        if(!preg_match('/^[0-9]{10}$/', $phone)){
            $phoneErr = "Ongeldig telefoonnummer";
        }
    }

    if(!(
        empty($treet) && 
        empty($housenumber) &&
        empty($housenumberAddition) &&
        empty($postalcode) &&
        empty($city))
        
    ){
        $adressRequired = true;
    }

    if($adressRequired){
        if(empty($street)) {
            $streetErr = "Straatnaam is vereist";
        } else {
            if (!preg_match("/^[A-Za-zÀ-ÖØ-öø-ÿ]|\s*$/",$street)) {
                $streetErr = "Alleen letters en spaties zijn toegestaan";
            } //valideer geldige straatnaam//
        }
        

        if(empty($housenumber)) {
            $housenumberErr = "Huisnummer is vereist";
        } else {
            if(!preg_match('/^\d{0,6}$/', $housenumber)){
                $housenumberErr = "Alleen cijfers zijn toegestaan";
            }
            //valideer geldig huisnummer//

        } 

        if(!empty($housenumberAddition)) {
            if(!preg_match('/^\w{0,6}$/', $housenumberAddition)){
                $housenumberAdditionErr = "Ongeldige toevoeging";
            }
            //valideer geldige tekens//

        }

        if(empty ($postalcode)) {
         $postalcodeErr = "Postcode is vereist";
        } else {
            if(!preg_match('/^\d*[1-9]{1}[0-9]{3}\W*[a-zA-Z]{2}\W*$/', $postalcode)){
                $postalcodeErr = "Ongeldige postcode";
            } else {
                $cleanPostalcode = str_replace(" ", "", $postalcode);
                $uppercasePostalcode = strtoupper($cleanPostalcode);
                $postalcode = $cleanPostalcode;
            }
            //valideer geldige postcode

        }  

        if(empty($city)) {
            $cityErr = "Stad is vereist";
        } else {
            if (!preg_match("/^[A-Za-zÀ-ÖØ-öø-ÿ]*$/",$city)) {
                $cityErr = "Alleen letters en spaties zijn toegestaan";
            } //valideer geldige stadsnaam//
        }  
    }

    if(empty($message)) {
        $messageErr = "Bericht is vereist";
    } else {
        //validate appropriate length
    }
    
    //validate form
    if(empty($salutationErr)&&  empty($firstNameErr)&& empty($lastNameErr)&& empty($emailErr)&& empty($phoneErr)&& empty($streetErr)&& empty($housenumberErr)&& empty($housenumberAdditionErr)&& empty ($postalcodeErr)&& empty($cityErr)&& empty($commPreferenceErr)&& empty($messageErr)){
        $valid = true;
    }
    
}

if(!$valid){
    echo
    '<div class="content">
    <h1>Contact</h1>
    <h2>Contactformulier</h2>
    <form method="post" action="contact.php">

    <div>

        <label for="salutation">Aanhef:</label>
        <select id="salutation" name="salutation" required>
            <option value="">Maak een keuze</option>
            <option value="mrs" '; if(isset($salutation) && $salutation=="mrs") echo 'selected'; echo '>Mevr.</option>
            <option value="mr" '; if(isset($salutation) && $salutation=="mr") echo 'selected'; echo '>Dhr.</option>
            <option value="mx" '; if(isset($salutation) && $salutation=="mx") echo 'selected'; echo '>Mx.</option>
            <option value="undisclosed" '; if(isset($salutation) && $salutation=="undisclosed") echo 'selected'; echo '>Zeg ik liever niet</option>
        </select>';
                    echo '<span class="error">' . $salutationErr . '</span>
                </div> 
                <div>     
                    <label for="firstName">Voornaam:</label>
                    <input type="text" id="firstName" name="firstName" value=" ' . $firstName . '">
                    <span class="error">' . $firstNameErr . '</span>
                </div>
                <div>
                    <label for="lastName">Achternaam:</label>
                    <input type="text" id="lastName" name="lastName" value=" ' .  $lastName . ' ">
                    <span class="error"> ' . $lastNameErr . ' </span>
                </div> ';

                //<!--e-mail input-->
                echo '<div>
                    <label for="email">E-mail adres:</label>
                    <input type="email" id="email" name="email" value=" ' . $email . ' ">
                    <span class="error"> ' . $emailErr . ' </span>
                </div> ';
                //<!--telefoon input-->
                echo '<div>
                    <label for="phone">Telefoonnummer:</label>
                    <input type="tel" id="phone" name="phone" value=" ' . $phone . ' ">
                    <span class="error"> ' . $phoneErr . ' </span>
                </div> ';
                
                //<!--adres input-->
                echo '<fieldset>
                    <div>
                        <label for="street">Straatnaam:</label>
                        <input type="text" id="street" name="street" value=" ' . $street . ' ">
                        <span class="error"> ' . $streetErr . '</span>
                    </div>
                    <div>
                        <label for="housenumber">Huisnummer:</label>
                        <input type="text" id="housenumber" name="housenumber" value=" ' . $housenumber . ' ">
                        <span class="error"> ' .  $housenumberErr . ' </span>
                    </div>
                    <div>
                        <label for="housenumberAddition">Toevoegingen:</label> 
                        <input type="text" id="housenumberAddition" name="housenumberAddition" value=" ' . $housenumberAddition . ' ">
                        <span class="error"> ' . $housenumberAdditionErr . ' </span>
                    </div>
                    <div>
                        <label for="postalcode">Postcode:</label>
                        <input type="text" id="postalcode" name="postalcode" value=" ' . $postalcode . ' ">
                        <span class="error"> ' . $postalcodeErr . ' </span>
                    </div>
                    <div>
                        <label for="city">Stad:</label>
                        <input type="text" id="city" name="city" value=" ' . $city . ' ">
                        <span class="error"> ' . $cityErr . ' </span>
                    </div>
                </fieldset> ';
                
               // <!--communicatievoorkeur"-->
                
                echo '<div  class="radiobuttons">
                    <label for="commPreference">Communicatievoorkeur: </label>
                    <span class="error"> ' . $commPreferenceErr . ' </span>
                    <ul>
                        <li>
                            <input type="radio" id="commPreferenceEmail" name="commPreference" value="email" '; if($commPreference=="email") echo 'checked'; echo 'required>
                            <label for="commPreferenceEmail">E-mail</label>
                        </li>
                        <li>
                            <input type="radio" id="commPreferencePhone" name="commPreference" value="phone" '; if($commPreference=="phone") echo 'checked'; echo '
                            <label for="commPreferencePhone">Telefoon</label>
                        </li>
                        <li>
                            <input type="radio" id="commPreferencePost" name="commPreference" value="post" '; if($commPreference =="post") echo 'checked'; echo ' >
                            <label for="commPreferencePost">Post</label>
                        </li>
                    </ul>
                </div> ';
                
                // <!--Message input-->
                echo '<div>
                    <label for="message">Bericht</label>
                </div>
                <div>
                    <textarea name="message" rows="10" cols="30" placeholder="Type hier je bericht..."> ' . $message . ' </textarea>
                    <span class="error"> ' . $messageErr . ' </span>
                </div> ';
                //<!--Submit button-->
                echo '<input type="submit">
            </form> 
            </div>';

} else {
    echo '<div class="content">
        <block>
            <h2>Bedankt voor uw bericht</h2>
            <h3> Er zal zo snel mogelijk contact worden opgenomen via onderstaande contactgegevens:</h3>
            <p> Naam:' . $firstName . ' ' . $lastName . '</p>
            <p> E-mail: ' . $email . '</p>
            <p> Telefoon: ' . $phone . '</p>
            <p> Adres: ' . $street . ' ' . $housenumber . ' ' . $housenumberAddition . ' ' . $postalcode . ' ' . $city . '</p>
        </block>
        </div> 
    </div>';
};
?>