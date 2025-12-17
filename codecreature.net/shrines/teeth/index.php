<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../codefiles/PHPMailer/src/Exception.php';
require '../../codefiles/PHPMailer/src/PHPMailer.php';
require '../../codefiles/PHPMailer/src/SMTP.php';

if (array_key_exists('email', $_POST)) {
    $err = false;
    $msg = '';
    $email = '';
		// tooth info
		$quantity = '';
		$type = '';
		$gift = '';
		// envelope info
		$envelope = '';
		$length = '';
		$width = '';
		$height = '';
		$lengthUnit = '';
		$weight = '';
		$weightUnit = '';
		// mailing address
		$address = ''; // holds combined address string
		$addressname = '';
		$address1 = '';
		$city = '';
		$state = '';
		$zip = '';
		// credit display name/link
		$credit = '';
		$name = '';
		$link = '';
    //Apply some basic validation to the quantity
    if (array_key_exists('quantity', $_POST)) {
			$quantity = substr(strip_tags($_POST['quantity']), 0, 5);
		} else {
			$quantity = '';
		}
    //Apply some basic validation to the teeth type
    if (array_key_exists('type', $_POST)) {
			$type = substr(strip_tags($_POST['type']), 0, 255);
		} else {
			$type = '';
		}
    //Apply some basic validation and filtering to the gift-type
    if (array_key_exists('gift', $_POST)) {
			$gift = substr(strip_tags($_POST['gift']), 0, 255);
			if ($gift == "gift") {
				$gift = "Topolino's Gift";
			} elseif ($gift == "label") {
				$length = substr(strip_tags($_POST['length']), 0, 5);
				$width = substr(strip_tags($_POST['width']), 0, 5);
				$height = substr(strip_tags($_POST['height']), 0, 5);
				$lengthUnit = substr(strip_tags($_POST['lengthUnit']), 0, 5);
				$weight = substr(strip_tags($_POST['weight']), 0, 5);
				$weightUnit = substr(strip_tags($_POST['weightUnit']), 0, 5);
				$envelope = "Envelope: " . $length . " x " . $width . " x " . $height . " " . $lengthUnit . ", weighs " . $weight . $weightUnit;
				$gift = "Prepaid Shipping Label\n" . $envelope;
			} else {
				$gift = "Nothing";
			}
			$gift = "Requested in return: " . $gift;
		} else {
			$gift = 'Nothing';
		}
    //Apply some basic validation and filtering to the display name
    if (array_key_exists('name', $_POST)) {
			$name = substr(strip_tags($_POST['name']), 0, 255);
    } else {
			$name = 'Anonymous';
		}
		$subject = $name . ': I will give you my teeth';
		//Apply validation and filtering to the credit/display info
		if ( !array_key_exists('link', $_POST) ) {
			$credit = "Credit: " . $name;
		} else {
			$link = substr(strip_tags($_POST['link']), 0, 255);
			$credit = "Credit:\nDisplay name: " . $name . "\nCredit link: " . $link;
		}
    //Apply validation and filtering to the mailing address
		if (!array_key_exists('zip', $_POST)) {
			$address = 'No address given';
		} elseif ( !array_key_exists('addressname', $_POST) && !array_key_exists('city', $_POST) && !array_key_exists('state', $_POST) ) {
			$address = "ZIP code: " . substr(strip_tags($_POST['zip']), 0, 5);
		} else {
			if (array_key_exists('addressname', $_POST)) {
				$addressname = substr(strip_tags($_POST['addressname']), 0, 255);
			} else {
				$addressname = '(no name)';
			}
			// street address
			if (array_key_exists('address1', $_POST)) {
				$address1 = substr(strip_tags($_POST['address1']), 0, 255);
				// if address has a second line
				if (array_key_exists('address2', $_POST) && $_POST['address2'] != '') { $address1 = $address1 . "\n" . substr(strip_tags($_POST['address2']), 0, 255); }
			} else {
				$address1 = '(no street address)';
			}
			// city
			if (array_key_exists('city', $_POST)) {
				$city = substr(strip_tags($_POST['city']), 0, 255);
			} else {
				$city = '(no city)';
			}
			// state
			if (array_key_exists('state', $_POST)) {
				$state = substr(strip_tags($_POST['state']), 0, 255);
			} else {
				$state = '(no state)';
			}
			// zip code
			if (array_key_exists('zip', $_POST)) {
				$zip = substr(strip_tags($_POST['zip']), 0, 5);
			} else {
				$zip = '(no ZIP code)';
			}
			$address = "Address:\n" . $addressname . "\n" . $address1 . "\n" . $city . ", " . $state . " " . $zip; 
		}
    //Apply some basic validation and filtering to the notes section
		$notes = '';
    if (array_key_exists('notes', $_POST)) {
			$notes = "\n\nNotes:\n" . substr(strip_tags($_POST['notes']), 0, 1500);
    }
		
    //Validate to address
    //Never allow arbitrary input for the 'to' address as it will turn your form into a spam gateway!
    //Substitute appropriate addresses from your own domain, or simply use a single, fixed address
    $to = 'teeth@codecreature.net';
    //Make sure the address they provided is valid before trying to use it
    if (PHPMailer::validateAddress($_POST['email'])) {
        $email = $_POST['email'];
    } else {
        $msg .= 'Error: invalid email address provided';
        $err = true;
    }
    if (!$err) {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'localhost';
        $mail->Port = 25;
        $mail->CharSet = PHPMailer::CHARSET_UTF8;
        //It's important not to use the submitter's address as the from address as it's forgery,
        //which will cause your messages to fail SPF checks.
        //Use an address in your own domain as the from address, put the submitter's address in a reply-to
        $mail->setFrom('teeth@codecreature.net', (empty($name) ? 'Contact form' : $name));
        $mail->addAddress($to);
        $mail->addReplyTo($email, $name);
        $mail->Subject = $subject;
        $mail->Body = "Teeth form submission:\n\nWant to send: " . $quantity . " " . $type . " teeth\n" . $gift . "\n\n" . $address . "\n\n" . $credit . $notes;
        if (!$mail->send()) {
            $msg .= 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            $msg .= 'Message sent!';
        }
    }
} ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<title>topolino's teeth</title>
		<!-- favicon -->
		<link rel="icon" type="image/x-icon" href="favicon.ico">
		
		<!-- universal base javascript -->
		<script src="/codefiles/required.js?fileversion=20251216"></script>
		<!-- universal base css -->
		<link href="/codefiles/required.css?fileversion=20251216" rel="stylesheet" type="text/css"></link>
		
		<!-- load fonts --
		<script>fonts.load()</script>-->
		
		<!-- svg icons -->
		<script src="/graphix/svg-icons/svg-icons.js?fileversion=20251216" id="svg-icons-js"></script>
		<!-- page settings -->
		<script src="/codefiles/page-settings.min.js?fileversion=20251216"></script>
		
		<!--this page's stylesheet-->
		<link href="style.css?fileversion=20251216" rel="stylesheet" type="text/css" media="all">
		<!--this page's script(s)--
		<script src="script.js?fileversion=20251216"></script>-->
