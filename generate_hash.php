<?php
$options = [
  'memory_cost' => 1 << 16,
  'time_cost'   => 3,
  'threads'     => 2,
];
echo password_hash('flavio20', PASSWORD_ARGON2ID, $options);
