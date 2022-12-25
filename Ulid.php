<?php
class Ulid
{
    /**
     * The base-32 encoding used to generate ULIDs.
     * Lowercase ULIDs are slightly smaller in terms of storage size, since they use 26 characters instead of 36. This could be a factor if you need to store a large number of ULIDs and are concerned about space efficiency.
     */
    
     const ENCODING = '0123456789abcdefghjkmnpqrstvwxyz';

     /**
      * Generates a new ULID.
      *
      * @return string The generated ULID.
      */
     public static function generate($uppercase = false): string
     {
         $timestamp = self::getTimestamp();
         $random = self::getRandom();
 
         $return = self::encode($timestamp, 10) . self::encode($random, 16);
 
         if($uppercase){
             return strtoupper($return);
         }
 
         return $return;
     }
 
     /**
      * Encodes an integer value into a base-32 string.
      *
      * @param int $number The integer value to be encoded.
      * @param int $padding The desired length of the encoded string.
      * @return string The encoded base-32 string.
      */
     protected static function encode(int $number, int $padding): string
     {
         $result = '';
 
         while ($number > 0) {
             $result = self::ENCODING[$number % 32] . $result;
             $number
             = (int)($number / 32);
         }
 
         return str_pad($result, $padding, '0', STR_PAD_LEFT);
     }
 
     /**
      * Generates a timestamp value for the ULID.
      *
      * @return int The timestamp value.
      */
     protected static function getTimestamp(): int
     {
         $microtime = microtime(true);
         return (int)($microtime * 1000) ;
     }
 
     /**
      * Generates a random value for the ULID.
      *
      * @return int The random value.
      */
     protected static function getRandom(): int
     {
         $bytes = random_bytes(8);
         $result = 0;
 
         for ($i = 0; $i < 8; $i++) {
             $result = ($result << 8) | ord($bytes[$i]);
         }
 
         return abs($result);
     }
 
     /**
      * Decodes a ULID into its timestamp and random values.
      *
      * @param string $ulid The ULID to be decoded.
      * @return array An array containing the decoded timestamp and random values.
      */
     public static function decode(string $ulid): array
     {
         $timestamp = self::decodePart($ulid, 0, 10);
         $random = self::decodePart($ulid, 10, 26);
 
         return [
             'timestamp' => $timestamp,
             'random' => $random,
         ];
     }
 
     /**
      * Decodes a part of a ULID into an integer.
      *
      * @param string $ulid The ULID to be decoded.
      * @param int $start The start position of the part to be decoded.
      * @param int $end The end position of the part to be decoded.
      * @return int The decoded integer value.
      * **/
 
      protected static function decodePart(string $ulid, int $start, int $end): int
     {
         $result = 0;
 
         for ($i = $start; $i < $end; $i++) {
             $result = ($result << 5) | strpos(self::ENCODING, $ulid[$i]);
         }
 
         return $result;
     }
 
     /**
      * Validates a ULID.
      *
      * @param string $ulid The ULID to be validated.
      * @return bool True if the ULID is valid, false otherwise.
      */
     public static function isValid(string $ulid): bool
     {
         if (strlen($ulid) !== 26) {
             return false;
         }
 
         for ($i = 0; $i < 26; $i++) {
             if (stripos(self::ENCODING, $ulid[$i]) === false) {
                 return false;
             }
         }
 
         return true;
     }
 }
