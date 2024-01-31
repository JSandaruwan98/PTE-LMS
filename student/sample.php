<?php

$sentence1 = '';
$sentence2 = 'Plants play a crucial role in ecosystems, serving as a foundation and contributing to human well-being by providing resources such as food and medicine. In order to gain a deeper understanding of how plants can adapt and remain resilient in the face of challenges like climate change, scientists have developed an innovative mathematical model. ';

$words1 = array_map('strtolower', explode(" ", $sentence1));
$words2 = array_map('strtolower', explode(" ", $sentence2));


// Find additional words in sentence2
$additionalWords = array_diff($words2, $words1);

// Find missed words in sentence2
$missedWords = array_diff($words1, $words2);

print(implode(', ', $additionalWords));
