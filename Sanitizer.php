<?php


class Sanitizer
{


    // *************
    // Verification Methods
    // *************
    public function verifyPostalCode($postalcode, $country)
    {

        $regexPostalCode = '#[a-zA-Z]{1}[0-9]{1}[a-zA-Z]{1}([-| |]?){1}[0-9]{1}[a-zA-Z]{1}[0-9]{1}#';
        $regexZipCodeUS = '#[0-9]{5}([- /]?[0-9]{4})?#';
        if (preg_match($regexPostalCode, $postalcode) || $matchesZIP = preg_match($regexZipCodeUS, $postalcode)) {

            if (isset($matchesZIP) && $matchesZIP == true) {

                if ($country == "Canada") {

                    return false;

                }

            }
            // Postal or ZIP Code is fine
            return $this->sanPC($postalcode);

        } else {

            $sanPC = $this->sanPC($postalcode);
            // Check again to see if the postal code now matches after being sanitized.
            if (preg_match($regexPostalCode, $sanPC) || preg_match($regexZipCodeUS, $sanPC)) {

                return $sanPC;

            } // If it still doesn't match, return false. It won't be used to query for more data
            else {
                return FALSE;
            }

        }


    }

    // Strip all delimiting chars, only keep numbers

    public function verifyAddress($address)
    {
        $addressValRegex = array();
        $addressValRegex['address'] = '~^[0-9th]+[\-]?[0-9th]*[ ]*([a-zA-Z0-9\-\.]*[ ]?)*([0-9]*[ ]?)*$~';
        $addressValRegex['postalcode'] = '~([a-zA-Z]{1}[0-9]{1}[a-zA-Z]{1}([-| |]?){1}[0-9]{1}[a-zA-Z]{1}[0-9]{1})|([0-9]{5}([- /]?[0-9]{4})?)~';
        $addressValRegex['postofficebox'] = '~(([\s|\.|,]+p[\s|\.|,]+| post[\s|\.]*)(o[\s|\.|,]*| office[\s|\.]*))|(box[.|\s]*\d+)~i';
        $addressValRegex['invalidchars'] = '~[^a-zA-Z0-9#]~';

        switch ($address) {

            case (preg_match($addressValRegex['postofficebox'], $address) ? true : false):
                return false;
            default:
                if (preg_match($addressValRegex['invalidchars'], $address)) {

                    $sanitizedAddress = $this->sanAddress($address);

                    // Now that the address has been sanitized, check the format again.
                    if (preg_match($addressValRegex['address'], $sanitizedAddress)) {

                        // After being sanitized, the address is now in the proper format
                        // Return the now clean address
                        return $sanitizedAddress;

                    }

                } else {

                    return false;
                }


        }

    }

    public function isPostalCode($postalcode)
    {

        // Check to see if the postal code is a postal code.
        if (preg_match('~([a-zA-Z]{1}[0-9]{1}[a-zA-Z]{1}([-| |]?){1}[0-9]{1}[a-zA-Z]{1}[0-9]{1})|([0-9]{5}([- /]?[0-9]{4})?)~', $postalcode)) {
            // Postal code is a postal code so return that value
            return $postalcode;

        } else {
            // Is not postal code. Return false;
            return false;
        }


    }

    public function verifyPhoneNumber($phone)
    {


        /* Matches US phone number format. 1 in the beginning is optional,
        area code is required, spaces or dashes can be used as optional divider between number groups.
        Also alphanumeric format is allowed after area code.*/

        $regexPhoneVal = '~([0-9]( |-)?)?(\(?[0-9]{3}\)?|[0-9]{3})( |-)?([0-9]{3}( |-)?[0-9]{4}|[a-zA-Z0-9]{7})~';
        // Compare to regex
        if (preg_match($regexPhoneVal, $phone)) {

            $this->sanPC($phone);
            return TRUE;
        } else {
            return FALSE;
        }


    }


    // *************
    // Sanitize Methods
    // *************


    private function sanPC($pc)
    {

        $regexPCfilter = '#[^0-9a-zA-Z]#';
        $pc = preg_replace($regexPCfilter, '', $pc);
        $pc = strtolower($pc);

        return $pc;
    }


    public function sanPhone($phonenumber)
    {
        $regexPhoneChars = '/\D/u';

        // Check for invalid characters
        if (preg_match($regexPhoneChars, $phonenumber, $matches)) {
            // Strip non decimal characters
            $address = preg_replace($regexPhoneChars, '', $phonenumber);
        }

        // Return appropriate response
        return $regexPhoneChars;
    }

    public function sanAddress($address)
    {
        // Strip Everything but letters, numbers, and octothorp
        $addressRegex['invalidchars'] = '~[^a-zA-Z0-9#]~';
        $addressRegex['morespaces'] = "~[ ]{2,}~";
        // Find and replace based on the invalid chars regular expression
        $sanitizedAddress = preg_replace($addressRegex['invalidchars'], " ", $address);
        $evenMoreSanitizedAddress = preg_replace($addressRegex['morespaces'], " ", $sanitizedAddress);
        return $evenMoreSanitizedAddress;
    }

}

