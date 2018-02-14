<?php
require 'src/Steffenf14/Art/ClippyArt.php';

$clippy = new Steffenf14\Art\Clippy();

print_r($clippy->getArt('Yo i\'m clippy! What would you like to do with me? I can display almost any nonsense.'));
print_r($clippy->getArt('I would love to point out some mistakes you make and provide you with even less helpful messages while distracting you from you anger.'));
print_r($clippy->getArt('If you want me to i can appear so often that people get annoyed and get that special old school feeling.' . PHP_EOL . 'You know what i mean.'));
$clippy->setMaxTextLength(47);
print_r($clippy->getArt('Did you know?' . PHP_EOL . PHP_EOL . 'I like to sing, dance, pretend and Kazooooo!!!'));