</head>
<body>
	<a class="skip-to-content" href="#content">skip to content</a>
		
		<nav><a href="/">return home</a></nav>
		
		<main>
			<header>
				<h2>teeth for topolino</h2>
				<p id="content">
					Burdened by too many teeth? Finally, the solution is here!
					<br>Send a tooth to Topolino, receive something in return.
				<p>
			</header>
			
			<!-- if form not already submitted -->
			<?php if (empty($msg)) { ?>
				<form id="contact-form" method="post">
					
					<section id="tooth-info">
						<h4>About Your Teeth</h4>
						<label for="tooth-type" class="required">What kind?</label>
						<select id="tooth-type" name="type" onchange="emailForm.updateToothType();" required>
							<option value="">(Select one)</option>
							<option value="human">Real Human</option>
							<option value="animal">Real Animal</option>
							<option value="fake">Sculpture (clay, fabric, etc)</option>
							<option value="digital">Digital Image</option>
						</select>
						<br>
						<label for="tooth-quantity">How many?</label>
						<input type="number" id="tooth-quantity" name="quantity" size="2" value="1">
						<br>
					</section>
					
					<section id="shipping-info">
					
						<label for="gift-type" class="required">What should I send you?</label>
						<br>
						<select id="gift-type" name="gift" onchange="emailForm.updateGiftType();">
							<option value="">(Select one)</option>
							<option value="gift">Gift from Topolino</option>
							<option value="label">Prepaid Shipping Label</option>
							<option value="nothing">Nothing</option>
						</select>
						
						<section id="envelope-info">
							<h4>Envelope Details</h4>
							<p>Pack your teeth in an envelope <b>first</b>, then measure the whole thing.</p>
							<label for="envelope-length" class="required">Dimensions:</label>
							<input type="number" step=".5" id="envelope-length" name="length" size="3">
							x
							<input type="number" step=".5" id="envelope-width" name="width" size="3">
							x
							<input type="number" step=".5" id="envelope-thickness" name="height" size="3">
							<select id="envelope-dimensions-type" name="lengthUnit">
								<option value="in">in</option>
								<option value="cm">cm</option>
							</select>
							<br>
							<label for="envelope-weight" class="required">Weight:</label>
							<input type="number" step=".5" id="envelope-weight" name="weight" size="3">
							<select id="envelope-weight-type" name="weightUnit">
								<option value="oz">oz</option>
								<option value="g">g</option>
							</select>
						</section>
						
						<section id="address-info">
							<h4>Address</h4>
							<p>
								If you only want a shipping label, nothing but the ZIP code is required.
								<br><i>USA only, sorry!</i>
							</p>
							
							<label for="address-name">Name:</label>
							<input type="text" id="address-name" name="addressname" maxlength="255">
							<br>
							
							<label for="address-1">Street Address:</label>
							<input type="text" id="address-1" name="address1" maxlength="255">
							<br>
							
							<label for="address-2">Apt/Suite/Other:</label>
							<input type="text" id="address-2" name="address2" maxlength="255">
							<br>
							
							<label for="address-city">City:</label>
							<input type="text" id="address-city" name="city" maxlength="255">
							<br>
							
							<label for="address-state">State:</label>
							<input type="text" id="address-state" name="state" maxlength="16">
							<br>
							
							<label for="address-zip" class="required">ZIP:</label>
							<input type="text" id="address-zip" name="zip" pattern="[0-9]{5}" title="5 digit ZIP code" maxlength="5">
							<br>
						</section>
						
					</section>
					
					<section id="your-info">
						<h4>Contact Info</h4>
						<label for="email" class="required">Email:</label>
						<input type="email" id="email" name="email" maxlength="255" required>
						<br>
						
						<p>Who should I credit for the teeth?</p>
						<label for="name">Display Name:</label>
						<input type="text" id="name" name="name" maxlength="255">
						<br>
						<label for="link">Website Link:</label>
						<input type="text" id="link" name="link" maxlength="255">
					</section>
					
					<label for="notes">Notes:</label>
					<br>
					<textarea id="notes" name="notes" maxlength="1500"></textarea>
					<br>

					<input type="submit" value="Submit">
				</form>
			<!-- if form already submitted, display result message -->
			<?php } else {
					echo $msg;
			} ?>

		</main>
		
		<script>
			const emailForm = {
				init: ()=>{
					emailForm.form = document.getElementById('contact-form');
					emailForm.toothType = document.getElementById('tooth-type');
					emailForm.giftType = document.getElementById('gift-type');
					emailForm.envelopeInfo = document.getElementById('envelope-info');
					emailForm.shippingInfo = document.getElementById('shipping-info');
					emailForm.addressInfo = document.getElementById('address-info');
					
					emailForm.updateAll();
				},
				// get label for given id
				getLabelFor: (id)=>{
					let r = null;
					var labels = document.getElementsByTagName('label');
					for (var i = 0; i < labels.length; i++) {
						if (labels[i].htmlFor == id) r = labels[i];
					}
					return r;
				},
				// make given input required or not based on "required" boolean parameter
				setRequired(inputId,required) {
					let input = document.getElementById(inputId);
					let label = emailForm.getLabelFor(inputId);
					if (required) {
						input.setAttribute('required','true');
						if (label) label.classList.add('required');
					} else {
						input.removeAttribute('required');
						if (label) label.classList.remove('required');
					}
				},
				// update the form according to current gift-type selection
				updateGiftType: ()=>{
					let v = emailForm.giftType.options[emailForm.giftType.selectedIndex].value;
					let envelope, address, fullAddress = false;
					
					// set which sections to show based on selection
					if (v == 'label') { envelope = true; address = true; }
					else if (v == 'gift') { address = true; fullAddress = true; }
					
					// if envelope info needed
					if (envelope) { emailForm.envelopeInfo.classList.remove('hidden'); }
					else { emailForm.envelopeInfo.classList.add('hidden'); }
					// set the correct required value for envelope info
					let eInputs = emailForm.envelopeInfo.getElementsByTagName('input');
					for (let i = 0; i < eInputs.length; i++) {
						if (envelope) emailForm.setRequired(eInputs[i].id,true);
						else emailForm.setRequired(eInputs[i].id,false);
					}
					
					// if address info needed
					if (address) { emailForm.addressInfo.classList.remove('hidden'); }
					else { emailForm.addressInfo.classList.add('hidden'); }
					// set the correct required value for address info
					let aInputs = emailForm.addressInfo.getElementsByTagName('input');
					for (let i = 0; i < aInputs.length; i++) {
						if ( address && (fullAddress || aInputs[i].id == 'address-zip') && aInputs[i].id != 'address-2' ) emailForm.setRequired(aInputs[i].id,true);
						else emailForm.setRequired(aInputs[i].id,false);
					}
				},
				// update the form according to current tooth-type selection
				updateToothType: ()=>{
					let v = emailForm.toothType.options[emailForm.toothType.selectedIndex].value;
					// if sending digital image only
					if (v == 'digital' || v == '') {
						emailForm.giftType.classList.add('hidden');
						emailForm.shippingInfo.classList.add('hidden');
					}
					// if sending physical object
					else {
						emailForm.giftType.classList.remove('hidden');
						emailForm.shippingInfo.classList.remove('hidden');
					}
				},
				updateAll: ()=>{
					emailForm.updateGiftType();
					emailForm.updateToothType();
				}
			}
			emailForm.init();
		</script>
</body>
</html>