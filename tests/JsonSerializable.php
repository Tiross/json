<?php

// For test purpose only
// This interface does not exist on PHP 5.3
// http://php.net/manual/en/class.jsonserializable.php

if (!interface_exists('\JsonSerializable')) {
    interface JsonSerializable
    {
        public function jsonSerialize();
    }
}
