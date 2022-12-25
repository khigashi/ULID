# ULID
This class is a utility class that provides functions for generating and decoding ULIDs (Universally Unique Lexicographically Sortable Identifiers). ULIDs are unique identifiers that are used to identify resources in a distributed system. They are designed to be globally unique, sortable by timestamp, and portable between different systems.

The Ulid class provides a number of functions that are used to generate and decode ULIDs:

- **generate:** This function generates a new ULID by combining a timestamp and a random value, and encoding them using a base-32 encoding scheme.

- **encode:** This function encodes an integer value into a base-32 string.

- **getTimestamp:** This function generates a timestamp value for the ULID.

- **getRandom:** This function generates a random value for the ULID.

- **decode:** This function decodes a ULID back into its timestamp and random values.

- **decodePart:** This function decodes a part of a ULID (either the timestamp or the random value) into an integer.

- **isValid:** This function checks if it is a valid ULID by checking its length and the presence of only valid characters in the base-32 encoding scheme.

These functions can be used to generate unique identifiers that can be used to identify resources in a distributed system.


# Usage
```php
<?php
//generates a new ULID
$ulid = Ulid::generate(true);
echo $ulid . "\n"; // Outputs a ULID, e.g. "01D8X5H9C41E3QJZ08RY65K2V7MTUW4B"


// Decode a ULID back into its timestamp and random values
$decoded = Ulid::decode($ulid);
print_r($decoded);
// Outputs: Array ( [timestamp] => 1605846396825 [random] => 34890792831795 )

// You can validate ULIDs before inserting them into your database or using them in your application
if (Ulid::isValid($ulid)) {
    // The ULID is valid, do something with it
} else {
    // The ULID is invalid, handle the error
}

```
